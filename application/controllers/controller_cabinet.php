<?php

class Controller_cabinet extends Controller
{
	function action_index(){
            
            $menu = new Model_cabinet();
            
            $menu->getSessionRole();
            
            //Задаем параметры для вызова SQL
            $param = json_decode('{"login":"'.$_SESSION['SESS_MEMBER_ID'].'"}');
            $data['urls']       = $menu->getUserRights($param);
            $data['name']       = $_SESSION['SESS_FIRST_NAME']." ".$_SESSION['SESS_LAST_NAME'] ; //SESSION_NAME
            $data['menu-btn']   = $menu->getUserMenu($param);
            
            $data['role'] = $menu->role;
           
            try {
                //echo var_dump(json_encode($data));
                $this->view->generate('cabinet_view.php', 'template_view.php', json_encode($data));
            }
            catch (Exception $e){
                echo "Помилка створення кабінету:".$e->getMessage();
            }	
        }
}