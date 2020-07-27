<?php
class Client extends Model {
   
    public static function callAddPro($client = NULL) {
       // A raw SQL statement
        $sql = "CALL `PS_CreatClient`('$client->id_agent','$client->id_compagnie','$client->numero_client', '$client->nom_client ', '$client->is_particulier', '$client->is_souscripteur', '$client->is_assuree', '$client->is_vip', '$client->id_categorie_vip', '$client->adresse_complete', '$client->date_creation', '$client->client_creation', '$client->uuid_client');";
        // Base model
        $client = new Client();
         // Execute the query
        return new Resultset(null,  $client,  $client->getReadConnection()->query($sql));
    }
    
}


