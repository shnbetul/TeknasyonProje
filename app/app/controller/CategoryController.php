<?php
namespace Teknasyon\app\controller;

use Teknasyon\app\middleware\Auth;
use Teknasyon\app\model\Category;
use Teknasyon\app\model\News;
use Teknasyon\Config\Controller;
use Teknasyon\Config\Input;
use Teknasyon\Config\str;

class CategoryController extends Controller{
    public function index(){
        $category=new Category();
        return $this->json($category->categories());
    }

   public function create()
   {
        $category=new Category();
        $name=Input::post('name');
        $news_id=Input::post('news_id');
        $slug=str::slug($name);
        
        $categoryControl= $category->first('categories', '*', [
           ['slug', $slug, '=']
        ]);
        
        if(!empty($categoryControl)){
            return $this->json(['message'=>'bu kategori var ']);
        }
        $insert=$category->insert('categories',[
            'name'=>$name,
            'slug'=>$slug,
            'news_id'=>$news_id
            
        ]);
        
        return $this->json(['message'=>'kategori oluşturuldu']);
     }
   
    public function delete($id)
    {
        $category=new Category();
        $deletedCategory=$category->delete('categories',[
            ['id', $id, '=']
        ]);

        return $this->json(['message'=>'kategori silindi']);
    }

    public function update($id)
    {
       $name=Input::post('name');
       $category=new Category();
       $updatedCategory=$category->update('categories',$id,
       [
           'name'=>$name
       ]);
       
       $slug=str::slug($name);
       $updatedSlug=$category->update('categories',$id,
       [
           'slug'=>$slug
       ]);
      
       if(!empty($slug)){
           return $this->json(['message'=>'kategori güncellendi']);
       }
       return $this->json([
           'type'=>'error',
           'value'=>'kategori güncellnemedi'
       ]);

    }
    public function news($id)
    {
       $news=new News();
       $showedCategory=$news->all('news','*',
       [[
           'category_id', $id, '='       ]]);

           return $this->json($showedCategory);
    }

}