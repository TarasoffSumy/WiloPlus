<?php
class View
{
    
    
    function generate($content_view, $template_view, $data = null)
    {
//        Данные для отображения принимаем в json и декодируем в асс. массив
        if($data) {
             $data = json_decode($data, true);
         }
        
        
        include 'application/views/'.$template_view;
    }
}

