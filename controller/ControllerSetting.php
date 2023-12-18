<?php
require_once "framework/Controller.php";


class ControllerSetting extends Controller{


    public function index(): void{
        
        (new View("nav"))->show();

    }

    public function setting(): void{
        
        (new View("setting"))->show();

    }


    public function fullName(): void{
        $fullName = User::get_user_fullName(1); //changer le 1
        (new View("setting"))->show(["fullName" => $fullName]);
    }




    
}


?>