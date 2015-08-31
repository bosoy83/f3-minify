f3-minify
=========

A front-end package manager for the F3 framework

### Getting Started

```
Add this to your project's composer.json file:

{
    "require": {
        "dioscouri/f3-minify": "dev-master"
    }
}
```

### Use case
You want to have a single access point for all the CSS and JS from all your apps you can register them to minify and return them from a route 

```php
 // tell Minify where to find Media, CSS and JS files
        \Minify\Factory::registerPath($this->app->get('PATH_ROOT') . "public/Theme/");
        \Minify\Factory::registerPath($this->app->get('PATH_ROOT') . "public/Theme/css/");
        \Minify\Factory::registerPath($this->app->get('PATH_ROOT') . "public/");
        
        
        // add the media assets to be minified
        $files = array(
            'css/style.css'
        );
        
        foreach ($files as $file)
        {
            \Minify\Factory::css($file);
        }
        
        $files = array(
            'js/script.js'
        );
        
        foreach ($files as $file)
        {
            \Minify\Factory::js($file, array(
                'priority' => 1
            ));
        }
```