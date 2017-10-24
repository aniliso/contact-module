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
        $this->registerFacade();
        $this->registerWidgets();

        $this->app->register(\Cornford\Googlmapper\MapperServiceProvider::class);

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

    private function registerFacade()
    {
        $aliasLoader = AliasLoader::getInstance();
        $aliasLoader->alias('Contact', 'Modules\Contact\Facades\ContactFacade');
    }

    private function registerWidgets()
    {
        \Widget::register('gmap', function ($height, $zoom, $marker='') {
            if(setting('theme::address')) {
                if(!$map = \Cache::get('contact.map')) {
                    \Mapper::setLanguage(locale());
                    \Mapper::setRegion('TR');
                    if($marker) {
                        \Mapper::setIcon(\Theme::url($marker));
                    }
                    \Mapper::setAnimation('DROP');
                    $location = \Mapper::location(strip_tags(setting('theme::address')));
                    $location->map([
                        'height'            => $height,
                        'zoom'              => $zoom,
                        'async'             => true,
                        'center'            => true,
                        'marker'            => true,
                        'type'              => 'ROADMAP',
                        'draggable'         => false,
                        'scrollWheelZoom'   => false,
                        'fullscreenControl' => false,
                        'zoomControl'       => false,
                        'streetViewControl' => false,
                        'content'           => setting('theme::company-name')."<br/>".setting('theme::address'),
                        'markers'           => [
                            'title' => setting('theme::company-name')
                        ]
                    ]);
                    $map = \Mapper::render();
                    \Cache::put('contact.map', $map, 3600);
                }
                return $map;
            }
        });
    }
}
