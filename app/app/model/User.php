<?php
namespace Teknasyon\app\model;

use Teknasyon\Config\Model;

class User extends Model{
    public function userInsert($params){

       return $this->insert('users',$params);
    }
    public function registerControl($params){
      
      return  $this->first('users', '*', $params);
      
 
    }
    public function loginControl($params)
    {
      return $this->first('users', '*', $params);
    }

    public function users($params=[]){
      return $this->all('users', '*', $params);
    }
}