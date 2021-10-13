<?php
namespace Teknasyon\app\model;

use Teknasyon\Config\Model;

class Category extends Model{

    public function categories($params=[]){
        return $this->all('categories', 'name', $params);
    }
}