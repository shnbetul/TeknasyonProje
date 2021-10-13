<?php
namespace Teknasyon\app\model;

use Teknasyon\Config\Model;

class News extends Model{

   
    public function newsAll()
    {
        return $this->all(
            'news',
            'news.id, news.name, news.description, news.date, news.slug, news.category_id ,categories.name as category_name',
            [],
            null,
            null,
            null,
            [
                ['categories', 'categories.id','=','news.category_id']
            ]
            );
    }
}
