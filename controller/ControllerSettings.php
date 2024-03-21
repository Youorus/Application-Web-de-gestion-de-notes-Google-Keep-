<?php

require_once 'model/User.php';
require_once 'framework/View.php';
require_once 'framework/Controller.php';

class ControllerSettings extends Controller
{

    public function index(): void
    {
        $user = $this->get_user_or_redirect();

        if (isset($_GET['logout']) && $_GET['logout'] == 'true') {
            $this->logout();
            header('Location: main/login.php');
            exit;
        }
        $user_name = $user->getFullName();


        if (isset($_GET['logout'])) {
            $this->logout();
            header('Location: index.php');
            exit;
        }

        $title = "Settings";
        (new View("setting"))->show(["user_name" => $user_name, "title" => $title]);

    }

    public function change_password(): void {
        $user = $this->get_user_or_redirect();
        $errors = [];
        $success = false;
        $currentpassword = '';
        $newpassword = '';
        $confirmpassword = '';

        if (isset($_POST['currentpassword'], $_POST['newpassword'], $_POST['confirmpassword'])) {
            $currentpassword = $_POST['currentpassword'];
            $newpassword = $_POST['newpassword'];
            $confirmpassword = $_POST['confirmpassword'];

            if (!$user->verifyPassword($currentpassword)) {
                $errors[] = "Le mot de passe actuel est incorrect.";
            }

            if ($newpassword !== $confirmpassword) {
                $errors[] = "Le nouveau mot de passe et la confirmation ne correspondent pas.";
            }

            if (empty($errors)) {
                $user->setHashedPassword(Tools::my_hash($newpassword));
                $user->persist();
                $success = true;
            }
        }

        (new View("change_password"))->show(["errors" => $errors, "success" => $success]);
    }



    public function edit_profile()  {
        $user = $this->get_user_or_redirect();
        $user_name = $user->getFullName();
        $user_mail = $user->getMail();
        $errors = [];

        if(isset($_POST['full_name'])) {
            $full_name = $_POST['full_name'];
            $user_name = $full_name;

            if ($full_name != $user->getName()) {
                $user->setName($full_name);
                $errors = array_merge($errors, User::validate($full_name));
            }
        }

        if(isset($_POST['email'])) {
            $newemail = $_POST['email'];
            $user_mail = $newemail;

            if($newemail != $user->getMail()) {
                $emailErrors = User::validate_unicity($newemail);
                if(!empty($emailErrors)) {
                    $errors = array_merge($errors, $emailErrors);
                } else {
                    $user->setMail($newemail);
                }
            }
        }

        if (count($_POST) > 0 && count($errors) == 0) {
            $user->persist_mail();
            $this->redirect("settings", "edit_profile");
        }

        (new View("edit_profile"))->show([
            "user" => $user,
            "errors" => $errors,
            "user_name" => $user_name,
            "user_mail" => $user_mail,
        ]);
    }

    public function logoutUser(): void
    {
        $this->logout();
       $this->redirect("main", "login");
    }


    public function cancel(){
        $this->redirect("settings");
}
    




}


?>