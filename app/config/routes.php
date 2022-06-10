<?php
return function($router){
    /**
     * =========================================================================
     * #################### Route Configuration ################################
     * =========================================================================
     * All route functions and controllers should be registered here.
     * You can register routes using
     * $router[REQUEST_METHOD](PATH, ACTION);
     *      WHERE:
     *      REQUEST_METHOD: get or post
     *      PATH: uri path e.g /users
     *      ACTION: closure or array($controller_filename, $controller_function)
     *
     * @example
     * $router['get']('/', function(){});
     * -----------------------------------------------------
     * $router['post']('/login', ['auth_controller', 'login']);
     * ------------------------------------------------------
     * $router['post']('/users/{id}', ['user_controller', 'view']);
     */

    $router['get']('/', function(){
        $user = model('user');
        $name =  $user['get']();
        return view('welcome', ['name' => $name]);
    });
};