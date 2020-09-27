<?php

use App\Controllers;
use Core\Http\Request;
use Core\Http\Response;
use App\Models;

class ClientMoraleRuraleController extends PrivateController {

    public function ajouterClientMoraleRAction() {
        $request = new Request();
        $params=[];
        $errors=[];
       
        $params['is_vip'] = $this->request->getPost('is_vip');
        if(!preg_match('/^[0-1]{1}$/', $params['is_vip'] )){
            $errors['is_vip'] = 'Erreur Saisir 1 pour Sociétaire Vip sinon 0';
        }

        $params['forme_juridique'] = $this->request->getPost('forme_juridique');
        if ((empty($params['forme_juridique'])) || (!preg_match('/^[A-Z ]{2,30}$/', $params['forme_juridique']))) {
            $errors['forme_juridique'] = 'Erreur la forme juridique doit contient seulement des alphabets en majuscule';
        }

        $params['raison_sociale'] = $this->request->getPost('raison_sociale');
        if ((empty($params['raison_sociale'])) || (!preg_match('/^[A-Z0-9 ]{2,30}$/', $params['raison_sociale']))) {
            $errors['raison_sociale'] = 'Erreur la raison social doit consiste des lettres en majuscule';
        }

        $params['nom_abreg'] = $this->request->getPost('nom_abreg');
        if ((empty($params['nom_abreg'])) || (!preg_match('/^[A-Z0-9 ]{2,30}$/', $params['nom_abreg']))) {
            $errors['nom_abreg '] = 'Erreur Nom Abrégé doit consiste des lettres en majuscule';
        }
        
        $params['tel_fixe'] = $this->request->getPost('tel_fixe');
        if ((empty($params['tel_fixe'])) || (!preg_match('/^[0-9 ]{2,30}$/', $params['tel_fixe']))) {
            $errors['tel_fixe'] = 'Erreur le telephone fixe doit contient seulement des chiffres';
        }

        $params['fax'] = $this->request->getPost('fax');
        if ((empty($params['fax'])) || (!preg_match('/^[0-9 ]{2,30}$/', $params['fax']))) {
            $errors['fax'] = 'Erreur FAX doit contient seulement des chiffres';
        }

        $params['nom_holding'] = $this->request->getPost('nom_holding');
        if ((empty($params['nom_holding'])) || (!preg_match('/^[A-Z0-9 ]{2,30}$/', $params['nom_holding']))){
            $errors['nom_holding'] = 'Erreur Nom du holding doit contient des alphabets en majuscule';
        }

        $params['ice'] = $this->request->getPost('ice');
        if ((empty($params['ice'])) || (!preg_match('/^[0-9 ]{15}$/', $params['ice']))) {
            $errors['ice'] = 'Erreur l\'ICE doit contient seulement 15 chiffres';
        }

        $params['numero_patente'] = $this->request->getPost('numero_patente');
        if ((empty($params['numero_patente'])) || (!preg_match('/^[0-9 ]{1,15}$/', $params['numero_patente']))) {
            $errors['numero_patente'] = 'Erreur le Numero de patente doit contient seulement des chiffres';
        }
        
        $params['identifient_fiscale'] = $this->request->getPost('identifient_fiscale');
        if((empty($params['identifient_fiscale'])) || (!preg_match('/[0-9 ]{2,100}/', $params['identifient_fiscale']))){
            $errors['identifient_fiscale'] = 'l\'Identifient Fiscale  doit consiste seulement des chiffres';
        }

        $params['activite'] = $this->request->getPost('activite');
        if ((empty($params['activite'])) || (!preg_match('/^[A-Z0-9 ]{2,30}$/', $params['activite']))){
            $errors['activite'] = 'Erreur l\'activitie doit contient des alphabets en majuscule';
        }
    
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
            $errors['libelle_pays'] = 'Erreur le pays du sociétaire doit contient seulment des alphabets en majuscule';
        }

        if ($errors) {
            $response = new Response();
            $response->setContent(json_encode($errors));
        }

        else {
            $response_data = ClientMoraleRuraleModel::ajouterClientMoraleRurale($params);
            $response = new Response();
            $response->setContent(json_encode($response_data));
        }
        return $response;

        
    }





}