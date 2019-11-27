<?php

namespace App\Controller\ApiController;

use App\Util\JwtService;
use App\Model\EntityModel;
use App\Controller\CoreController;
use App\Controller\ErrorController as Error;
use App\Model\CategoryModel;

class ApiController extends CoreController {

    /**
     * Route principale de l'API
     * Permet de récupérer au format Json un ensemble d'enregistrements par limite et par types.
     * 
     */
    public function apiGet() {

        // Vérification du token
        JwtService::checkJWT();

        $result = array();

        $limit = 10;
        $category = null;

        if(!empty($_GET['limit'])) {
            $limit = intval($_GET['limit']);

            if($limit < 1) {
                $limit = 1;
            } elseif ($limit > 2500) {
                $limit = 2500;
            }
        }

        if(!empty($_GET['category'])) {
            $category = strip_tags(trim($_GET['category']));
            if($category === 'blague' ) {
                $category = 'Blague';
            } elseif ($category === 'chucknorrisfact') {
                $category = 'Chuck Norris Fact';
            } elseif ($category === 'devinette') {
                $category = 'Devinette';
            } elseif ($category === 'proverbe') {
                $category = 'Proverbe';
            } else {
                $category = null;
            }
        }

        $entityInstance = new EntityModel();
        $entities = $entityInstance->getApiAll($limit, $category);

        if(!empty($entities) && is_array($entities)) {
            foreach($entities as $entity) {
                $result[] = [
                    'id' => $entity->getId(),
                    'content' => $entity->getContent(),
                    'category' => !empty($entity->getCategory()) ? $entity->getCategory()->getName() : 'NC'
                ];
            }
        } else {
            $result[] = [
                'msg' => 'Aucun résultat trouvé'
            ];
        }

        $this->showJson($result);
    }

    /**
     * Permet de récupérer une entity en fonction de son ID
     * 
     */
    public function apiFind() {

        // Vérification du token
        JwtService::checkJWT();

        if(empty($_GET['id'])) {
            Error::error404();
        }

        $result = array();

        $id = intval($_GET['id']);

        $entityInstance = new EntityModel();
        $entity = $entityInstance->getById($id);

        if($entity) {
            $result[] = [
                'id' => $entity->getId(),
                'content' => $entity->getContent(),
                'category' => !empty($entity->getCategory()) ? $entity->getCategory()->getName() : 'NC'
            ];
        } else {
            $result[] = [
                'msg' => 'Aucun résultat trouvé'
            ];
        }

        $this->showJson($result);
    }

    /**
     * Permet d'obtenir une donnée aléatoire sur un échantillon restreint.
     * 
     */
    public function apiRandom() {
        $limit = 7;
        $result = array();
        $categoryLib = array();

        $entityInstance = new CategoryModel();
        $categories = $entityInstance->getAll();

        if(!empty($categories) && is_array($categories)) {
            foreach($categories as $category) {
                $categoryLib[] = $category->getName();
            }
        }

        shuffle($categoryLib);

        $entityInstance = new EntityModel();
        $entities = $entityInstance->getApiAll($limit, $categoryLib[0]);

        if(!empty($entities) && is_array($entities)) {
            // Génération d'un index aléatoire
            $index = random_int(0, (count($entities)-1));

            $result[] = [
                'id' => $entities[$index]->getId(),
                'content' => $entities[$index]->getContent(),
                'category' => !empty($entities[$index]->getCategory()) ? $entities[$index]->getCategory()->getName() : 'NC'
            ];
        } else {
            $result[] = [
                'msg' => 'Aucun résultat trouvé'
            ];
        }

        $this->showJson($result);
    }

    /**
     * Permet d'obtenir une donnée aléatoire sur un échantillon restreint.
     * 
     */
    public function apiGetRandom() {
        // Vérification du token
        JwtService::checkJWT();

        $result = array();

        $limit = 1;
        $category = null;

        // Limite de résultats aléatoires (n'est pas une LIMIT SQL)
        if(!empty($_GET['limit'])) {
            $limit = intval($_GET['limit']);

            if($limit < 1) {
                $limit = 1;
            } elseif ($limit > 50) {
                $limit = 50;
            }
        }

        if(!empty($_GET['category'])) {
            $category = strip_tags(trim($_GET['category']));
            if($category === 'blague' ) {
                $category = 'Blague';
            } elseif ($category === 'chucknorrisfact') {
                $category = 'Chuck Norris Fact';
            } elseif ($category === 'devinette') {
                $category = 'Devinette';
            } elseif ($category === 'proverbe') {
                $category = 'Proverbe';
            } else {
                $category = null;
            }
        }

        $entityInstance = new EntityModel();
        $entities = $entityInstance->getApiAll(2500, $category);

        // On limite la "limite" au cas où pas assez de résultats (ex : sur une catégorie ciblée)
        if($limit >= (count($entities)-1)) {
            $limit = (count($entities)-1);
        }

        if(!empty($entities) && is_array($entities)) {
            shuffle($entities);

            for($i = 0; $i < $limit; $i++) {
                $result[] = [
                    'id' => $entities[$i]->getId(),
                    'content' => $entities[$i]->getContent(),
                    'category' => !empty($entities[$i]->getCategory()) ? $entities[$i]->getCategory()->getName() : 'NC'
                ];
            }
        } else {
            $result[] = [
                'msg' => 'Aucun résultat trouvé'
            ];
        }

        $this->showJson($result);
    }

        /**
     * Permet d'obtenir une donnée aléatoire sur un échantillon restreint.
     * 
     */
    public function apiToken() {

        // Vérification du token
        if(!empty($_POST['token'])) {
            JwtService::checkJWT($_POST['token'], false);
        } else {
            JwtService::checkJWT(null, false);
        }

        // Génération d'un token JWT
        $payload = [
            'sub' => uniqid(),
            'exp' => date('Y-m-d H:i:s', strtotime('+2 days')),
            'test' => '+/='
        ];

        $jwtService = new JwtService($payload);
        $token = $jwtService->getJwt();

        // Formatage du résultat à transmettre
        $result = [
            'token' => $token,
            'exp' => $payload['exp']
        ];

        $this->showJson($result);
    }
}