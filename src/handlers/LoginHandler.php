<?php

namespace src\handlers;

use \src\models\User; /*pra isso tudo acontecer tem que usar o model de usuarios*/

class LoginHandler
{

    public static function checkLogin()
    {
        if (!empty($_SESSION['token'])) { /*se existir e nao tiver vazia a session token ele executa*/
            $token = $_SESSION['token'];/*verifica se tem algum usuario com esse token*/

            //Pesquisa na tabela de usuarios onde o campo token é igual ao token da sessão.
            $data = User::select()->where('token', $token)->one(); /*use token como $token*/

            if ($data == false) {
                return false;
            }

            //conta quantos registros retornou do banco
            if (count($data) > 0) { /*verifica se achou alguma coisa*/

                $loggedUser = new User();
                /* $loggedUser->id = $data['id'];
                $loggedUser->email = $data['email'];
                $loggedUser->name = $data['name']; */
                //outra maneira de verificar login 
                //$loggedUser->setAvatar($data['avata']);
                $loggedUser->setId($data['id']);
                $loggedUser->setEmail($data['email']);
                $loggedUser->setName($data['name']);
                $loggedUser->setavatar($data['avatar']);

                return $loggedUser;
            }
        }
        return false;
    }

    public static function verifyLogin($email, $password)
    {
        $user = User::select()->where('email', $email)->one();

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $token = md5(time() . rand(0, 9999) . time());

                User::update()
                    ->set('token', $token)
                    ->where('email', $email)
                    ->execute();

                return $token;
            }
        }
        return false;
    }

    public static function emailExists($email)
    {
        $user = User::select()->where('email', $email)->one();
        return $user ? true : false;
    }

    public static function addUser($name, $email, $password, $birthdate)
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $token = md5(time() . rand(0, 9999) . time());

        $create = User::insert([
            'email' => $email,
            'password' => $hash,
            'name' => $name,
            'birthdate' => $birthdate,
            'token' => $token,

        ])->execute();

        return $token;
    }
}
