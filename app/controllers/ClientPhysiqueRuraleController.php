<?php
use App\Controllers;
use Core\Http\Request;
use Core\Http\Response;
use App\Models;


class ClientPhysiqueRuraleController extends PrivateController{
   
    public function ajouterClientPhysiqueRAction() {

        $request = new Request();
        $errors=[];
        $params=[];

        $params['qualite'] = $this->request->getPost('qualite');
        if ((empty($params['qualite'])) || (!preg_match('/^[A-Z ]{3,16}$/', $params['qualite']))) {
            $errors['qualite'] = 'Erreur la qualite du sociétaire doit contient seulment des alphabets en majuscule';
        }

        $params['nom_client'] = $this->request->getPost('nom_client');
        if ((empty($params['nom_client'])) || (!preg_match('/^[A-Z ]{3,16}$/', $params['nom_client']))) {
            $errors['nom_client'] = 'Erreur le nom du sociétaire doit contient seulment des alphabets en majuscule';
        }
        $params['prenom_client'] = $this->request->getPost('prenom_client');
        if ((empty($params['prenom_client'])) || (!preg_match('/^[A-Z ]{3,16}$/', $params['prenom_client']))){
            $errors['prenom_client'] ='Erreur le prenom du sociétaire doit contient seulment des alphabets en majuscule';
        }
        $params['sexe_client'] = $this->request->getPost('sexe_client');
        if ((empty($params['sexe_client'])) || (!preg_match('/^[F-H]{1}$/', $params['sexe_client']))){
            $errors['sexe_client'] ='Erreur le sexe est invalide saisir H pour homme ou F pour femme';
        }
        $params['date_naissance'] = $this->request->getPost('date_naissance');

        $params['nationalite'] = $this->request->getPost('nationalite');
        if ((empty($params['nationalite'])) || (!preg_match('/^[A-Z ]{2,30}$/', $params['nationalite']))) {
             $errors['nationalite'] = 'Erreur la nationalité du sociétaire doit contient seulment des alphabets en majuscule';
        }

        $params['libelle_pays'] = $this->request->getPost('libelle_pays');
        if ((empty($params['libelle_pays'])) || (!preg_match('/^[A-Z ]{2,30}$/', $params['libelle_pays']))) {
            $errors['libelle_pays'] = 'Erreur le pays du sociétaire doit contient seulment des alphabets en majuscule';
        }

        // $params['type_document'] = $this->request->getPost('type_document');
        // if ((empty($params['type_document'])) || (!preg_match('/^[A-Za-z ]{2,30}$/', $params['type_document']))) {
        //     $errors['type_document'] = 'Erreur le type du document doit contient seulment des alphabets Ex:CIN/Permis/...';
        // }

        $params['reference_document'] = $this->request->getPost('reference_document');
        if ((empty($params['reference_document'])) || (!preg_match('/^[A-Z0-9 ]{2,30}$/', $params['reference_document'])) ) {
            $errors['reference_document'] = 'Erreur le Numéro de référence doit contient des lettres en majuscule et des nombres ';
        }

        $params['date_delivrance'] = $this->request->getPost('date_delivrance');

        // $params['lieu_delivrance'] = $this->request->getPost('lieu_delivrance');
        // if ((empty($params['lieu_delivrance'])) || (!preg_match('/^[A-Za-z ]{2,30}$/', $params['lieu_delivrance']))) {
        //     $errors['lieu_delivrance'] = 'Erreur le lieu de délivrance doit contient seulement des lettres';
        // }

        //$params['date_expiration'] = $this->request->getPost('date_expiration');

        $params['profession'] = $this->request->getPost('profession');
        if ((empty($params['profession'])) || (!preg_match('/^[A-Z ]{2,30}$/', $params['profession']))) {
            $errors['profession'] = 'Erreur la profession du societaire doit consiste seulement des lettres';
        }

        $params['nom_organisme_affiliation'] = $this->request->getPost('nom_organisme_affiliation'); 
         if ((empty($params['nom_organisme_affiliation'])) || (!preg_match('/^[A-Z0-9 ]{2,30}$/', $params['nom_organisme_affiliation']))) {
            $errors['nom_organisme_affiliation'] = 'Erreur le nom d\'organisme affiliation doit consiste seulement des lettres ou des nombres';
        }

        $params['reference_appartenance'] = $this->request->getPost('reference_appartenance');
        if ((empty($params['reference_appartenance'])) || (!preg_match('/^[A-Z0-9 ]{2,15}$/', $params['reference_appartenance']))) {
            $errors['reference_appartenance']  = 'Erreur la reference d\'appartenance doit consiste  des lettres en majuscule';
        }

        $params['telephone_mobile'] = $this->request->getPost('telephone_mobile');
        if ((empty($params['telephone_mobile'])) || (!preg_match('/^[0-9 ]{1,12}$/', $params['telephone_mobile']))) {
            $errors['telephone_mobile'] = 'Erreur le telephone mobile doit consiste seulement des nombres';
        }

        $params['email'] = $this->request->getPost('email');
        if ((empty($params['email']))) {
            $errors['email'] = 'Erreur Email vide sair une forme valid Ex:exemple@gmail.com';
        }
        
        // $params['numero_client'] = $this->request->getPost('numero_client');
        // if((empty($params['numero_client'])) || (!preg_match('/^[A-Za-z0-9 ]{2,15}$/', $params['numero_client']))){
        //     $errors['numero_client'] = 'Erreur le numero du client doit consiste des lettres et des nombres';
        // }

        $params['is_vip'] = $this->request->getPost('is_vip'); 
        if(!preg_match('/^[0-1]{1}$/', $params['is_vip'] )){
            $errors['is_vip'] = 'Erreur Saisir 1 pour Sociétaire Vip sinon 0';
        }

        // $params['categorie_vip'] = $this->request->getPost('categorie_vip');
        // if ((empty($params['categorie_vip'])) || (!preg_match('/^[A-Za-z ]{2,30}$/', $params['categorie_vip']))) {
        //     $errors['categorie_vip'] = 'Erreur la categorie Vip doit consiste des lettres';
        // }
        
        $params['type_adresse'] = $this->request->getPost('type_adresse');
        if ((empty($params['type_adresse'])) || (!preg_match('/^[R-U]{1}$/', $params['type_adresse']))){
            $errors['type_adresse'] ='taper R pour Rural ou U pour Urbaine';
        }

        $params['complement_adresse'] = $this->request->getPost('complement_adresse');
        if ((empty($params['complement_adresse'])) || (!preg_match('/^[A-Z0-9 ]{2,15}$/', $params['complement_adresse']))) {
            $errors['complement_adresse']  = 'Erreur le complement d\'adresse doit consiste  des lettres en majuscule';
        }

        $params['kiyada'] = $this->request->getPost('kiyada');
        if ((empty($params['kiyada'])) || (!preg_match('/^[A-Z0-9 ]{2,30}$/', $params['kiyada']))) {
            $errors['kiyada'] = 'Erreur Kiyada doit consiste des lettres en majuscule';
        }

        $params['douar'] = $this->request->getPost('douar');
        if ((empty($params['douar'])) || (!preg_match('/^[A-Z0-9 ]{2,30}$/', $params['douar']))) {
            $errors['douar'] = 'Erreur douar doit consiste des lettres en majuscule';
        }

        $params['province'] = $this->request->getPost('province');
        if ((empty($params['province'])) || (!preg_match('/^[A-Z ]{2,30}$/', $params['province']))) {
            $errors['province'] = 'Erreur la province du societaire doit consiste seulement des lettres en majuscule';
        }
        

        $params['commune'] = $this->request->getPost('commune');
        if ((empty($params['commune'])) || (!preg_match('/^[A-Z ]{2,30}$/', $params['commune']))) {
            $errors['commune'] = 'Erreur la commune du societaire doit consiste seulement des lettres en majuscule';
        }

        $params['libelle_pays'] = $this->request->getPost('libelle_pays');
        if ((empty($params['libelle_pays'])) || (!preg_match('/^[A-Z ]{2,30}$/', $params['libelle_pays']))) {
            $errors['libelle_pays'] = 'Erreur la libelle pays  doit consiste seulement des lettres en majuscule';
        }

        $params['secteur'] = $this->request->getPost('secteur');
        if ((empty($params['secteur'])) || (!preg_match('/^[A-Z ]{2,30}$/', $params['secteur']))) {
            $errors['secteur'] = 'Erreur le secteur  d\'activité doit consiste seulement des lettres en majuscule';
        }
        
        if ($errors) {
            $response = new Response();
            $response->setContent(json_encode($errors));

        }
        else {
            $response_data = ClientPhysiqueRuraleModel::ajouterClientPhysiqueRurale($params);
            $response = new Response();
            $response->setContent(json_encode($response_data));
        }
        return $response;
    
    }
    

}