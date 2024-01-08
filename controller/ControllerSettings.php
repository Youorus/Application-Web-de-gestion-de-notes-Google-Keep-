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

    


}


?>