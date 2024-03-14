<?php

namespace App\Http\Controllers\Tenant\V1;

use App\Events\User\UserLoginEvent;
use App\Events\User\UserLoginLogEvent;
use App\Http\Controllers\ApiController;
use App\Http\Requests\Passport\LoginRequest;
use App\Services\Repositories\User\UserRepo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\RateLimiter;
use JoyceZ\LaravelLib\Contracts\Captcha as CaptchaInterface;
use JoyceZ\LaravelLib\Helpers\ResultHelper;

class Passport extends ApiController
{
    /**
     * 图片验证码
     * @param CaptchaInterface $captchaRepo
     * @return JsonResponse
     */
    public function captcha(CaptchaInterface $captchaRepo): JsonResponse
    {
        //限流，每分钟只能请求5次
        if (RateLimiter::tooManyAttempts('request-captcha:' . request()->ip(), $perMinute = 5)) {
            return $this->badSuccessRequest('请求次数太频繁');
        }
        $captcha = $captchaRepo->makeCode()->get();
        $captchaImg = Arr::get($captcha, 'image', '');
        $captchaUniqId = Arr::get($captcha, 'uniq', '');
        return $this->success([
            'captcha' => $captchaImg,
            config('landao.passport.check_captcha_cache_key') => $captchaUniqId
        ]);
    }

    /**
     * 用户登录
     * @param LoginRequest $request
     * @param CaptchaInterface $captchaRepo
     * @param UserRepo $userRepo
     * @return JsonResponse
     */
    public function login(LoginRequest $request, CaptchaInterface $captchaRepo, UserRepo $userRepo): JsonResponse
    {
        $params = $request->all();
        //图形验证码校验
        $captchaUniq = $params[config('landao.passport.check_captcha_cache_key')];
//        if (!$captchaRepo->check($params['verify_code'], $captchaUniq)) {
//            return $this->badSuccessRequest('验证码错误');
//        }
        $user = $userRepo->getUserByMobile($params['username']);
        if (!$user) {
            return $this->badSuccessRequest('账号不存在');
        }
        $formApp = 'PC';
        $userRet = $userRepo->doLogin($user, $params['password'], $captchaUniq, $formApp);
        //登录日志
        event(new UserLoginLogEvent($user, $userRet['message'], $formApp));
        if ($userRet['code'] == ResultHelper::CODE_SUCCESS) {
            //登录成功，更新用户信息
            event(new UserLoginEvent($user));
            return $this->success($userRet['data'], $userRet['message']);
        }
        return $this->badSuccessRequest($userRet['message']);
    }

    /**
     * 退出登录
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $user = $request->user();
        $message = '退出成功';
        event(new UserLoginLogEvent($user, $message));
        //撤销当前请求令牌
        $user->currentAccessToken()->delete();
        return $this->successRequest($message);
    }
}
