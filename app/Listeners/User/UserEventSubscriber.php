<?php

namespace App\Listeners\User;


use App\Events\User\UserLoginEvent;
use App\Events\User\UserLoginLogEvent;
use App\Services\Repositories\System\LoginLogRepo;
use Illuminate\Events\Dispatcher;
use JoyceZ\LaravelLib\Helpers\StrHelper;

class UserEventSubscriber
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * 登录成功，更新用户信息
     * Handle the event.
     */
    public function handleLogin(UserLoginEvent $event): void
    {
        $clientIp = StrHelper::ip2long(request()->ip());
        $nowTime = now()->timestamp;
        $user = $event->userModel;
        $user->update([
            'refresh_time' => $nowTime,
            'refresh_ip' => $clientIp,
            'last_login_ip' => $clientIp,
            'updated_at' => $nowTime,
            'last_login_time' => $nowTime
        ]);
    }

    /**
     * 登录之后，记录用户登录日志
     * @param UserLoginLogEvent $event
     * @return void
     */
    public function handleLoginLog(UserLoginLogEvent $event): void
    {
        $user = $event->userModel;
        $request = request();
        $clientIp = StrHelper::ip2long($request->ip());
        $loginLogRepo = app(LoginLogRepo::class);
        $loginLogRepo->create([
            'user_id' => $user->user_id,
            'username' => $user->username,
            'user_ip' => $clientIp,
            'user_agent' => $request->server('HTTP_USER_AGENT'),
            'from_app' => $event->fromApp,
            'result' => $event->msg,
            'tenant_id' => $user->tenant_id
        ]);
    }

    /**
     * 为订阅者注册侦听器。
     * @param Dispatcher $events
     * @return void
     */
    public function subscribe(Dispatcher $events): void
    {
        $events->listen(UserLoginEvent::class, [
            UserEventSubscriber::class, 'handleLogin'
        ]);

        $events->listen(UserLoginLogEvent::class, [
            UserEventSubscriber::class, 'handleLoginLog'
        ]);
    }
}
