<?php

class Model_cabinet extends Model{
    //Выдает список доступных модулей в виде списка а,б,в
    public function getUserRights($param){
       //$sql = "select dealer_id, wdb.dealer_name  from w_dealers_bulk wdb where dealer_id=124 order by wdb.dealer_id desc;";
       $sql = "select  wli_right.lib_item_cd user_right_nm
              from ".DB_NAME.".w_users wu
              inner join ".DB_NAME.".w_role_rights wrr on wu.user_role_id = wrr.role_type_id and wrr.status = 'A'
              inner join ".DB_NAME.".w_lib_item wli_type ON wli_type.lib_item_id = wrr.role_type_id
              inner join ".DB_NAME.".w_lib_item wli_right on wli_right.lib_item_id = wrr.role_right_id
              inner join ".DB_NAME.".w_lib wl on wl.lib_id = wli_right.lib_id and wl.lib_cd = 'ROLE_RIGHT'
              where wu.login = :login and wu.status = 'A'";
       $this->_setSql($sql);
       
       $data = $this->getColumnArray(array('login'=>$param->login));
        if (empty($data))
            {           return FALSE;        }
       else {           return $data;        }
    } //end getUserRights
    
    public function getUserMenu($param){
       //$sql = "select dealer_id, wdb.dealer_name  from w_dealers_bulk wdb where dealer_id=124 order by wdb.dealer_id desc;";
       $sql = "select  wli_right.lib_item_cd name, wli_right.lib_item_name value
              from ".DB_NAME.".w_users wu
              inner join ".DB_NAME.".w_role_rights wrr on wu.user_role_id = wrr.role_type_id and wrr.status = 'A'
              inner join ".DB_NAME.".w_lib_item wli_type ON wli_type.lib_item_id = wrr.role_type_id
              inner join ".DB_NAME.".w_lib_item wli_right on wli_right.lib_item_id = wrr.role_right_id
              inner join ".DB_NAME.".w_lib wl on wl.lib_id = wli_right.lib_id and wl.lib_cd = 'ROLE_MENU'
              where wu.login = :login and wu.status = 'A' order by wli_right.order_by;";
       
       $this->_setSql($sql);
       
       $data = $this->getKeyValueArray(array('login'=>$param->login));
       
       $return_data = array();
       if (empty($data)){           return FALSE;        }
       else {
           return $data;
         }
    } //end getUserRights

}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

