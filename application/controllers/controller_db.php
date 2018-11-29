<?php


class Controller_db extends Controller
{
    function __construct() {
        
        parent::__construct();
        $this->model = new Model_database;
        
    }
    
    function action_getArticleTable($param=NULL){
      $param = json_decode(json_encode($_POST));
        if ($this->model->role === 'Administrator' ){
            $param = new stdClass();
            $data = $this->model->getArticleTable($param) ;
            echo $data;
        }
    }
    function action_createArticle(){
        $param = json_decode(json_encode($_POST));
        $param->stat = new stdClass();
        if (!$param->ArticleId){  
            $param->ArticleId = new stdClass();
            $param->ArticleId = '';
        }
        $param = $this->model->createArticle($param);
        echo json_encode($param->stat);
    }
    
    function action_getDealersTable($param=NULL){
        $param = json_decode(json_encode($_POST));
        if ($this->model->role === 'Administrator' ){
            $param = new stdClass();
            $data = $this->model->getDealersTable($param) ;
            echo $data;
        }
    } 
     
    function action_getDealerWarrantyTable($param=NULL){
        $param = json_decode(json_encode($_POST));
        if ($this->model->role === 'Administrator' ){
            $param = new stdClass();
            $data = $this->model->getDealerWarrantyTable($param) ;
            echo $data;
        }
    }
    
    function action_getDealersRegionList() {
        $data = $this->model->getDealersRegionList();
        echo $data;        
    }
    
    function action_getmanagerList() {
        $data = $this->model->getManagerList();
        echo $data;        
    }
    
    function action_createDealer(){
        $param = json_decode(json_encode($_POST));
        $param->stat = new stdClass();
        if (!$param->id){  
            $param->id = new stdClass();
            $param->id = '';
        }
        $param = $this->model->createDealer($param);
        echo json_encode($param->stat);
    }
    
    function action_createDealerWarrantyRange(){
        $param = json_decode(json_encode($_POST));
        
        $param->stat = new stdClass();
        if (!$param->DealerWarrantyId){  
            $param->DealerWarrantyId = new stdClass();
            $param->DealerWarrantyId = '';
        }
        $param = $this->model->createDealerWarrantyRange($param);
//        $param->stat->title = "Редагування Дилерів<br>";
//        $param->stat->priority = "info"; //success, danger, warning, info
//        $param->stat->message = $param->end_number;
        echo json_encode($param->stat);
//        echo "<script type='text/javascript'>alert('kkkk');</script>";
        
    }

    function action_setDealerWarrantyStatus(){
       $param = json_decode(json_encode($_POST));
       $param->stat = new stdClass(); 
       $param = $this->model->setDealerWarrantyStatus($param);
       echo json_encode($param->stat);
    }
    
    function action_setArticleStatus(){
       $param = json_decode(json_encode($_POST));
       $param->stat = new stdClass(); 
       $param = $this->model->setArticleStatus($param);
       echo json_encode($param->stat);
    }
    
    function action_setDealerStatus(){
       $param = json_decode(json_encode($_POST));
//        $param['dealer_id'] = $_POST['dealer_id'];
//        $param['status'] = $_POST['status'];
          
        $param->stat = new stdClass(); 
        $param = $this->model->setDealerStatus($param);
//        echo var_dump($param->status);
       echo json_encode($param->stat);
    }
    
}
// Thread stack overrun: 7644 bytes used of a 131072 byte stack, and 128000 bytes needed. 
// Use 'mysqld --thread_stack=#' to specify a bigger stack. (Remembered answer: "OK". Enable)

?>