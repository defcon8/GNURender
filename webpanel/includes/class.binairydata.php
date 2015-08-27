<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/**
 * Description of class
 *
 * @author Bastiaan
 */
class BinairyData {
    //put your code here

    private $data;
    
    public function getDataID($dataid){
        global $db;
        
        $result = $db->get_results("SELECT data FROM data WHERE dataid = ".$dataid);
        
         foreach ($result as $row) {
                $this->data = $row['data'];
         }
        
    }
    
    public function getBase64String(){
        return base64_encode($this->data);
    }
    
}
