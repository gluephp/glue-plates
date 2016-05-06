<?php namespace Glue\Plates\Extensions;

use Glue\Http\Request;
use Glue\Router\Router;
use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;
use League\Plates\Extension\URI;

class UrlHelpers implements ExtensionInterface
{
    /**
     * @var Glue\Router\Router
     */
    protected $router;

    /**
     * @var Glue\Http\Request
     */
    protected $request;


    /**
     * @param Glue\Router\Router $request
     * @param Glue\Http\Request  $router
     */
    public function __construct(Request $request, Router $router)
    {
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
        
        // Custom functions
        $engine->registerFunction('route', [$this, 'route']);
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


}