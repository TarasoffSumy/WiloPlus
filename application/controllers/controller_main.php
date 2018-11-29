<?php
 
class Controller_main extends Controller
{
    function action_index() {	
//	session_unset();
//        session_destroy();
//        session_start();
//	session_regenerate_id();
        try {
            $this->view->generate('main_view.php', 'template_view.php');
        }
        catch (Exception $e){
            echo "РћС€РёР±РєР° РїСЂРёР»РѕР¶РµРЅРёСЏ:".$e->getMessage();
        }
    }
}