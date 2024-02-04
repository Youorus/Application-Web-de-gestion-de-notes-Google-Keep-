<?php

require_once 'model/User.php';
require_once 'framework/View.php';
require_once 'framework/Controller.php';

class ControllerSettings extends Controller
{

    public function index(): void
    {
        if ($this->user_logged()) {
            $user = $this->get_user_or_redirect();
            (new View("settings"))->show(array("full_name" => $user->fullName));
        } else {
            // si l'utilisateur n'est pas connecté, rediriger vers la page de connexion
            $this->redirect("main", "login");
        }
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

        // Afficher la vue avec les erreurs potentielles et le message de succès
        (new View("change_password"))->show(["errors" => $errors, "success" => $success]);
    }



    public function edit_profile()  {
        $user = $this->get_user_or_redirect();
        $user_name = $user->getFullName();
        $user_mail = $user->getMail();
        $errors = [];

        if(isset($_POST['full_name'])) {
            $full_name = ($_POST['full_name']);
            if($full_name != $user->getName()) {
                $user->setName($full_name);
                $errors = User::validate($full_name);
            }
        }

        if(isset($_POST['email'])) {
            $newemail = $_POST['email'];
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


public function cancel(){
        $this->redirect("index","setting" );
}
    




}


?>