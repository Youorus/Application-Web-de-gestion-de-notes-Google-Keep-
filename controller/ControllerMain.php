<?php
require_once "framework/Controller.php";
require_once "model/User.php";

class ControllerMain extends Controller {


    // verifier si l'utilisateur est connecter si oui le rediriger !
    public function index() : void {
            (new View("login"))->show();
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
                $this->log_user(User::get_user_by_mail($mail), "index");
            }
        }
        (new View("login"))->show(["mail" => $mail, "password" => $password, "errors" => $errors]);

    }

    public function signup(): void {
        $email = '';
        $fullname = '';
        $password = '';
        $passwordconfirm = '';
        $errors = [];
        $role = 'user';

        if (isset($_POST['email']) && isset($_POST['fullname']) && isset($_POST['password']) && isset($_POST['passwordconfirm'])) {
            $email = $_POST['email'];
            $fullname = trim($_POST['fullname']);
            $password = $_POST['password'];
            $passwordconfirm = $_POST['passwordconfirm'];


            $user = new User($email, Tools::my_hash($password), $fullname, $role);
            $errors = User::validate_unicity($email);
            $errors = array_merge($errors, $user->validate());
            $errors = array_merge($errors, User::validate_passwords($password, $passwordconfirm));

            if (count($errors) == 0) {
                $user->persist();
                $this->log_user($user);
            }
        }

        (new View("signup"))->show([
            "email" => $email,
            "fullname" => $fullname,
            "password" => $password,
            "confirmpassword" => $passwordconfirm,
            "errors" => $errors
        ]);

    }
}