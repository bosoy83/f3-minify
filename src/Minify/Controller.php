<?php 
namespace Minify;

class Controller extends \Dsc\Controller
{
    public function item()
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
        	    return $this->findAsset($resource);
        	    break;
        }
    }
    
    public function findAsset($resource=null)
    {
        if (empty($resource)) {
            return;
        }
        
        // TODO allow this to be modified, both by an admin interface and via a class::method
        $approved_extensions = array(
            // images
            'bmp','gif','ico','jpg','jpeg','odg','png','svg',
            // video
            '3gp','amv','avi','divx','mov','mp4','mpg','qt','rm','wmv','swf',
            // audio
            'm4a','mp3','ogg','wma','wav',
            // fonts
            'eot','otf','ttf','woff',
            // text files
            'csv','doc','odp','ods','odt','pdf','ppt','txt','xcf','xls'
        );

        // Is the extension of the requested asset in the list of approved extensions?        
        $extension = strtolower( pathinfo( $resource, PATHINFO_EXTENSION ) );
        if (!in_array($extension, $approved_extensions)) 
        {
            \Base::instance()->error(500);
            return;        	
        }
        
        // Loop through all the registered paths and try to find the requested asset
        // If it is found, send it with \Web::instance()->send($file, null, 0, false);
        $paths = (array) \Base::instance()->get('dsc.minify.paths');

        foreach ($paths as $path)
        {
            $file = realpath( $path . $resource );
            if (file_exists($file)) 
            {
                \Base::instance()->set('file', $file);
                $theme = \Dsc\System::instance()->get('theme');
                echo $theme->renderView('Minify\Views::asset.php');
                
                return;
            }
        }
        
        // File not found.
        \Base::instance()->error(500);
        return;
    }
    
    public function js()
    {
        $f3 = \Base::instance();
        
        $files = array();
        if ($prioritized_files = (array) $f3->get('dsc.minify.js')) {
            foreach ($prioritized_files as $priority=>$paths) {
                foreach ((array)$paths as $path) {
                    $files[] = $path;
                }
            }
        }
    
        if (!empty($files))
        {
            if ($f3->get('DEBUG')) {
                $paths = (array) $f3->get('dsc.minify.paths');
                $f3->set('CACHE', false);
                header('Content-Type: '.(\Web::instance()->mime('pretty.js')));
                foreach($files as $file) 
                {
                    foreach ($paths as $path)
                    {
                        if (file_exists(realpath($path.$file)))
                        {
                            try {
                                echo $f3->read( $path . $file );
                                echo "\n";
                                break;
                            } catch (\Exception $e) {
                                continue;
                            }
                        
                        }                        
                    }
                }
            } else {

                $paths = (array) $f3->get('dsc.minify.paths');
                $f3->set('CACHE', false);
                header('Content-Type: '.(\Web::instance()->mime('pretty.js')));
                foreach($files as $file)
                {
                    foreach ($paths as $path)
                    {
                        if (file_exists(realpath($path.$file)))
                        {
                            try {
                                echo $f3->read( $path . $file );
                                echo "\n";
                                break;
                            } catch (\Exception $e) {
                                continue;
                            }
                
                        }
                    }
                }                
                
                /*
                $f3->set('CACHE', true);
                $cache = \Cache::instance();
                $refresh = $this->input->get('refresh', 0, 'int');
                if ($refresh || !$cache->exists('minify.js', $minified))
                {
                    $paths = (array) $f3->get('dsc.minify.paths');
                    foreach($files as $key=>$file)
                    {
                        foreach ($paths as $path)
                        {
                            if (file_exists(realpath($path.$file)))
                            {
                                $files[$key] = realpath($path.$file);
                            }
                        }
                    }
                    
                    $minified = \Web::instance()->minify($files, null, true, '/');
                    $cache->set('minify.js', $minified, 3600*24);
                }
                
                header('Content-Type: '.(\Web::instance()->mime('pretty.js')).'; charset='.$f3->get('ENCODING'));
                echo $minified;
                */
            }
        }
    }
    
    public function css()
    {
        $f3 = \Base::instance();
        
        $files = array();
        if ($prioritized_files = (array) \Base::instance()->get('dsc.minify.css')) {
            foreach ($prioritized_files as $priority=>$paths) {
                foreach ((array)$paths as $path) {
                    $files[] = $path;
                }
            }
        }
    
        if ($f3->get('DEBUG')) {
            
            $paths = (array) $f3->get('dsc.minify.paths');
            $files = array_merge( $files, $this->buildLessCss() );
            \Base::instance()->set('CACHE', false);
            header('Content-Type: '.(\Web::instance()->mime('pretty.css')));
            foreach($files as $file) 
            {
                foreach ($paths as $path) 
                {
                    if (file_exists(realpath($path.$file))) 
                    {
                        try {
                            echo $f3->read( $path . $file );
                            echo "\n";
                            break;
                        } catch (\Exception $e) {
                            continue;
                        }
                        
                    }
                }
            }
            
        } else {
            
            $paths = (array) $f3->get('dsc.minify.paths');
            $files = array_merge( $files, $this->buildLessCss() );
            \Base::instance()->set('CACHE', false);
            header('Content-Type: '.(\Web::instance()->mime('pretty.css')));
            foreach($files as $file)
            {
                foreach ($paths as $path)
                {
                    if (file_exists(realpath($path.$file)))
                    {
                        try {
                            echo $f3->read( $path . $file );
                            echo "\n";
                            break;
                        } catch (\Exception $e) {
                            continue;
                        }
            
                    }
                }
            }            
            
            /*
            $f3->set('CACHE', true);
            $cache = \Cache::instance();
            $refresh = $this->input->get('refresh', 0, 'int');
            if ($refresh || !$cache->exists('minify.css', $minified)) 
            {
                $files = array_merge( $files, $this->getLessCssDestinations() );
                $paths = (array) $f3->get('dsc.minify.paths');
                foreach($files as $key=>$file)
                {
                    foreach ($paths as $path)
                    {
                        if (file_exists(realpath($path.$file)))
                        {
                            $files[$key] = realpath($path.$file);
                        }
                    }
                }
                
                $minified = \Web::instance()->minify($files, null, true, '/');
                $cache->set('minify.css', $minified, 3600*24);
            }
            
            header('Content-Type: '.(\Web::instance()->mime('pretty.css')).'; charset='.$f3->get('ENCODING'));
            echo $minified;
            */
        }
    }
    
    /**
     *
     */
    private function buildLessCss()
    {
        $f3 = \Base::instance();
        $source_files = (array) $f3->get('dsc.minify.lesscss.sources');
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
    
        if (!$f3->get('dsc.minify.lesscss.destinations')) {
            $f3->set('dsc.minify.lesscss.destinations', $this->buildLessCss(), 3600*24);
        }
    
        return $f3->get('dsc.minify.lesscss.destinations');
    }
}