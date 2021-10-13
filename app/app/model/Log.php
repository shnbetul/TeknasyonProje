<?php
namespace Teknasyon\app\model;

use Teknasyon\Config\Model;

class Log extends Model{
    public function log($params=[])
    {
       return $this->all('logs','message',$params);
    }
    
}