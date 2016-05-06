<?php namespace Glue\Plates;

use Glue\App;
use Glue\Interfaces\ServiceProviderInterface;
use League\Plates\Engine;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(App $glue)
    {
        $glue->singleton('League\Plates\Engine', function($glue) {
            
            if (!$glue->config->exists('plates.path')) {
                // We need a default template folder
                throw new \Exception("You must configure the plates.path");
            }

            $engine = new Engine($glue->config->get('plates.path'));

            // Register some extensions
            $engine->loadExtension($glue->make('Glue\Plates\Extensions\UrlHelpers'));

            return $engine;

        });

        $glue->alias('League\Plates\Engine', 'plates');
    }
}