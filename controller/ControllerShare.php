<?php
require_once 'model/TextNote.php';
require_once 'framework/View.php';
require_once 'framework/Controller.php';

class ControllerShare extends Controller
{
    public function index(): void
    {

    }

    public function note(): void {
        (new View("shares"))->show([]);
    }


}
?>
