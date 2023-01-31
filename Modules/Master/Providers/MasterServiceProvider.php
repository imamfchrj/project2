<?php

namespace Modules\Master\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\Jib\Repositories\Admin\BudgetRepository as AdminBudgetRepository;
use Modules\Master\Repositories\Admin\Interfaces\CustomerRepositoryInterface;
use Modules\Master\Repositories\Admin\CustomerRepository;
use Modules\Master\Repositories\Admin\Interfaces\AnggaranRepositoryInterface;
use Modules\Master\Repositories\Admin\AnggaranRepository;
use Modules\Master\Repositories\Admin\Interfaces\JenisRepositoryInterface;
use Modules\Master\Repositories\Admin\JenisRepository;
use Modules\Master\Repositories\Admin\Interfaces\KategoriRepositoryInterface;
use Modules\Master\Repositories\Admin\KategoriRepository;
use Modules\Master\Repositories\Admin\Interfaces\KesimpulanRepositoryInterface;
use Modules\Master\Repositories\Admin\KesimpulanRepository;
use Modules\Master\Repositories\Admin\Interfaces\RisikoRepositoryInterface;
use Modules\Master\Repositories\Admin\RisikoRepository;
use Modules\Master\Repositories\Admin\Interfaces\SegmentRepositoryInterface;
use Modules\Master\Repositories\Admin\SegmentRepository;
use Modules\Master\Repositories\Admin\Interfaces\StatusRepositoryInterface;
use Modules\Master\Repositories\Admin\StatusRepository;
use Modules\Master\Repositories\Admin\Interfaces\PemeriksaRepositoryInterface;
use Modules\Master\Repositories\Admin\PemeriksaRepository;
use Modules\Master\Repositories\Admin\Interfaces\BudgetRepositoryInterface;
use Modules\Master\Repositories\Admin\BudgetRepository;

class MasterServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Master';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'master';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));
        $this->registerRepositories();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            module_path($this->moduleName, 'Config/config.php') => config_path($this->moduleNameLower . '.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path($this->moduleName, 'Config/config.php'), $this->moduleNameLower
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/' . $this->moduleNameLower);

        $sourcePath = module_path($this->moduleName, 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ], ['views', $this->moduleNameLower . '-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/' . $this->moduleNameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
        } else {
            $this->loadTranslationsFrom(module_path($this->moduleName, 'Resources/lang'), $this->moduleNameLower);
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (\Config::get('view.paths') as $path) {
            if (is_dir($path . '/modules/' . $this->moduleNameLower)) {
                $paths[] = $path . '/modules/' . $this->moduleNameLower;
            }
        }
        return $paths;
    }

    private function registerRepositories()
    {
        $this->app->bind(
            CustomerRepositoryInterface::class,
            CustomerRepository::class
        );

        $this->app->bind(
            AnggaranRepositoryInterface::class,
            AnggaranRepository::class
        );

        $this->app->bind(
            JenisRepositoryInterface::class,
            JenisRepository::class
        );

        $this->app->bind(
            KategoriRepositoryInterface::class,
            KategoriRepository::class
        );

        $this->app->bind(
            KesimpulanRepositoryInterface::class,
            KesimpulanRepository::class
        );

        $this->app->bind(
            RisikoRepositoryInterface::class,
            RisikoRepository::class
        );

        $this->app->bind(
            SegmentRepositoryInterface::class,
            SegmentRepository::class
        );

        $this->app->bind(
            StatusRepositoryInterface::class,
            StatusRepository::class
        );

        $this->app->bind(
            PemeriksaRepositoryInterface::class,
            PemeriksaRepository::class
        );

        $this->app->bind(
            BudgetRepositoryInterface::class,
            BudgetRepository::class
        );

    }
}
