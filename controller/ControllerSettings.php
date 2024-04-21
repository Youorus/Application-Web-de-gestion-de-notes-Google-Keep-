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

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['currentpassword'], $_POST['newpassword'], $_POST['confirmpassword'])) {
            $currentpassword = $_POST['currentpassword'];
            $newpassword = $_POST['newpassword'];
            $confirmpassword = $_POST['confirmpassword'];

            // Vérifier si le mot de passe actuel est correct
            if (!$user->verifyPassword($currentpassword)) {
                $errors[] = "Le mot de passe actuel est incorrect.";
            }

            // Vérifier si le nouveau mot de passe correspond à la confirmation
            if ($newpassword !== $confirmpassword) {
                $errors[] = "Le nouveau mot de passe et la confirmation ne correspondent pas.";
            }

            // Vérifier si le nouveau mot de passe est différent de l'ancien
            if ($user->verifyPassword($newpassword)) {
                $errors[] = "Le nouveau mot de passe doit être différent de l'ancien.";
            }

            // Si aucune erreur, mettre à jour le mot de passe et rediriger
            if (empty($errors)) {
                $user->setHashedPassword(Tools::my_hash($newpassword));
                $user->persist();
                // Redirection vers la page de paramètres
                $this->redirect("settings");
                return; // Important pour arrêter l'exécution après la redirection
            }
        }

        (new View("change_password"))->show(["errors" => $errors, "success" => $success]);
    }



/*
    public function edit_profile(): void
    {
        $user = $this->get_user_or_redirect();
        $errors = [];


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $full_name = isset($_POST['full_name']) ? trim($_POST['full_name']) : '';
            $newemail = isset($_POST['email']) ? trim($_POST['email']) : '';

            if (empty($full_name)) {
                $errors[] = "Le champ du nom complet ne peut pas être vide.";
            } elseif ($full_name != $user->getFullName()) {
                $user->setName($full_name); // Mise à jour temporaire
                $errors = array_merge($errors, User::validate($full_name));
            }

            if (empty($newemail)) {
                $errors[] = "Le champ de l'email ne peut pas être vide.";
            } elseif ($newemail != $user->getMail()) {
                if (isset($_POST['full_name'])) {
                    $full_name = $_POST['full_name'];
                    $user_name = $full_name;

                    if ($full_name != $user->getName()) {
                        $user->setName($full_name);
                        $errors = array_merge($errors, User::validate($full_name));
                    }
                }

                if (isset($_POST['email'])) {
                    $newemail = $_POST['email'];
                    $user_mail = $newemail;

                    if ($newemail != $user->getMail()) {
                        $emailErrors = User::validate_unicity($user_mail);
                        if (!empty($emailErrors)) {
                            $errors = array_merge($errors, $emailErrors);
                        } else {
                            $user->setMail($user_mail);
                        }
                    }

                    if (empty($errors)) {
                        $user->persist();
                        $this->redirect("settings");
                        return;
                    }
                }


            }
        }
        (new View("edit_profile"))->show([
            "user" => $user,
            "errors" => $errors,
            "user_name" => $user->getFullName(),
            "user_mail" => $user->getMail(),
        ]);

    }
*/
    public function edit_profile(): void
    {
        $user = $this->get_user_or_redirect();
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $full_name = $_POST['full_name'] ?? '';
            $new_email = $_POST['email'] ?? '';

            if (empty($full_name)) {
                $errors = "Le champ du nom complet ne peut pas être vide.";
            } elseif ($full_name != $user->getFullName()) {
                $user->setName($full_name);
                $errors = array_merge($errors, User::validate($full_name));
                if (empty($errors)) {
                    $user->persist_name();
                }
            }

            if (empty($new_email)) {
                $errors['email'] = "Le champ de l'email ne peut pas être vide.";
            } elseif ($new_email != $user->getMail()) {
                $emailErrors = User::validate_unicity($new_email);
                if (empty($emailErrors)) {
                    $user->setMail($new_email);
                    $user->persist_mail();
                } else {
                    $errors['email'] = $emailErrors;
                }
            }

            if (empty($errors)) {
                $this->redirect("settings");
            }
        }

        // Afficher la vue avec les erreurs potentielles
        (new View("edit_profile"))->show([
            "user" => $user,
            "errors" => $errors,
            "user_name" => $user->getFullName(),
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