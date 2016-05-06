<?php namespace Glue\Plates;

use League\Plates\Engine;
use Glue\Interfaces\TemplateEngineInterface;

class Plates implements TemplateEngineInterface
{
    /**
     * @var Leage\Plates\Engine
     */
    protected $engine;


    /**
     * @param League\Plates\Engine
     */
    public function __construct(Engine $engine)
    {
        $this->engine = $engine;
    }


    /**
     * Add a template folder
     * 
     * @param string $path       Absolute path to folder
     * @param string $namespace  Prefixed name
     */
    public function addTemplateFolder($path, $namespace = null)
    {
        $this->engine->addFolder($namespace, $path);
    }
    
    
    /**
     * Render a template
     * 
     * @param  string $template
     * @param  array  $params
     * @return string
     */
    public function render($template, array $params = [])
    {
        return $this->engine->render($template, $params);
    }
    
    
    /**
     * Add global variables for all templates
     * 
     * @param array $data
     */
    public function sharedData(array $data = [])
    {
        $this->engine->addData($data);
    }
}