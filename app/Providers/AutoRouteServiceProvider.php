<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use ReflectionClass;

class AutoRouteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerAutoRoutes();
    }

    public function registerAutoRoutes()
{
    $controllerNamespace = 'App\\Http\\Controllers\\';
    $controllersPath = app_path('Http/Controllers');

    foreach (scandir($controllersPath) as $file) {
        if (Str::endsWith($file, 'Controller.php')) {
            $controllerClass = $controllerNamespace . pathinfo($file, PATHINFO_FILENAME);

            $reflection = new ReflectionClass($controllerClass);
            foreach ($reflection->getMethods() as $method) {
                if ($method->isPublic() && !$method->isConstructor()) {
                    $methodName = $method->getName();

                    // Build route URL based on the controller and method name
                    $routeUrl = Str::kebab(str_replace('Controller', '', $reflection->getShortName())) . '/' . Str::kebab($methodName);

                    // Tambahkan segmen dinamis jika ada parameter pada metode, dan tidak diawali dengan 'aksi' atau 'get'
                    if ($method->getNumberOfParameters() > 0 && !Str::startsWith($methodName, ['aksi', 'get'])) {
                        $routeUrl .= '/{id}'; // Menggunakan {id} sebagai parameter dinamis
                    }

                    // Tambahkan rute berdasarkan nama method
                    if (Str::startsWith($methodName, 'aksi')) {
                        Route::post($routeUrl, [$controllerClass, $methodName])->middleware('web');
                    } else {
                        Route::get($routeUrl, [$controllerClass, $methodName])->middleware('web');
                    }
                }
            }
        }
    }
}
    
    
}

