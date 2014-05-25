<?php
namespace Minify;

class Routes extends \Dsc\Routes\Group
{

    public function initialize()
    {
        $f3 = \Base::instance();
        
        $this->setDefaults(array(
            'namespace' => '\Minify',
            'url_prefix' => '/minify'
        ));

        if ($f3->get('CACHE') && !$f3->get('DEBUG')) 
        {
            $f3->route( 'GET /minify/css', '\Minify\Controller->css', 3600*24 );
            $f3->route( 'GET /minify/js', '\Minify\Controller->js', 3600*24 );
        } 
        else 
        {
            $this->add('/css', 'GET', array(
                'controller' => 'Controller',
                'action' => 'css'
            ));
            
            $this->add('/js', 'GET', array(
                'controller' => 'Controller',
                'action' => 'js'
            ));
        }
        
        $this->add('/*', 'GET', array(
            'controller' => 'Controller',
            'action' => 'item'
        ));
    }
}