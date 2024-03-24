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
        // Initialisez avec les valeurs actuelles pour gérer le cas où aucune donnée n'est soumise
        $user_name = $user->getFullName();
        $user_mail = $user->getMail();
        $errors = [];

        // Mettez à jour avec les valeurs soumises si disponibles
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['full_name'])) {
                $full_name = $_POST['full_name']; // Utilisez directement la valeur soumise
                if ($full_name != $user->getName()) {
                    $user->setName($full_name); // Mettez à jour temporairement l'objet utilisateur
                    $errors = User::validate($full_name); // Validez le nom complet
                }
                $user_name = $full_name; // Gardez la valeur soumise pour la réafficher dans la vue
            }

            if (isset($_POST['email'])) {
                $newemail = $_POST['email']; // Utilisez directement la valeur soumise
                if ($newemail != $user->getMail()) {
                    $emailErrors = User::validate_unicity($newemail); // Validez l'unicité de l'email
                    if (!empty($emailErrors)) {
                        $errors = array_merge($errors, $emailErrors);
                    } else {
                        $user->setMail($newemail); // Mettez à jour temporairement l'objet utilisateur
                    }
                }
                $user_mail = $newemail; // Gardez la valeur soumise pour la réafficher dans la vue
            }

            if (count($errors) == 0) {
                $user->persist_mail(); // Persistez les changements seulement si aucune erreur n'est détectée
                $this->redirect("settings", "edit_profile"); // Redirigez après la mise à jour réussie
            }
        }

        // Affichez la vue avec les données actuelles ou les données soumises, ainsi que les erreurs s'il y en a
        (new View("edit_profile"))->show([
            "user" => $user,
            "errors" => $errors,
            "user_name" => $user_name, // Ces variables peuvent contenir les valeurs soumises
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