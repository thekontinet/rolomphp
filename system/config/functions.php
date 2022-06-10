<?php
if(!function_exists('view')){
    function view(string $_name, array $data = []){
        ob_start();
        extract($data);
        include VIEWPATH . DIRECTORY_SEPARATOR . $_name . '.php';
        $content = ob_get_clean();
        echo $content;
    }
}

if(!function_exists('model')){
    function model(string $_name){
        ob_start();
        $content = include (MODELPATH . DIRECTORY_SEPARATOR . $_name . '.php');
        return $content;
    }
}

//TODO Add a render() which should display the view with a template