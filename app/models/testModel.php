<?php

class testModel extends \app\core\DB
{

    public function test()
    {
        $user = $this->insert('users' ,
            ['domain' => 'abc' , 'title' => 'anc' , 'idfb' => 'av' , 'phone' => 123
                ,'admin' => '123' , 'keyword' => 'abc'
            ]);
        return $user;
    }
    public function chinhcho()
    {
        $user = 'abc';
        return $user;
    }
}