<?php
namespace Teknasyon\Config;
use PDO;
use Teknasyon\Config\Config;

class Database{
    public static $sql = '';
    public static $params = [];
    private static function connect(){
        $pdo = new PDO('mysql:host='.Config::$DB_SERVER.';dbname='.Config::$DB_NAME.';charset=utf8', Config::$DB_USERNAME, Config::$DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
        
        return $pdo;
    }

    public static function all($table,$select='*',$where = array(),$orderBy=null,$limit=null,$groupby=null,$join=array()){
        Self::$sql = "";
        Self::$params = [];
        Self::select($table,$select);
        Self::join_all($join);
        Self::where_all($where);
        Self::GroupBy($groupby);
        Self::OrderBy($orderBy);
        Self::limit($limit);
        $statement = self::connect()->prepare(Self::$sql);
        $statement = Self::bindValues($statement);
        $statement->execute(Self::$params);
        if(explode(' ', Self::$sql)[0] == 'SELECT'){
            $data = $statement->fetchAll(PDO::FETCH_OBJ);
            return $data;
        }
    }
    public static function first($table,$select='*',$where = array(),$orderBy=null,$limit=null){
        Self::$sql = "";
        Self::$params = [];
        Self::select($table,$select);
        Self::where_all($where);
        Self::OrderBy($orderBy);
        Self::limit($limit);
        $statement = self::connect()->prepare(Self::$sql);
        $statement = Self::bindValues($statement);
        $statement->execute(Self::$params);
      
        if(explode(' ', Self::$sql)[0] == 'SELECT'){
            $data = $statement->fetch(PDO::FETCH_OBJ);
            return $data;
        }
    }
    public static function insert($table, $params = array()){
        Self::$sql = "";
        Self::$params = [];
        Self::prepares($table,$params);
        $statement = self::connect()->prepare(Self::$sql);
        
        $statement->execute(Self::$params);
      
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
    public static function delete($table, $where = array()){
      Self::$sql = "";
      Self::delete_prepares($table,$where);
      
      $statement = self::connect()->prepare(Self::$sql);
     
      $update= $statement->execute(Self::$params);
      
      return $statement->fetch(PDO::FETCH_ASSOC);
    }
    public static function delete_prepares($table,$where = array()){
      Self::$params = [];
      Self::$sql = 'DELETE FROM '.$table;
      Self::where_all($where);
      
    }
    
    
    public static function update($table,$id, $params = array()){
      Self::$sql = "";
      Self::update_prepares($table,$id,$params);
      $statement = self::connect()->prepare(Self::$sql);
      $update= $statement->execute(Self::$params);
      return $statement->fetch(PDO::FETCH_ASSOC);
    }
    public static function update_prepares($table,$id,$params = array()){
      Self::$params = [];
      Self::$sql = 'UPDATE '.$table.' SET';
      foreach ($params as $key => $value) {
        $param[] = ' '.$key.' = ?';
        Self::$params[] = $value;
      }
      Self::$sql .= implode(',',$param);
      Self::$sql .= ' WHERE id = '.$id;
    }
    
    public static function prepares($table,$params = array()){
       Self::$params = [];
       Self::$sql = 'INSERT INTO '.$table.' SET';
       foreach ($params as $key => $value) {
         $param[] = ' '.$key.' = ?';
         Self::$params[] = $value;
       }
       Self::$sql .= implode(',',$param);
    }
    public static function OrderBy($orderBy){
      if(!empty($orderBy) && count($orderBy) == 2){
        Self::$sql .= ' ORDER BY '.$orderBy[0].' '.$orderBy[1];
      }
    }
    public static function limit($limit){
      if(!empty($limit) && count($limit) == 2){
        Self::$sql .= ' LIMIT '.(int)$limit[0].', '.(int)$limit[1];
      }elseif(!empty($limit) && count($limit) == 1){
        Self::$sql .= ' LIMIT '.$limit[0];
      }
    }
    public static function GroupBy($column){
      if(!empty($column)){
        Self::$sql .= ' GROUP BY ' . $column;
      }

    }
    public static function select($table,$select = "*"){
       Self::$sql .= 'SELECT '.$select.' FROM '.$table;
       return Self::$sql;
    }
    private static function join_all($array){
      foreach ($array as $key => $value) {
        Self::join($value[0],$value[1],$value[2],$value[3]);
      }
    }
    public static function join($from, $value = '', $mark = '=', $value2 = ''){
      Self::$sql .= ' inner join';
      Self::$sql .= ' '.$from.' on '.$value.' '.$mark.' '.$value2;
      return Self::$sql;
    }
    private static function where_all($array){
      foreach ($array as $key => $value) {
        Self::where($value[0],$value[1],$value[2]);
      }
    }
    public static function where($column, $value = '', $mark = '=', $logical = '&&'){
      if(strstr(Self::$sql,'WHERE')){
        Self::$sql .= ' '.$logical.' '.$column.' '.$mark.' :'.strtolower($column);
      }else{
        Self::$sql .= ' WHERE';
        Self::$sql .= ' '.$column.' '.$mark.' :'.strtolower($column);
      }
      Self::$params[strtolower($column)] = $value;
      return Self::$sql;
    }
    private static function bindValues($statement){
      foreach (Self::$params as $key => $value) {
        $statement->bindParam(':'.$key, $value, PDO::PARAM_STR);
      }
      return $statement;
    }
  }

?>