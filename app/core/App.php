<?php

class App
{
    public $Database;
    protected $controller="Home";
    protected $action="index";
    protected $params=[];
    protected $arr = [];
    public $migration;
    public function __construct(){
        $this->migration = new app\migration\migration();
        $this->arr = $this->UrlProcess();
        if(isset($this->arr[0])) {
            if (file_exists("./app/controllers/" . $this->arr[0] . ".php")) {
                $this->controller = $this->arr[0];
            }
            else {
                abort(404);
            }
        }
        require_once "./app/controllers/". $this->controller .".php";
        $this->controller = new $this->controller;

        // Action
        if(isset($this->arr[1])){
            if( method_exists( $this->controller , $this->arr[1]) ){
                $this->action = $this->arr[1];
            } else {
                abort(404);
            }

        }

        // Params
        $this->params = $this->arr?array_values($this->arr):[];

        call_user_func_array([$this->controller, $this->action], $this->params );

    }

    public function UrlProcess(){
        if( isset($_GET["url"]) ){
            return explode("/", filter_var(trim($_GET["url"], "/")));
        }
    }
}
