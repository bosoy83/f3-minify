<?php 
namespace Minify;

class Factory extends \Dsc\Singleton 
{
    /**
     * Adds a javascript file to the array of files to be minified 
     * 
     * @param unknown $fullpath
     * @param number $priority
     * @param unknown $options
     */
    public static function js( $path, $options=array() )
    {
        $global_app_name = \Base::instance()->get('APP_NAME');
        
        $options = $options + array(
        	'priority' => 3,
            'register_path' => false
        );
            
        $paths = \Base::instance()->get( $global_app_name . '.dsc.minify.js' );
        if (empty($paths) || !is_array($paths))
        {
            $paths = array();
        }
        
        $priority = (int) $options['priority'];
        for ($i=0; $i<=$priority; $i++)
        {
            if (empty($paths[$i]) || !is_array($paths[$i]))
            {
                $paths[$i] = array();
            }
        }

        if (!in_array($path, $paths[$priority]))
        {
            array_push( $paths[$priority], $path );
            \Base::instance()->set( $global_app_name . '.dsc.minify.js', $paths );
        }
        
        // TODO if $options['register_path], 
        // extract the path of the file using basename() or something 
        // and run self::registerPath(), 
        // to be used by the minify controller when looking up media assets 
        
        return $paths;
    }
    
    /**
     * Adds a css file to the array of files to be minified
     *
     * @param unknown $fullpath
     * @param number $priority
     * @param unknown $options
     */
    public static function css( $path, $options=array() )
    {
        $global_app_name = \Base::instance()->get('APP_NAME');
        
        $options = $options + array(
            'priority' => 3,
            'register_path' => false
        );
    
        $paths = \Base::instance()->get($global_app_name . '.dsc.minify.css');
        if (empty($paths) || !is_array($paths))
        {
            $paths = array();
        }
    
        $priority = (int) $options['priority'];
        for ($i=0; $i<=$priority; $i++)
        {
            if (empty($paths[$i]) || !is_array($paths[$i]))
            {
                $paths[$i] = array();
            }
        }
    
        if (!in_array($path, $paths[$priority]))
        {
            array_push( $paths[$priority], $path );
            \Base::instance()->set($global_app_name . '.dsc.minify.css', $paths);
        }
    
        // TODO if $options['register_path],
        // extract the path of the file using basename() or something
        // and run self::registerPath(),
        // to be used by the minify controller when looking up media assets
    
        return $paths;
    }
    
    /**
     * Registers a position where a auxiliary assets may be located, 
     * such as image files that a js/css file references
     *  
     * @param unknown $path
     */
    public static function registerPath( $path ) 
    {
        $global_app_name = \Base::instance()->get('APP_NAME');
        
        $paths = \Base::instance()->get($global_app_name . '.dsc.minify.paths');
        if (empty($paths) || !is_array($paths)) 
        {
            $paths = array();
        }
        
        $path = realpath($path) . '/';
        
        // if $path is not already registered, register it
        if (!in_array($path, $paths)) 
        {
            array_push( $paths, $path );
            \Base::instance()->set($global_app_name . '.dsc.minify.paths', $paths);
        }
        
        return $paths;
    }
    
    /**
     * Registers a less css source file to be minified
     *
     * @param unknown $path
     */
    public static function registerLessCssSource( $source, $destination=null )
    {
        $global_app_name = \Base::instance()->get('APP_NAME');
        
        $sources = \Base::instance()->get($global_app_name . '.dsc.minify.lesscss.sources');
        if (empty($sources) || !is_array($sources))
        {
            $sources = array();
        }
    
        // if $source is not already registered, register it
        // last ones inserted are given priority by using unshift
        if (!in_array($source, $sources))
        {
            array_push( $sources, array( $source, $destination ) );
            \Base::instance()->set($global_app_name . '.dsc.minify.lesscss.sources', $sources);
        }
    
        return $sources;
    }
}