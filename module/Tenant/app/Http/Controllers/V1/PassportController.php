<?php

namespace Module\Tenant\Http\Controllers\V1;

use App\Events\User\UserLoginEvent;
use App\Events\User\UserLoginLogEvent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\RateLimiter;
use LanDao\LaravelCore\Attributes\Router\Get;
use LanDao\LaravelCore\Attributes\Router\Post;
use LanDao\LaravelCore\Controllers\ApiController;
use LanDao\LaravelCore\Helpers\ResultHelper;
use LanDao\LaravelCore\Services\Captcha\Image\Captcha as CaptchaInterface;
use Module\Tenant\Http\Requests\Passport\LoginRequest;
use Module\Tenant\Repositories\User\UserRepo;

/**
 * 用户登陆登出相关
 */
class PassportController extends ApiController
{
    /**
     * 图片验证码
     * @param CaptchaInterface $captchaRepo
     * @return JsonResponse
     */
    #[Get(uri: '/passport/captcha', name: 'passport.captcha')]
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
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \LanDao\LaravelCore\Exceptions\RepositoryException
     */
    #[Post(uri: '/passport/login', name: 'passport.login')]
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
    #[Post(uri: '/passport/logout', name: 'passport.logout', middleware: ['auth:sanctum', 'auth.tenant', 'userOperate.log'])]
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
