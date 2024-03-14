<?php
declare(strict_types=1);

namespace App\Services\Repositories\User;

use App\Services\Enums\User\UserStatusEnum;
use App\Support\CryptoJsSup;
use JoyceZ\LaravelLib\Helpers\ResultHelper;
use JoyceZ\LaravelLib\Repositories\BaseRepository;
use App\Services\Models\User\UserModel;
use JoyceZ\LaravelLib\Security\AopPassword;
use JoyceZ\LaravelLib\Security\AopSecurity;

/**
 * 请说明具体哪块业务的 Repository 接口实现
 *
 * @author joyecZhang <https://qilindao.github.io/docs/backend/>
 *
 * Class UserRepo
 * @package App\Services\Repositories\User;
 */
class UserRepo extends BaseRepository
{

    /**
     * @return string
     */
    public function model()
    {
        return UserModel::class;
    }

    /**
     * 通过手机号查询用户
     * @param string $mobile
     * @return UserModel|null
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \JoyceZ\LaravelLib\Exceptions\RepositoryException
     */
    public function getUserByMobile(string $mobile): UserModel|null
    {
        return $this->findByField('mobile', (new AopSecurity())->withScrectKey()->encrypt($mobile));
    }

    /**
     * 用户登录
     * @param array $params
     * @param string $captchaUniq
     * @param string $fromApp
     * @return array
     */
    /**
     * 用户登录
     * @param UserModel $user 用户模型
     * @param string $pwd 登录密码
     * @param string $captchaUniq 图片验证码唯一表示
     * @param string $fromApp 应用端来源
     * @return array
     */
    public function doLogin(UserModel $user, string $pwd, string $captchaUniq, string $fromApp = 'PC'): array
    {

        //临时修改可见属性，用于校验登录密码
        $userInfo = $user->makeVisible(['password', 'pwd_salt'])->toArray();
        //将前端加密的密码进行解密
        $password = $pwd;//(new CryptoJsSup($captchaUniq))->decrypt($pwd);
        //密码验证
        $pwdFlag = (new AopPassword())
            ->withSalt()
            ->check($userInfo['password'], $password, (string)$userInfo['pwd_salt']);
        if (!$pwdFlag) {
            return ResultHelper::error('账号或者密码错误');
        }
        if (!$user->is_enable) {
            return ResultHelper::error('账号异常');
        }
        //已离职员工
        if (intval($userInfo['status']) == UserStatusEnum::USER_DEPART) {
            return ResultHelper::error('用户已离职');
        }
        $token = $user->createToken($fromApp . '_TENANT_TOKEN')->plainTextToken;
        //监听用户登录成功
        return ResultHelper::success('登录成功', [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => config('sanctum.expiration')
        ]);
    }
}
