<?php

use Phalcon\Mvc\Model;
use Core\Db\Database;
use App\Controllers;

class ClientMoraleUrbaineModel extends Model {
    
    public static function ajouterClientMoraleUrbaine($params){
        $db = new Database();
        $sp = '[dbo].[ps_creer_client_morale_urbaine]';
        $result = $db->execSP($sp, $params ); 
        return $result;

    }

}