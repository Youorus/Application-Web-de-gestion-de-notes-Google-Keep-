<?php
require_once "framework/Controller.php";
require_once "model/User.php";

class ControllerMain extends Controller {


    // verifier si l'utilisateur est connecter si oui le rediriger !
    public function index() : void {
         if ($this->user_logged()) {
            // redirection de lútilisateiur
            (new View("index"))->show();
         } else {
            (new View("login"))->show();
        }
    }


    public function login() : void {
        $mail = "";
        $password = "";
        $errors = [];
        if (isset($_POST['mail']) && isset($_POST['password'])) { //note : pourraient contenir des chaînes vides
            $mail = $_POST['mail'];
            $password = $_POST['password'];

            $errors = User::validate_login($mail, $password);
            if (empty($errors)) {
                //$this->log_user(User::get_user_by__mail($mail));
                //a(new View("index"))->show();
            }
        }
        (new View("login"))->show(["mail" => $mail, "password" => $password, "errors" => $errors]);
       
    }

    
}