<?php

use Phalcon\Mvc\Model;
use Core\Db\Database;
use App\Controllers;

class SelectClientPhysiqueByRefModel extends Model {
    
    public static function selectClientPhysique($params){
        $db = new Database();
        $sp = '[dbo].[select_clientphysique_by_ref]';
        $result = $db->selectClient($sp, $params ); 
        return $result;

        
        // $sql = 'select all from [dbo].[agence] where';
        // $result = $db->selectAll($sql);
        

    }

}