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

        if(isset($_POST['currentpassword'], $_POST['newpassword'], $_POST['confirmpassword'])) {
            $currentpassword = $_POST['currentpassword'];
            $newpassword = $_POST['newpassword'];
            $confirmpassword = $_POST['confirmpassword'];

            // Vérifier si le mot de passe actuel est correct
            if (!User::check_password($currentpassword, $user->hashed_password)) {
                $errors[] = "Le mot de passe actuel est incorrect.";
            }

            // Vérifier si les nouveaux mots de passe correspondent
            if ($newpassword !== $confirmpassword) {
                $errors[] = "Le nouveau mot de passe et la confirmation ne correspondent pas.";
            }

            // Si aucune erreur, mettre à jour le mot de passe
            if (empty($errors)) {
                $user->updatePassword($newpassword);
                $success = true;
            }
        }

        // Afficher la vue avec les erreurs potentielles et le message de succès
        (new View("change_password"))->show(["errors" => $errors, "success" => $success]);
    }


    public function edit_profile(): void {
        $user = $this->get_user_or_redirect();
        $errors = [];
        $success = "";

        if(isset($_POST['full_name'])) {
            $full_name = trim($_POST['full_name']);
            if($full_name != $user->full_name) {
                $user->full_name = $full_name;
                $errors_fullname = $user->validate();
                $errors = array_merge($errors, $errors_fullname);
            }

        }

        if(isset($_POST['mail'])) {
            $mail = trim($_POST['mail']);
            if($mail != $user->mail) {
                $user->mail = $mail;
                $errors_mail = User::validate_unicity($mail);
                $errors = array_merge($errors, $errors_mail);
            }
        }

        if (count($_POST) > 0 && count($errors) == 0) {
            $user->persist();
            $this->redirect("user", "edit_profile", "ok");
        }

        if (isset($_GET['param1']) && $_GET['param1'] === "ok") {
            $success = "Your profile has been successfully updated.";
        }

        (new View("edit_profile"))->show([
            "user" => $user,
            "errors" => $errors,
            "success" => $success
        ]);
    }

    




}


?>