<?php
$Routes = [];
return (function(){
    $router = [];

    $path =  $_SERVER['REQUEST_URI'];
    $position = strpos($path, '?');
    $path = substr($path, 0, $position ?: strlen($path));

    function route(string $method, string $path, callable | array $callable){
        global $Routes;
        $Routes[strtolower($method)][$path] = $callable;
    }


    $router['get'] = function (string $path, callable | array $callable){
        route('get', $path, $callable);
    };

    $router['post'] = function (string $path, callable | array $callable){
        route('post', $path, $callable);
    };

    $router['resolve'] = function () use($path){
        global $Routes;
        $method = strtolower($_SERVER['REQUEST_METHOD']);
        $action = isset($Routes[$method][$path]) ? $Routes[$method][$path] : null;
        $paramNames = [];
        $paramsValues = [];

        foreach ($Routes[$method] as $routePath => $callable){

            // skip "/" route
            if(!trim($routePath, '/')){
                continue;
            }

            // get parameter names
            if(preg_match_all('/\{(\w+)(:[^}]+)?}/', trim($routePath, '/'), $matches)){
                $paramNames = $matches[1];
            }

            // replace parameter names with regex
            $routeRegex = "@^" . preg_replace_callback('/\{(\w+)(:[^}]+)?}/', fn($m) => $m[2] ?? '(\w+)', $routePath) . "@" ;

            //get path and params
            if(preg_match_all($routeRegex, $path, $matches)){
                $values = [];
                for ($i = 1; $i < count($matches); $i++){
                    $values[] = $matches[$i][0];
                }

                unset($Routes[$method][$routePath]);
                $Routes[$method][$matches[0][0]] = $callable;
                $paramsValues = $values;
            }
        }

        try{
            $action = isset($Routes[$method][$path]) ? $Routes[$method][$path] : null;
            if(!$action){
                exit("Route Not found");
            }
            if (!is_array($action)){
                return $action(...$paramsValues);
            }

            $controller = $action[0];
            $method = $action [1];

            require_once CONTROLLERPATH . DIRECTORY_SEPARATOR . $controller . '.php';
            return call_user_func_array($method, $paramsValues);
        }catch (Error $exception){
            exit($exception->getMessage());
        } finally {
            unset($GLOBALS['Routes']);
        }
    };

    return $router;
})();