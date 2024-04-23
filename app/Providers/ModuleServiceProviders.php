<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class ModuleServiceProviders extends ServiceProvider
{

    public function boot(): void
    {
        $this->registerModuleServiceProviders();
        $this->mapModulesApiRoutes();
        $this->mapModulesWebRotes();
    }

    /**
     * 获取所有模块服务
     * @return array
     */
    private function listModuleServiceProviders(): array
    {
        $modules = config('landao.module');
        $records = [];
        foreach ($modules as $module) {
            $provider = "\\Module\\$module\\Providers\\ModuleServiceProvider";
            if (class_exists($provider)) {
                $records[] = $provider;
            }
        }
        return $records;
    }

    /**
     * 注册多模块的服务
     * @return void
     */
    private function registerModuleServiceProviders(): void
    {
        $providers = $this->listModuleServiceProviders();
        if ($providers) {
            foreach ($providers as $provider) {
                $this->app->register($provider);
            }
        }
    }

    /**
     * 加载模块Api路由
     * @return void
     */
    protected function mapModulesApiRoutes(): void
    {
        $modules = config('landao.module');
        foreach ($modules as $module) {
            if (file_exists($path = $this->getModulePath($module) . '/Routes/api.php')) {
                $module = Str::lower($module);
                Route::prefix('app/' . $module)
                    ->middleware('api')
                    ->name('app:' . $module . ":")
                    ->group($path);
            }
        }
    }

    /**
     * 加载模块web路由
     * @return void
     */
    protected function mapModulesWebRotes(): void
    {
        $modules = config('landao.module');
        foreach ($modules as $module) {
            if (file_exists($path = $this->getModulePath($module) . '/Routes/web.php')) {
                $module = Str::lower($module);
                Route::prefix('app/' . $module)
                    ->middleware('web')
                    ->name('app:' . $module . ":")
                    ->group($path);
            }
        }
    }

    /**
     * 获取模块路径
     * @param $module
     * @return string
     */
    protected function getModulePath($module): string
    {
        return base_path('module/' . $module);
    }

}
