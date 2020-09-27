<?php

use Phalcon\Mvc\Model;
use Core\Db\Database;
use App\Controllers;

class ClientMoraleRuraleModel extends Model {
    
    public static function ajouterClientMoraleRurale($params){
        $db = new Database();
        $sp = '[dbo].[ps_creer_client_morale_rurale]';
        $result = $db->execSP($sp, $params ); 
        return $result;

    }

}