<?php
namespace src\controllers;

use \core\Controller;
use \src\handlers\LoginHandler; /* ta pegando a class que foi criada no LoginHandlers->handlers*/
class HomeController extends Controller {

    private $loggedUser;/*Armazena o usuario que está logado*/

  public function __construct(){ 
      $this->loggedUser=LoginHandler::checkLogin();

      if( $this->loggedUser === false) { /*berifica o login caso dê errado redireciona pra pagina login*/
          $this->redirect('/login');
      }

   }

  public function index() {
    
      $this->render('home', ['nome' => 'Bonieky']);
}

}