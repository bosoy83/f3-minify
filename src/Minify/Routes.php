<?php

namespace Minify;

/**
 * Group class is used to keep track of a group of routes with similar aspects (the same controller, the same f3-app and etc)
 */
class Routes extends \Dsc\Routes\Group{
	
	
	function __construct(){
		parent::__construct();
	}
	
	/**
	 * Initializes all routes for this group
	 * NOTE: This method should be overriden by every group
	 */
	public function initialize(){
		$this->setDefaults(
				array(
					'namespace' => '\Minify',
					'url_prefix' => '/minify'
				)
		);
		
        // TODO set some app-specific settings, if desired
		$this->add( '/css', 'GET', array(
								'controller' => 'Controller',
								'action' => 'css'
								));

		$this->add( '/js', 'GET', array(
				'controller' => 'Controller',
				'action' => 'js'
		));

		$this->add( '/*', 'GET', array(
				'controller' => 'Controller',
				'action' => 'item'
		));
	}
}