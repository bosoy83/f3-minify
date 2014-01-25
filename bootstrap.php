<?php 
$f3 = \Base::instance();
$global_app_name = $f3->get('APP_NAME');

switch ($global_app_name) 
{
    case "admin":
        /*
        // register event listener
        \Dsc\System::instance()->getDispatcher()->addListener(\Minify\Listeners\Admin::instance());
        
        // append this app's UI folder to the path
        $ui = $f3->get('UI');
        $ui .= ";" . $f3->get('PATH_ROOT') . "vendor/dioscouri/f3-minify/src/Minify/Admin/Views/";
        $f3->set('UI', $ui);
        */
                
        break;
    case "site":
        // append this app's UI folder to the path
        $ui = $f3->get('UI');
        $ui .= ";" . $f3->get('PATH_ROOT') . "vendor/dioscouri/f3-minify/src/Minify/Views/";
        $f3->set('UI', $ui);
                
        // TODO set some app-specific settings, if desired
        $f3->route('GET /minify/css', '\Minify\Controller->css');
        $f3->route('GET /minify/js', '\Minify\Controller->js');
        $f3->route('GET /minify/*', '\Minify\Controller->item');
        break;
}
?>