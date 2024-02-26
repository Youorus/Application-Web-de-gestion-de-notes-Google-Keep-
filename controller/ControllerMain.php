<?php
require_once "framework/Controller.php";
require_once "model/User.php";

class ControllerMain extends Controller {


    // verifier si l'utilisateur est connecter si oui le rediriger !
    public function index() : void {
            (new View("login"))->show();
    }


    public function login() : void {
        if($this->get_user_or_redirect()){
           $this->redirect("index");
        }
        $mail = "";
        $password = "";
        $errors = [];
        if (isset($_POST['mail']) && isset($_POST['password'])) {
            $mail = $_POST['mail'];
            $password = $_POST['password'];
            $errors = User::validate_login($mail, $password);
            if (empty($errors)) {
                $this->log_user(User::get_user_by_mail($mail), "index");
            }
        }
        (new View("login"))->show(["mail" => $mail, "password" => $password, "errors" => $errors]);

    }

    public function signup(): void {
        $email = '';
        $full_name = '';
        $password = '';
        $passwordconfirm = '';
        $errors = [];
        $role = 'user';

        if (isset($_POST['email']) && isset($_POST['full_name']) && isset($_POST['password']) && isset($_POST['passwordconfirm'])) {
            $email = $_POST['email'];
            $full_name = trim($_POST['full_name']);
            $password = $_POST['password'];
            $passwordconfirm = $_POST['passwordconfirm'];


            $user = new User(0, $email, Tools::my_hash($password), $full_name, $role);
            $errors = User::validate_unicity($email);
            $errors = array_merge($errors, $user->validate($full_name));
            $errors = array_merge($errors, User::validate_passwords($password, $passwordconfirm));

            if (count($errors) == 0) {
                $user->persist();
                $this->log_user($user);
                $this->redirect("index");
            }
        }

        (new View("signup"))->show([
            "email" => $email,
            "full_name" => $full_name,
            "password" => $password,
            "passwordconfirm" => $passwordconfirm,
            "errors" => $errors
        ]);

    }
}