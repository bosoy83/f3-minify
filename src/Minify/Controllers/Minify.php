<?php 
namespace Minify\Controllers;

class Minify 
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
                
        //return \Web::instance()->send('/home/asingh/f3-satis/public/site/images/logo.png', null, 0, false);
        //return \Web::instance()->send('/home/asingh/f3-satis/tmp/files/00_native_wide_midCC.jpg', null, 0, false);
    }
    
    public function resource()
    {
        $resource = \Base::instance()->get('PARAMS.1');
        switch ($resource) 
        {
        	case "js":
        	    return $this->js();
        	    break;
    	    case "css":
    	        return $this->css();
    	        break;
    	    default:
	            $this->findAsset($resource);
	            break;    	        
        }
    }
    
    private function findAsset($resource=null)
    {
        if (empty($resource)) {
            return;
        }
        
        // Loop through all the registered paths and try to find the requested asset
        // If it is found, send it with \Web::instance()->send($file, null, 0, false);
        $paths = (array) \Base::instance()->get('dsc.minify.paths');
        //\FB::log($paths);
        foreach ($paths as $path) 
        {
            $file = realpath($path) . "/" . $resource;
            //\FB::log($file);
            if (file_exists($file)) {
                
                //return \Web::instance()->send($file, null, 0, false);
                
                //\Base::instance()->set('CACHE', false);
                \Base::instance()->set('file', $file);
                $view = new \Dsc\Template;
                echo $view->renderLayout('Minify\Views::asset.php');
                //echo $view->renderLayout('Minify\Views::asset.php', \Web::instance()->mime($file));
                
                //header('Content-Type: '.(\Web::instance()->mime($file)));
                //echo \Base::instance()->read( $file );
                //return;
                //echo $file;
                //$getInfo = getimagesize($file);
                //header('Content-Type: ' . $getInfo['mime']);
                //readfile($file);
                                
                //header('Cache-Control: public');
                
                //readfile($file);
                //echo (string) file_get_contents( $file );
                //echo \Base::instance()->read( $file );
                //\Web::instance()->send($file, null, 0, false);
                //\Web::instance()->send($file);
                //echo "\n";
                //exit;
                //break;
            }
        }
        
        return;
    }
    
    public function js()
    {
        $files = array();
        if ($prioritized_files = (array) \Base::instance()->get('dsc.minify.js')) {
            foreach ($prioritized_files as $priority=>$paths) {
                foreach ((array)$paths as $path) {
                    $files[] = $path;
                }
            }
        }
        
        if (!empty($files)) 
        {
            \Base::instance()->set('UI', '../public/');
            
            if (\Base::instance()->get('DEBUG')) {
                \Base::instance()->set('CACHE', false);
                header('Content-Type: '.(\Web::instance()->mime('pretty.js')));
                foreach($files as $file) {
                    echo \Base::instance()->read( $file );
                    //\Web::instance()->send($file, null, 0, false);
                    echo "\n";
                }
            } else {
                \Base::instance()->set('CACHE', true);
                echo \Web::instance()->minify($files);
            }            
        }
    }
    
    public function css()
    {
        $files = array();
        if ($prioritized_files = (array) \Base::instance()->get('dsc.minify.css')) {
            foreach ($prioritized_files as $priority=>$paths) {
                foreach ((array)$paths as $path) {
                    $files[] = $path;
                }
            }
        }
        
        \Base::instance()->set('UI', '../public/');
    
        if (\Base::instance()->get('DEBUG')) {
            $files = array_merge( $files, $this->buildLessCss() );
            \Base::instance()->set('CACHE', false);
            header('Content-Type: '.(\Web::instance()->mime('pretty.css')));
            foreach($files as $file) {
                echo \Base::instance()->read( $file );
                //\Web::instance()->send($file, null, 0, false);
                echo "\n";
            }
        } else {
            \Base::instance()->set('CACHE', true);
            $files = array_merge( $files, $this->getLessCssDestinations() );
            echo \Web::instance()->minify($files);
        }
    }
    
    /**
     *
     */
    private function buildLessCss()
    {
        $f3 = \Base::instance();
        $source_files = (array) $f3->get('MINIFY_LESSCSS_SOURCEFILES');
        $less_files = array();
        
        if (!empty($source_files)) 
        {
            $less = new \lessc;
            $n=0;
            foreach ($source_files as $source_file) {
                $source = $source_file[0];
                $destination = !empty($source_file[1]) ? $source_file[1] : $f3->get('TEMP') . basename($source) . ".css";
                try {
                    if ($less->compileFile($source, $destination) !== false) {
                        $less_files[] = $destination;
                    }
                } catch (\Exception $e) {
                    // TODO Do something with the error
                }
                
                $n++;
            }
        }
        
        return $less_files;
    }
    
    private function getLessCssDestinations()
    {
        $f3 = \Base::instance();
        
        if (!$f3->get('MINIFY_LESSCSS_DESTINATIONFILES')) {
            $f3->set('MINIFY_LESSCSS_DESTINATIONFILES', $this->buildLessCss(), 3600*24);
        }
        
        return $f3->get('MINIFY_LESSCSS_DESTINATIONFILES');
    }
}
?> 