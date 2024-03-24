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



    public function edit_profile() {
        $user = $this->get_user_or_redirect();
        $errors = []; // Assurez-vous que c'est un tableau pour pouvoir y ajouter des erreurs

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $full_name = isset($_POST['full_name']) ? trim($_POST['full_name']) : '';
            $newemail = isset($_POST['email']) ? trim($_POST['email']) : '';

            // Vérifiez que le nom complet n'est pas vide
            if (empty($full_name)) {
                $errors[] = "Le champ du nom complet ne peut pas être vide.";
            } elseif ($full_name != $user->getFullName()) {
                $user->setName($full_name); // Mise à jour temporaire
                $errors = array_merge($errors, User::validate($full_name));
            }

            // Vérifiez que l'email n'est pas vide
            if (empty($newemail)) {
                $errors[] = "Le champ de l'email ne peut pas être vide.";
            } elseif ($newemail != $user->getMail()) {
                $emailErrors = User::validate_unicity($newemail);
                if (!empty($emailErrors)) {
                    $errors = array_merge($errors, $emailErrors);
                } else {
                    $user->setMail($newemail); // Mise à jour temporaire
                }
            }

            // Si il n'y a pas d'erreurs, mettez à jour le profil de l'utilisateur
            if (empty($errors)) {
                $user->persist();
                $this->redirect("settings", "edit_profile"); // Redirection si la mise à jour est réussie
                return; // Empêche l'exécution ultérieure après une redirection
            }
        }

        // Si erreurs ou première visite, affichez la vue avec les informations existantes ou soumises
        (new View("edit_profile"))->show([
            "user" => $user,
            "errors" => $errors,
            "user_name" => $user->getFullName(), // Utilisez les valeurs actualisées pour l'affichage
            "user_mail" => $user->getMail(),
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