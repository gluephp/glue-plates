<?php namespace Glue\Plates\Extensions;

use Glue\Config\Config;
use Glue\Http\Request;
use Glue\Router\Router;
use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;
use League\Plates\Extension\URI;

class UrlHelpers implements ExtensionInterface
{
    /**
     * @var Glue\Config\Config
     */
    protected $config;

    /**
     * @var Glue\Router\Router
     */
    protected $router;

    /**
     * @var Glue\Http\Request
     */
    protected $request;


    /**
     * @param Glue\Config\Config $config
     * @param Glue\Router\Router $request
     * @param Glue\Http\Request  $router
     */
    public function __construct(Config $config, Request $request, Router $router)
    {
        $this->config  = $config;
        $this->request = $request;
        $this->router  = $router;
    }


    /**
     * @param  Engine $engine
     */
    public function register(Engine $engine)
    {
        // Load the built in URI extension
        $engine->loadExtension(new URI($this->request->getPathInfo()));

        // Custom methods
        $engine->registerFunction('route', [$this, 'route']);
        $engine->registerFunction('asset', [$this, 'asset']);
    }


    /**
     * Resolve a named route
     *
     * @param  string  $name
     * @param  array   $params
     * @param  boolean $absolute    Return an absolute path
     * @return string|null
     */
    public function route($name, array $params = [], $absolute = false)
    {
        $route = $this->router->route($name, $params);
        return $absolute
            ? $this->request->getSchemeAndHttpHost() . $route
            : $route;
    }


    /**
     * Get asset path
     *
     * @param  string $filename
     * @return string
     */
    public function asset($filename = null)
    {
        $path = rtrim($this->config->get('plates.assets'), '/');

        if ($path && strpos($path, '://') === false && strpos($path, '//') !== 0) {
            $path = '/' . ltrim($path, '/');
        }

        $filename = ltrim($filename, '/');
        if (!$filename) {
            return $path;
        }

        return $path . '/' . $filename;
    }
}
