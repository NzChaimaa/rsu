<?php

use Phalcon\Mvc\Model;
use Core\Db\Database;
use App\Controllers;

class ClientPhysiqueRuraleModel extends Model {
    
    public static function ajouterClientPhysiqueRurale($params){
        $db = new Database();
        $sp = '[dbo].[ps_creer_client_physique_rurale]';
        $result = $db->execSP($sp, $params ); 
        return $result;

    }

}