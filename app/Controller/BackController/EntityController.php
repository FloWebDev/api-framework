<?php

namespace App\Controller\BackController;

use App\Controller\CoreController;
use App\Controller\SecurityController;
use App\Model\EntityModel;
use App\Model\CategoryModel;

class EntityController extends CoreController {
    
    /**
     * Permet d'afficher la liste complète des entités
     * 
     */
    public function entityList() {
        // Vérifie que l'utilisateur soit connecté
        SecurityController::isConnected();

        // On bloque la possibilité de se rendre sur la page /dashboard?page=1
        if(!empty($_GET['page']) && intval($_GET['page']) === 1) {
            $this->redirect('/dashboard');
        }
        $limit = 10;
        $offset = 0;

        $currentPage = !empty($_GET['page']) ? intval($_GET['page']) : 1;
        $previousPage = $currentPage == 1 ? false : $currentPage - 1;
        $nextPage = $currentPage + 1;

        // Gestion de la pagination des résultats
        $pagination = [
            'currentPage' => $currentPage,
            'previousPage' => $previousPage,
            'nextPage' => $nextPage
        ];

        if(!empty($_GET['page'])) {
            $offset = $limit * ($currentPage - 1);
        }

        // Récupération de toutes les catégories
        $categoryInstance = new CategoryModel();
        $categoryList = $categoryInstance->getAll();
        
        $categories = array();
        foreach($categoryList as $category) {
            $categories[$category->getId()] = $category->getName();
        }

        if(!empty($_GET['search'])) {
            $keyword = strip_tags(trim($_GET['search']));

            $entityInstance = new EntityModel();
            $entities = $entityInstance->search($keyword, 1000, $offset);

            if(!empty($entities) && is_array($entities)) {
                $this->flash('<b>' . count($entities) . '</b> résultats trouvés.', 1);
            } else {
                $this->flash('Aucun résultat trouvé.', 'danger');
            }
        } else {
            $entityInstance = new EntityModel();
            $entities = $entityInstance->getAll('DESC', $limit, $offset);
        }

        $this->assign('entities', $entities);
        $this->assign('categories', $categories);
        $this->assign('pages', $pagination);
        $this->assign('h1Title', 'Tableau de bord');
        $this->assign('h2Title', 'Tableau de bord');
        $this->showView('dashboard');
    }

    /**
     * Permet de créer une nouvelle entrée
     * 
     */
    public function entityNew() {
        // Vérifie que l'utilisateur soit connecté
        SecurityController::isConnected();

        if(!empty($_POST)) {
            // Vérification du token de session
            SecurityController::checkToken();

            // Pour éviter de ressaisir la entity en cas d'erreur
            if(!empty($_POST['content'])) {
                $_SESSION['content'] = strip_tags(trim($_POST['content']));
            }

            if(empty($_POST['content']) || empty($_POST['category'])) {
                $this->flash('Informations manquantes.<br>Vous devez ajouter un <strong>contenu</strong> et sélectionner une <strong>catégorie</strong>.', 'danger');
                $this->redirect('/new/entity');
            }
            
            $content = strip_tags(trim($_POST['content']));
            $categoryId = intval($_POST['category']);

            if(strlen($content) < 10 || strlen($content) > 5000) {
                $this->flash('Le contenu doit être supérieur à <strong>10</strong> caractères.<br>Le contenu ne doit pas excéder <strong>5000</strong> caractères.', 'danger');
                $this->redirect('/new/entity');
            }

            unset($_SESSION['content']);

            $newEntity = new EntityModel();
            $newEntity->setContent($content);
            $newEntity->setCategoryId($categoryId);
            $newEntity->new();

            $this->flash('Nouvelle Entity correctement enregistrée en base.', 1);
            $this->redirect('/new/entity');
        }
        
        $categoryInstance = new CategoryModel();
        $categories = $categoryInstance->getAll();

        $this->assign('pageTitle', 'Création d\'une nouvelle entrée');
        $this->assign('categories', $categories);
        $this->showView('entityNew');
    }

    /**
     * Permet de modifier une Entity par son id
     * 
     */
    public function entityUpdate($id) {
        // Vérifie que l'utilisateur soit connecté et administrateur
        SecurityController::isAdmin();

        if(!empty($_POST)) {
            // Vérification du token de session
            SecurityController::checkToken();

            // Pour éviter de ressaisir la entity en cas d'erreur
            if(!empty($_POST['content'])) {
                $_SESSION['content'] = strip_tags(trim($_POST['content']));
            }
            if(!empty($_POST['vote'])) {
                $_SESSION['vote'] = intval(trim($_POST['vote']));
            }

            if(empty($_POST['content']) || empty($_POST['category'])) {
                $this->flash('Informations manquantes.<br>Vous devez ajouter un <strong>contenu</strong> et sélectionner une <strong>catégorie</strong>.', 'danger');
                $this->redirect('/update/entity/' . $id);
            }
            
            $content = strip_tags(trim($_POST['content']));
            $vote = trim($_POST['vote']) !== '' ? intval(trim($_POST['vote'])) : null;
            $categoryId = intval($_POST['category']);

            if(strlen($content) < 10 || strlen($content) > 5000) {                
                $this->flash('Le contenu doit être supérieur à <strong>10</strong> caractères.<br>Le contenu ne doit pas excéder <strong>5000</strong> caractères.', 'danger');
                $this->redirect('/update/entity/' . $id);
            }

            if(!is_null($vote) && ($vote < 0 || $vote > 99999)) {
                $this->flash('Le vote doit être supérieur à <strong>0</strong> caractères.<br>Le vote ne doit pas excéder <strong>99999</strong> caractères.', 'danger');
                $this->redirect('/update/entity/' . $id);
            } elseif(is_null($vote)) {
                $vote = mt_rand(1000, 99999);
            }

            unset($_SESSION['content']);
            
            $entityInstance = new EntityModel();
            $entityToUpdate = $entityInstance->getById(intval($id));
            $entityToUpdate->setContent($content);
            $entityToUpdate->setVote($vote);
            $entityToUpdate->setCategoryId($categoryId);
            $entityToUpdate->update();

            $this->flash('La Entity #' . $entityToUpdate->getId() . ' a correctement été modifiée en base.', 1);
            $this->redirect('/dashboard');
        }

        $entityInstance = new EntityModel();
        $entityToUpdate = $entityInstance->getById(intval($id));

        $categoryInstance = new CategoryModel();
        $categories = $categoryInstance->getAll();

        $this->assign('pageTitle', 'Création d\'une nouvelle entrée');
        $this->assign('entity', $entityToUpdate);
        $this->assign('categories', $categories);
        $this->showView('entityUpdate');
    }

    /**
     * Permet de créer une nouvelle entrée
     * 
     */
    public function entityDelete($id) {
        // Vérifie que l'utilisateur soit connecté et administrateur
        SecurityController::isAdmin();
        // Vérification du token de session
        SecurityController::checkToken();

        $entityToDelete = new EntityModel();
        $entityToDelete->delete($id);

        $this->flash('Entity #' . $id . ' supprimée avec succès', 1);
        $this->redirect('/dashboard');
    }

    /**
     * Permet de créer une nouvelle entrée
     * 
     */
    public function purge() {
        // Vérifie que l'utilisateur soit connecté et administrateur
        SecurityController::isAdmin();
        // Vérification du token de session
        SecurityController::checkToken();

        // TODO

        $this->flash('Purge terminée', 1);
        $this->redirect('/dashboard');
    }
}