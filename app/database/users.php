<?php
namespace app\migration;
class users
{
    public $nameTable;
    public  function  __construct()
    {
        $this->nameTable = 'users';
    }
    public function createTable ()
    {
       $table =  "CREATE TABLE $this->nameTable (
            id int(6) UNSIGNED NOT NULL,
            nickname varchar(100) NOT NULL,
            email varchar(500) NOT NULL,
            password varchar(50) NOT NULL,
        )";
       return $table;
    }
}