<?php
use App\Models\Client;

class ClientsController extends Controller{

    public function addAction()
    {
	    /** Init Block **/
        //$errors = [];
        $data = [];
        
        /************** Validation Block *********/

         //récuperer le paramaitre
        $validator = new Validation();
        
        $data['id_agent'] = $this->request->getPost('id_agent');
        $validator->add(
            $data['id_agent'],
            new DigitValidator(
                [
                    "message" => ":field must be numeric",
                ]
            )
        );
        
        $data['id_compagnie'] = $this->request->getPost('id_compagnie');
        $validator->add(
            $data['id_compagnie'],
            new DigitValidator(
                [
                    "message" => ":field must be numeric",
                ]
            )
        );

        $data['numero_client'] = $this->request->getPost('numero_client');
         //validation du paramaitre
        $validator->add(
            $data['numero_client'],
            new AlnumValidator(
                [
                    "message" => ":field must contain only alphanumeric characters",
                ]
            )
        );

        $data['nom_client'] = $this->request->getPost('nom_client');
        $validator->add(
            $data['nom_client'],
            new AlnumValidator(
                [
                    "message" => ":field must contain only alphanumeric characters",
                ]
            )
        );

        $data['is_particulier'] = $this->request->getPost('is_particulier');
        $validator->add(
            $data['is_particulier'],
            new DigitValidator(
                [
                    "message" => ":field must be numeric",
                ]
            )
        );

        $data['is_souscripteur'] = $this->request->getPost('is_souscripteur');
         $validator->add(
            $data['is_souscripteur'],
            new DigitValidator(
                [
                    "message" => ":field must be numeric",
                ]
            )
        );

        $data['is_assuree'] = $this->request->getPost('is_assuree');
         $validator->add(
            $data['is_assuree'],
            new DigitValidator(
                [
                    "message" => ":field must be numeric",
                ]
            )
        );

        $data['is_vip'] = $this->request->getPost('is_vip');
         $validator->add(
            $data['is_vip'],
            new DigitValidator(
                [
                    "message" => ":field must be numeric",
                ]
            )
        );

        $data['id_categorie_vip'] = $this->request->getPost('id_categorie_vip');
        $validator->add(
            $data['id_categorie_vip'],
            new DigitValidator(
                [
                    "message" => ":field must be numeric",
                ]
            )
        );
        

        $data['adresse_complete'] = $this->request->getPost('adresse_complete');
        $validator->add(
            $data['adresse_complete'],
            new AlnumValidator(
                [
                    "message" => ":field must contain only alphanumeric characters",
                ]
            )
        );
 
        $data['date_creation'] = $this->request->getPost('date_creation');
        $validator->add(
            $data['date_creation'],
            new DateValidator(
                [
                    "format"  => "d-m-Y",
                    "message" => "The date is invalid",
                ]
            )
        );

        $data['user_creation'] = $this->request->getPost('user_creation');
        $validator->add(
            $data['user_creation'],
            new DigitValidator(
                [
                    "message" => ":field must be numeric",
                ]
            )
        );

        $data['uuid_client'] = $this->request->getPost('uuid_cliente');
        $validator->add(
            $data['uuid_client'],
            new AlnumValidator(
                [
                    "message" => ":field must contain only alphanumeric characters",
                ]
            )
        );
        /************** End Validation Block *********/
        
        /** Passing to business logic and preparing the response **/
        try {
            //$this->ClientModel->addClient($data);
            $client = new Client();
            $results = $client->callAddPro($data);

        } catch(Exception $e)  {
          echo "Erreur de la creation" ;
            
        }
       
      /** End Passing to business logic and preparing the response  **/
    }










       
       
}