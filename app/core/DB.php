<?php
namespace app\core;
use app\core\Helper;
class DB
{

    /**
     * Khai báo biến kết nối
     * @var [type]
     */
    public $link;
    public $Helper;
    public function __construct()
    {
        $this->link = mysqli_connect("localhost","root","","baomoi") or die ("<h1 style='text-align: center; color : red; font-weight: bold'> connect database fail </h1>");
        $this->Helper = new Helper();
        mysqli_set_charset($this->link,"utf8");
    }

    /**
     * [insert description] hàm insert
     * @param  $table
     * @param  array  $data
     * @return integer
     */
    public function insert($table, array $data)
    {
        //code
        $sql = "INSERT INTO {$table} ";
        $columns = implode(',', array_keys($data));
        $values  = "";
        $sql .= '(' . $columns . ')';
        foreach($data as $field => $value) {
            if(is_string($value)) {
                $values .= "'". @mysqli_real_escape_string($this->link,$value) ."',";
            } else {
                $values .= @mysqli_real_escape_string($this->link,$value) . ',';
            }
        }
        $values = substr($values, 0, -1);
        $sql .= " VALUES (" . $values . ')';
        // _debug($sql);die;
        mysqli_query($this->link, $sql) or die("Lỗi  query  insert ----" .mysqli_error($this->link));
        return mysqli_insert_id($this->link);
    }
    public function last_id()
    {
        return  @mysqli_insert_id($this->link);
    }
    public function query($sql)
    {
        $result = @mysqli_query($this->link  , $sql);
        return $result;
    }
    public function num_row($sql)
    {
        $query = @mysqli_query($this->link , $sql);
        $result = @mysqli_num_rows($query);
        return $result;
    }
    public function update($table, array $data, array $conditions)
    {
        $sql = "UPDATE {$table}";

        $set = " SET ";

        $where = " WHERE ";

        foreach($data as $field => $value) {
            if(is_string($value)) {
                $set .= $field .'='.'\''. mysqli_real_escape_string($this->link, $this->Helper->xss_clean($value)) .'\',';
            } else {
                $set .= $field .'='. mysqli_real_escape_string($this->link, $this->Helper->xss_clean($value)) . ',';
            }
        }

        $set = substr($set, 0, -1);


        foreach($conditions as $field => $value) {
            if(is_string($value)) {
                $where .= $field .'='.'\''. mysqli_real_escape_string($this->link, $this->Helper->xss_clean($value)) .'\' AND ';
            } else {
                $where .= $field .'='. mysqli_real_escape_string($this->link, $this->Helper->xss_clean($value)) . ' AND ';
            }
        }

        $where = substr($where, 0, -5);

        $sql .= $set . $where;
        // _debug($sql);die;

        @mysqli_query($this->link, $sql) or die( "Lỗi truy vấn Update -- " );

        return @mysqli_affected_rows($this->link);
    }
    public function updateview($sql)
    {
        $result = mysqli_query($this->link,$sql)  or die ("Lỗi update view " .mysqli_error($this->link));
        return @mysqli_affected_rows($this->link);

    }
    public function countTable($table , array $conditions)
    {
        $sql = "SELECT * FROM {$table}";
        $where = " WHERE ";
        foreach($conditions as $field => $value) {
            if(is_string($value)) {
                $where .= $field .'='.'\''. @mysqli_real_escape_string($this->link, $this->Helper->xss_clean($value)) .'\' AND ';
            } else {
                $where .= $field .'='. @mysqli_real_escape_string($this->link, $this->Helper->xss_clean($value)) . ' AND ';
            }
        }
        $where = substr($where, 0, -5);
        $sql .= $where;

        $result = mysqli_query($this->link, $sql) or die("Lỗi Truy Vấn countTable----" .mysqli_error($this->link));
        $num = @mysqli_num_rows($result);
        return $num;
    }


    /**
     * [delete description] hàm delete
     * @param  $table      [description]
     * @param  array  $conditions [description]
     * @return integer             [description]
     */
    public function delete ($table ,  $id )
    {
        $sql = "DELETE FROM {$table} WHERE id = $id ";

        return @mysqli_query($this->link,$sql) or die (" Lỗi Truy Vấn delete   --- " .mysqli_error($this->link));
        // return @mysqli_affected_rows($this->link);
    }

    /**
     * delete array
     */

    public function deletewhere($table,$data = array())
    {
        foreach ($data as $id)
        {
            $id = intval($id);
            $sql = "DELETE FROM {$table} WHERE id = $id ";
            @mysqli_query($this->link,$sql) or die (" Lỗi Truy Vấn delete   --- " .mysqli_error($this->link));
        }
        return true;
    }

    public function fetchsql( $sql )
    {
        $result = @mysqli_query($this->link,$sql) or die("Lỗi  truy vấn sql " .mysqli_error($this->link));
        $data = [];
        if( $result)
        {
            while ($num = @mysqli_fetch_assoc($result))
            {
                $data[] = $num;
            }
        }
        return $data;
    }

    public function fetchID($table , $id )
    {
        $sql = "SELECT * FROM {$table} WHERE id = $id ";
        $result = @mysqli_query($this->link,$sql) or die("Lỗi  truy vấn fetchID " .mysqli_error($this->link));
        return @mysqli_fetch_assoc($result);
    }

    public function fetchOne($table , $query)
    {
        $sql  = "SELECT * FROM {$table} WHERE ";
        $sql .= $query;
        $sql .= "LIMIT 1";
        $result = @mysqli_query($this->link,$sql) or die("Lỗi  truy vấn fetchOne " .mysqli_error($this->link));
        return @mysqli_fetch_assoc($result);
    }

    public function deletesql ($table ,  $sql )
    {
        $sql = "DELETE FROM {$table} WHERE " .$sql;
        // _debug($sql);die;
        @mysqli_query($this->link,$sql) or die (" Lỗi Truy Vấn delete   --- " .mysqli_error($this->link));
        return @mysqli_affected_rows($this->link);
    }

    public function fetchAll($table)
    {
        $sql = "SELECT * FROM {$table} WHERE 1" ;
        $result = @mysqli_query($this->link,$sql) or die("Lỗi Truy Vấn fetchAll " .mysqli_error($this->link));
        $data = [];
        if( $result)
        {
            while ($num = @mysqli_fetch_assoc($result))
            {
                $data[] = $num;
            }
        }
        return $data;
    }

    public  function fetchJoneDetail($table , $sql ,$page = 0,$total ,$pagi )
    {
        $result = @mysqli_query($this->link,$sql) or die("Lỗi truy vấn fetchJone ---- " .mysqli_error($this->link));

        $sotrang = ceil($total / $pagi);
        $start = ($page - 1 ) * $pagi ;
        $sql .= " LIMIT $start,$pagi";

        $result = @mysqli_query($this->link , $sql);
        $data = [];
        $data = [ "page" => $sotrang];
        if( $result)
        {
            while ($num = @mysqli_fetch_assoc($result))
            {
                $data[] = $num;
            }
        }
        return $data;
    }

    public function total($sql)
    {
        $result = @mysqli_query($this->link  , $sql);
        $tien = @mysqli_fetch_array($result);
        return $tien;
    }
    public function querySql ($sql)
    {
        return @mysqli_query($this->link  , $sql);

    }
    public function createTabel($nameTable = "" , $column="")
    {
        if($column == "" || $nameTable = ""){
            return;
        }
        else{
            if(!$this->querySql('SELECT * FROM `users`'))
            {
               return $this->querySql($column);
            }
        }
    }


}

?>