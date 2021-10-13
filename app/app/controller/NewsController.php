<?php
namespace Teknasyon\app\controller;

use Illuminate\Validation\Rules\In;
use Teknasyon\app\model\Category;
use Teknasyon\app\model\Comment;
use Teknasyon\app\model\News;
use Teknasyon\Config\Controller;
use Teknasyon\Config\Input;
use Teknasyon\Config\str;
class NewsController extends Controller{
    
    public function create(){
        $news=new News();
        $name=Input::post("name");
        //print_r($name);exit;
        $description=Input::post("description");
        $category_id=Input::post('category_id');
        $slug=str::slug($name);
        $newsControl=$news->first('news','*',[
            ['slug', $slug,'=']
        ]);
        if(!empty($newsControl)){
            return $this->json(['message'=>'bu haber var']);
        }
        $insert=$news->insert('news',[
            'name'=>$name,
            'description'=>$description,
            'slug'=>$slug,
            'category_id'=>$category_id
        ]);
        return $this->json(['message'=>'haber oluşturuldu']);

        

    }
    public function show($id)
    {
        $news=new News();
        $showedNews=$news->first('news','name, description',[
            ['id',$id,'=']
        ]);
        return $this->json($showedNews);
       
    }public function update($id)
    {
       $name=Input::post('name');
       $description=Input::post('description');
       $news=new News();
       $updatedNews=$news->update('news',$id,
       [
           'name'=>$name,
           'description'=>$description
       ]);

       $slug=str::slug($name);
       $updatedSlug=$news->update('news',$id,[
           'slug'=>$slug
       ]);

       if(!empty($slug)){
           return $this->json(['message'=>'haber güncellendi']);
       }
       return $this->json([
        'type'=>'error',
        'value'=>'haber güncellenemedi'
    ]);
    }
    public function delete($id)
    {
       $news=new News();
       $deletedNews=$news->delete('news',[
           ['id', $id,'=']
       ]);
       return $this->json(['message'=>'haber silindi.']);
    }
    public function comments($news_id)
    {   
        $comment=new Comment();
        $commentsNews=$comment->all('comments','*',[
            ['news_id',$news_id,'=']
        ]);
    
        return $this->json($commentsNews);
    }
   
    
}