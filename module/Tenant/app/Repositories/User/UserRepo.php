<?php
declare(strict_types=1);

namespace Module\Tenant\Repositories\User;

use Illuminate\Support\Facades\Crypt;
use LanDao\LaravelCore\Helpers\ResultHelper;
use LanDao\LaravelCore\Repositories\BaseRepository;
use LanDao\LaravelCore\Security\AopCryptoJs;
use LanDao\LaravelCore\Security\AopSecurity;
use Module\Tenant\Enums\User\UserStatusEnum;
use Module\Tenant\Models\User\UserModel;


/**
 * 用户业务逻辑 Repository 接口实现
 *
 * @author joyecZhang <https://qilindao.github.io/docs/backend/>
 *
 * Class UserRepo
 * @package Module\Tenant\Repositories
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
     * @throws \LanDao\LaravelCore\Exceptions\RepositoryException
     */
    public function getUserByMobile(string $mobile): UserModel|null
    {
        return $this->findByField('mobile', (new AopSecurity())->withScrectKey()->encrypt($mobile));
    }

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
        $password = (new AopCryptoJs($captchaUniq))->decrypt($pwd);
        //密码验证
//        $pwdFlag = (new AopPassword())
//            ->withSalt()
//            ->check($userInfo['password'], $password, (string)$userInfo['pwd_salt']);
        $pwdSalt = (string)$userInfo['pwd_salt'];

        if (Crypt::decryptString($userInfo['password']) != ($password . $pwdSalt)) {
            return ResultHelper::error('账号或者密码错误');
        }
        if (!$user->is_enable) {
            return ResultHelper::error('账号异常');
        }
        //已离职员工
        if (intval($userInfo['status']) == UserStatusEnum::USER_DEPART->value) {
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
