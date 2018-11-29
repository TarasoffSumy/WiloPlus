<?php
class Route
{
    function is_ajax() {
            return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    } 
    
    static function start()
    {
        
        //поменяеть на пустое после тестирования
        
        // контроллер и действие по умолчанию
        $controller_name = 'main';
        $controller_test = TRUE;
        $action_name = 'index';
        //Получаем адресную строку и разбиваем ее по слеlу
        $routes = explode('/', str_replace(ROOT_DIRECTORY, '', $_SERVER['REQUEST_URI']));

        // получаем имя контроллера - это первое имя в адресной строке
        if ( !empty($routes[1]) )
        {	
            //Убираем знак "?" для случаев когда запрос идет из формы
            $controller_name = explode('?', $routes[1]);
            $controller_name = $controller_name[0];
        }
        //echo $routes[1]."||".$routes[2]."|||".str_replace('/',"",$root_directory)."|||";
        // получаем имя экlена - это втрое имя в адресной строке
        if ( !empty($routes[2]) )
        {
            //Убираем знак "?" для случаев когда запрос идет из формы
            $action_name = explode('?', $routes[2]);
            $action_name = $action_name[0];
        }
     //}
        //Проверем доступ
        $valid_request = 0;
        //ниже указанны имена контроллеров, к которым есть доступ без авторизации
        if (($controller_name === 'login')||($controller_name === 'main')||($controller_name==='404')) {
            $valid_request = 1;
        }
        //Защита уровня 0 от неавторизированных пользователей
        else if (isset($_SESSION['SESS_ID'])) {
            $valid_request = 1;
        }
      
        if ($valid_request === 1){
            
            // добавляем префиксы
            $model_name = 'model_'.$controller_name;
            $controller_name = 'controller_'.$controller_name;
            $action_name = 'action_'.$action_name;
            
        } 
        else {
            header('Location:'.ROOT_DIRECTORY);
        }

        // подцепляем файл с классом модели (файла модели может и не быть)
        $model_file = strtolower($model_name).'.php';
        $model_path = "application/models/".$model_file;
        if(file_exists($model_path))
        {
            include "application/models/".$model_file;
        }
        
        // подцепляем файл с классом контроллера
        $controller_file = strtolower($controller_name).'.php';
        $controller_path = "application/controllers/".$controller_file;
        if(file_exists($controller_path))
        {
            include $controller_path;
        }
        else
        {
            if ($controller_test){
                echo 'Error: $controller_path = '.$controller_path.' not found';
            }
            else {
               Route::ErrorPage404();
            }
        }
        
        // создаем контроллер
        $controller = new $controller_name;
        $action = $action_name;
        
        if(method_exists($controller, $action))
        {
            // вызываем действие контроллера
            $controller->$action();
        }
        else
        {
            if ($controller_test){
               echo 'Error: $metod_exist failed: '.var_dump($controller).' action: '.var_dump($action);    
                
            }
            else 
            {
               Route::ErrorPage404();    
            }
            
            
        }
    
    }
    
    static function ErrorPage404()
    {
        header('Location:'.ROOT_DIRECTORY.'/404');
    }
}
?>
