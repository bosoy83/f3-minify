<?php 
namespace Minify;

class Factory extends \Prefab 
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
        $options = $options + array(
        	'priority' => 3,
            'register_path' => false
        );
            
        $paths = \Base::instance()->get('dsc.minify.js');
        if (empty($paths) || !is_array($paths))
        {
            $paths = array();
        }
        
        $priority = (int) $options['priority'];
        if (empty($paths[$priority]) || !is_array($paths[$priority]))
        {
            $paths[$priority] = array();
        }

        if (!in_array($path, $paths[$priority]))
        {
            array_push( $paths[$priority], $path );
            \Base::instance()->set('dsc.minify.js', $paths);
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
        $options = $options + array(
            'priority' => 3,
            'register_path' => false
        );
    
        $paths = \Base::instance()->get('dsc.minify.css');
        if (empty($paths) || !is_array($paths))
        {
            $paths = array();
        }
    
        $priority = (int) $options['priority'];
        if (empty($paths[$priority]) || !is_array($paths[$priority]))
        {
            $paths[$priority] = array();
        }
    
        if (!in_array($path, $paths[$priority]))
        {
            array_push( $paths[$priority], $path );
            \Base::instance()->set('dsc.minify.css', $paths);
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
        $paths = \Base::instance()->get('dsc.minify.paths');
        if (empty($paths) || !is_array($paths)) 
        {
            $paths = array();
        }
        
        // if $path is not already registered, register it
        // last ones inserted are given priority by using unshift
        if (!in_array($path, $paths)) 
        {
            array_unshift( $paths, $path );
            \Base::instance()->set('dsc.minify.paths', $paths);
        }
        
        return $paths;
    }
}