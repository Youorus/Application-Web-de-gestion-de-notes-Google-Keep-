<?php
require_once "framework/Controller.php";


class ControllerSetting extends Controller{


    public function index(): void{
        
        (new View("nav"))->show();

    }

    public function setting(): void{
        
        (new View("setting"))->show();

    }


    
}


?>