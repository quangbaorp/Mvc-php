<?php

namespace app\migration;
use app\core\DB;
class migration
{
    public $database;
    public function __construct()
    {
        $this->database = new DB();
        foreach(glob("./app/database/*.php") as $name)
        {
            require_once "$name";
            $newTable = explode( '/' , $name);
            $newTable = $newTable[3];
            $newTable = substr($newTable , 0 , -4);
            $table = new users();
            $this->database->createTabel($table->nameTable , $table->createTable());
        }
    }
}