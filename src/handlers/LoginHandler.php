<?php
namespace src\handlers;

use \src\models\User; /*pra isso tudo acontecer tem que usar o model de usuarios*/

class LoginHandler {

    public static function checkLogin(){
        if(!empty($_SESSION['token'])){ /*se existir e nao tiver vazia a session token ele executa*/
            $token = $_SESSION['token'];/*verifica se tem algum usuario com esse token*/

            $data = User::select()->where('token',$token)->execute(); /*use token como $token*/

            if(count($data) > 0){ /*verifica se achou alguma coisa*/
                
                $loggedUser = new User();
                $loggedUser->id = $data['id'];
                $loggedUser->email = $data['email'];
                $loggedUser->name = $data['name'];
                        /*outra maneira de verificar login */
               # $loggedUser = setId($data['id']);
               # $loggedUser = setEmail($data['email']);
               # $loggedUser = setName($data['name']);

                return $loggedUser;

            }
           
        }
        return false;
    }

    public static function verifyLogin($email, $password){
            $user = User :: select()->where('email',$email)->one();

            if($user){
                if(password_verify($password, $user['password'])){
                $token=md5(time().rand(0,9999).time());

                User::update()
                ->set('token',$token)
                ->where('email',$email)
                ->execute();

                return $token;
                }
            }
            return false;
    }
}