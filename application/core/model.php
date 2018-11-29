<?php
//Класс модели работает с базой данных, поэтому обьявляем свойства
// $_db - подключение к базе и $_sql запрос к базе

class Model
{
    protected $_db;
    protected $_sql;
//    public $role;
    
    //Конвертирует обычный массив в массив JSON с паралельной конвертацией из UNICODE -> UTF8
    public function utf8_json($array)
    {
     return   preg_replace_callback(
             '/\\\u([0-9a-fA-F]{4})/'
             , create_function('$_m', 'return mb_convert_encoding("&#" . intval($_m[1], 16) . ";", "UTF-8", "HTML-ENTITIES");'),
            json_encode($array)
        );
    }
    
    //Конструктор класса связывает глобальный объект PDO::MySQL со свойством класса Модель
    public function __construct() {
        
        global $dbObject;
        $this->_db = $dbObject;
//        $this->getSessionRole();
    }
    
    //Метод класса для установки в свойство класса Модель строки запроса
    public function _setSql($sql){
        $this->_sql = $sql;
    }
    
    //Метод класса для получания всех данных от запроса sql
    public function getAll($data = NULL) {
        if(!$this->_sql){
            throw new Exception("Отсутствует запрос к базе данных");
        }
        $result = $this->_db->prepare($this->_sql);
        $result->execute($data);
        return $result->fetchAll();        
    }
    
    //Метод для получения одной строки
    public function getRow($data=NULL){
//        $this->_db->query("SET CHARACTER SET utf8");
        if(!$this->_sql){
            throw new Exception("Отсутствует запрос к базе данных");
        }
        $result = $this->_db->prepare($this->_sql);
        $result->execute($data);
        return $result->fetch();
       }
    
    public function getColumnArray($data=NULL) {
        $result = $this->_db->prepare($this->_sql);
        $result->execute($data); 
        return $result->fetchAll(PDO::FETCH_COLUMN, 0); 
    }  
    
    //to be decommissed
    public function executeSQL($sql){
        $result = $this->_db->query($sql);
        return $result;
    }
    
    //to be decommissed
    public function getKeyValuePairs($data=NULL){
        $result = $this->_db->prepare($this->_sql);
        $result->execute($data);  
        return $result->fetchAll(PDO::FETCH_ASSOC);
    } 
    
    public function getKeyValueArray($data=NULL){
        $result = $this->_db->prepare($this->_sql);
        $result->execute($data); 
        return $result->fetchAll(PDO::FETCH_KEY_PAIR); 
    } 

       //Метод для добавления строки
    public function addRow($data=NULL){
        $result = $this->_db->prepare($this->_sql);
        $result->execute($data); 
        return $result;
    }
    
    //Метод для обновления записи
    public function updateRow($data=NULL) {
        $result = $this->_db->prepare($this->_sql);
        $result->execute($data); 
        return $result;
    }
    
    //Метод для удаления записи
    public function deleteRow($data=NULL) {
        $result = $this->_db->prepare($this->_sql);
        $result->execute($data); 
        return $result;
    }
    
//    public function getSessionRole(){
//    $sql = "select wli.lib_item_cd role
//            from ".DB_NAME.".w_login_sessions ls, ".DB_NAME.".w_users wu, ".DB_NAME.".w_lib_item wli
//            where ls.session_id = :session
//            and ls.login = wu.login
//            and wu.status = 'A'
//            and wli.lib_item_id = wu.user_role_id
//            and wli.lib_id = 1"
//            ;
//    $this->_setSql($sql);
//    $sess_id = session_id();
//    $data = $this->getRow(array("session"=>$sess_id));
//    if(!empty($data['role'])){
//        $this->role =  $data['role'];
//    }
//    else{
//        $this->role = 'unknown';
//    }
//    }
}
