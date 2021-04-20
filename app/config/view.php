<?php
//    function to view
    function __yeail ($file) {
        require_once "./app/views/".$file.".php" ;
    }
    function assets ($file) {
        global $protocol;
        echo "{$protocol}{$_SERVER['SERVER_NAME']}/public/assets/{$file}";
    }
    $protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === 0 ? 'https://' : 'http://';
    function abort ($status = 404) {
        http_response_code($status);
        __yeail("error/{$status}");
        die();
    }