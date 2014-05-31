<?php
class MinifyBootstrap extends \Dsc\Bootstrap
{
    protected $dir = __DIR__;
    protected $namespace = 'Minify';
}
$app = new MinifyBootstrap();