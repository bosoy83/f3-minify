<?php
class MinifyBootstrap extends \Dsc\Bootstrap
{
    protected $dir = __DIR__;
    protected $namespace = 'Minify';
    

    /**
     * This part is common for all running all parts of application (both Admin and Site)
     *
     * @param $app Name
     *            of the part of application
     */
    protected function runBase($app)
    {
    	\Minify\Factory::registerPath(\Base::instance()->get('PATH_ROOT') . 'vendor/dioscouri/f3-lib/src/Dsc/Assets' );
    	 
    	parent::runBase( $app );
    }
    
}
$app = new MinifyBootstrap();