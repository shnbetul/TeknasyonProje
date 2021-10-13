<?php
namespace Teknasyon\app\model;

use Teknasyon\Config\Model;

class Comment extends Model{
    public function commenents($params=[])
    {
       return $this->all('comments','*',$params);
    }
    
}