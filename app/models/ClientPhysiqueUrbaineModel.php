<?php

use Phalcon\Mvc\Model;
use Core\Db\Database;
use App\Controllers;

class ClientPhysiqueUrbaineModel extends Model {
    
    public static function ajouterClientPhysiqueUrbaine($params){
        $db = new Database();
        $sp = '[dbo].[ps_creer_client_physique_urbaine]';
        $result = $db->execSP($sp, $params ); 
        return $result;

    }

}