<?php namespace Modules\Contact\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Modules\Contact\Entities\Contact;
use Modules\Contact\Events\Handlers\RegisterContactSidebar;
use Modules\Contact\Repositories\Cache\CacheContactDecorator;
use Modules\Contact\Repositories\Eloquent\EloquentContactRepository;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Foundation\Theme\Theme;
use Modules\Core\Traits\CanGetSidebarClassForModule;
use Modules\Core\Traits\CanPublishConfiguration;

class ContactServiceProvider extends ServiceProvider
{
    use CanPublishConfiguration, CanGetSidebarClassForModule;
    /**
     * Indicates if loading of the provider is deferred.
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     * @return void
     */
    public function register()
    {
        $this->registerBindings();

        $this->app->register(\Cornford\Googlmapper\MapperServiceProvider::class);

        $aliasLoader = AliasLoader::getInstance();
        $aliasLoader->alias('Mapper', \Cornford\Googlmapper\Facades\MapperFacade::class);

        $this->app->extend('asgard.ModulesList', function($app) {
            array_push($app, 'contact');
            return $app;
        });

        $this->app['events']->listen(
            BuildingSidebar::class,
            $this->getSidebarClassForModule('contact', RegisterContactSidebar::class)
        );
    }

    public function boot()
    {
        $this->publishConfig('contact', 'permissions');
        $this->publishConfig('contact', 'config');
        $this->publishConfig('contact', 'settings');
        //$this->publishConfig('contact', 'assets');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    /**
     * Get the services provided by the provider.
     * @return array
     */
    public function provides()
    {
        return [];
    }

    private function registerBindings()
    {
        $this->app->bind(
            'Modules\Contact\Repositories\ContactRepository',
            function () {
                $repository = new EloquentContactRepository(new Contact());
                if (!config('app.cache')) {
                    return $repository;
                }
                return new CacheContactDecorator($repository);
            }
        );
    }
}
