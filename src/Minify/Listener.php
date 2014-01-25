<?php 
namespace Minify;

class Listener extends \Prefab 
{
    public function omg()
    {
        $filename = '/home/asingh/f3-satis/public/site/images/logo.png';
    
        $size = getimagesize($filename);
        $fp = fopen($filename, "rb");
        if ($size && $fp) {
            header("Content-type: {$size['mime']}");
            fpassthru($fp);
            exit;
        } else {
            // error
        }
    }
}