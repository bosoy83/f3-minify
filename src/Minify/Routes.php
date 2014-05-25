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

        $this->add('/css', 'GET', array(
            'controller' => 'Controller',
            'action' => 'css'
        ));
        
        $this->add('/js', 'GET', array(
            'controller' => 'Controller',
            'action' => 'js'
        ));
        
        $this->add('/*', 'GET', array(
            'controller' => 'Controller',
            'action' => 'item'
        ));
    }
}