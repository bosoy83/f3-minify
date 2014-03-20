<?php 
class MinifyBootstrap extends \Dsc\Bootstrap{
	protected $dir = __DIR__;
	protected $namespace = 'Minify';
	
	// dont do anything for admin
	protected function runAdmin(){}
}
$app = new MinifyBootstrap();