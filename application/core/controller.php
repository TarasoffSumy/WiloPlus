<?php
class Controller {
    //Function to check if the request is an AJAX request

    // Создаем общий класс Контроллера, который запраlивает модель и вид для создания страницы
    public $model;
    public $view;
    
    //Конструктор класса обязательно создает новый объект класса Вид
    function __construct()
    {
        
            $this->view = new View();
            

    }
    
    //Обязательный метод класса Index выполняется по умолчанию, если не 
    //указан иной при вызове контроллера из Route
    function action_index()
    {
    }
    
    function send_email($To, $Subj, $Body) {
            $headers   = array();
            $headers[] = "MIME-Version: 1.0";
            $headers[] = "Content-type: text/html; charset=utf8";
            $headers[] = "From: ВІЛО УКРАЇНА <admin@wiloexpert.com.ua>";
            $headers[] = "Reply-To: ВІЛО УКРАЇНА <talavas@wilo.ua>";
            $headers[] = "Subject: {$Subj}";
            $headers[] = "X-Mailer: PHP/".phpversion();
 
            mail($To, $Subj, $Body, implode("\r\n", $headers));
        }
}

