<?php
namespace Teknasyon\app\controller;

use Teknasyon\app\middleware\Auth;
use Teknasyon\app\model\Log;
use Teknasyon\Config\Controller;
use  Teknasyon\app\model\User;
use Teknasyon\Config\Input;

class UserController extends Controller{

    public function index(){
        $user=new User();
        return $this->json($user->users());   
    }
    public function update($userId){
        $name=Input::post('name');
        $password=Input::post('password');
        $user=new User();
        $updatedUser=$user->update( 'users', $userId,
        [
            'name'=>$name,
            'password'=>md5($password)
        ]
            
        );
        return $this->json(['message'=>'bilgileriniz güncellendi..']);
    
    }
    public function delete($userId)
    {
       $user=new User();
       $deletedUser=$user->delete('users',[
           ['id',$userId,'=']
       ]);
       return $this->json(['message'=>'kullanıcı silindi']);
    }
    public function show($userId)
    {
       $user=new User();
       $showedUser=$user->first('users','id, name, email',[
           ['id', $userId, '=']
       ]);
       return $this->json($showedUser);
    }

  public function requestDelete()
    {

        $userId=Auth::$user->id;
        if(!empty($userId)){
            $user=new User();
            $requestDeleteUser=$user->update('users',$userId,[
                'user_status'=>0
            ]);

            return $this->json(['message'=>'silme isteğiniz alındı']);
        }
       

    
    }
    
}