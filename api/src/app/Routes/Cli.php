<?php

$routes->group("cli", ["namespace"=>"\App\Controllers\Api\Cli"], function($routes){

    $routes->group("generate", function($routes) {
        $routes->cli("all", "Generate::all");
        $routes->cli("batch/(:any)", "Generate::batch/$1");
        $routes->cli("resource/(:any)", "Generate::resource/$1");
        $routes->cli("model/(:any)", "Generate::model/$1");
        $routes->cli("models", "Generate::models");
        $routes->cli("service/(:any)", "Generate::service/$1");
        $routes->cli("services", "Generate::services");
    });

    $routes->group("dummy", function($routes) {
        $routes->cli("studyrooms", "Dummy::studyrooms");;
    });
    
});