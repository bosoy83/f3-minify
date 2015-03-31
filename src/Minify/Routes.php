<?php
namespace Minify;

class Routes extends \Dsc\Routes\Group
{

    public function initialize()
    {
        $this->app->route('GET /minify/css', '\Minify\Controller->css');
        $this->app->route('GET /minify/js', '\Minify\Controller->js');
        $this->app->route('GET /minify/*', '\Minify\Controller->item');
        $this->app->route('GET /admin/minify/css', '\Minify\Controller->css');
        $this->app->route('GET /admin/minify/js', '\Minify\Controller->js');
        $this->app->route('GET /admin/minify/*', '\Minify\Controller->item');
                
        /*
        if ($this->app->get('DEBUG') || $this->input->get('refresh', 0, 'int')) 
        {
            $this->app->route('GET /minify/css', '\Minify\Controller->css');
            $this->app->route('GET /minify/js', '\Minify\Controller->js');
            $this->app->route('GET /minify/*', '\Minify\Controller->item');
            $this->app->route('GET /admin/minify/css', '\Minify\Controller->css');
            $this->app->route('GET /admin/minify/js', '\Minify\Controller->js');
            $this->app->route('GET /admin/minify/*', '\Minify\Controller->item');
            
        }
        else 
        {
            $cache_period = 3600*24;
            
            $this->app->route('GET /minify/css', '\Minify\Controller->css', $cache_period);
            $this->app->route('GET /minify/js', '\Minify\Controller->js', $cache_period);
            $this->app->route('GET /minify/*', '\Minify\Controller->item');
            $this->app->route('GET /admin/minify/css', '\Minify\Controller->css');
            $this->app->route('GET /admin/minify/js', '\Minify\Controller->js');
            $this->app->route('GET /admin/minify/*', '\Minify\Controller->item');
        }
        */
    }
}