<?php
namespace Teknasyon\app\controller;

use Teknasyon\app\middleware\Auth;
use Teknasyon\app\model\Comment;
use Teknasyon\Config\Controller;
use Teknasyon\Config\Input;

class CommentController extends Controller{

    public function create()
    {
        
        $auth=new Auth();
        $auth->check(); 
        $user_id=null;
        if(!empty(Auth::$user)){

            $user_id=Auth::$user->id;
        }
        

        $user_name=Input::post('user_name');
        $content=Input::post('content');
        $news_id=Input::post('news_id');
        
        $comment=new Comment();

        if(!empty($content)){
            $user_name = !empty($user_name) ? $user_name : 'anonim';
            

            $createdComment=$comment->insert('comments',
            [
                'user_id'=> $user_id,
                'user_name'=> $user_name,
                'content'=> $content,
                'news_id'=>$news_id
            ]);
           
       }
       
       else{
            return $this->json(['message'=>'bir hata oldu']);
       }
    }
    

    public function delete($commentId)
    {
        
        $comment=new Comment();
        $deletedComment=$comment->delete('comments',[
            ['id',$commentId,'=']
        ]);
        return $this->json(['message'=>'yorum silindi']);
    }
  
    
}