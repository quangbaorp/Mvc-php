<?php
// config
require_once "./app/config/app.php";
foreach ($app as $item){
    require_once "{$item}";
}

