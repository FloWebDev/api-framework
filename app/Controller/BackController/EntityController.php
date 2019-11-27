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

        $entityInstance = new EntityModel();
        $entities = $entityInstance->getAll('DESC', $limit, $offset);

        // Récupération de toutes les catégories
        $categoryInstance = new CategoryModel();
        $categoryList = $categoryInstance->getAll();
        
        $categories = array();
        foreach($categoryList as $category) {
            $categories[$category->getId()] = $category->getName();
        }

        $this->assign('entities', $entities);
        $this->assign('categories', $categories);
        $this->assign('pages', $pagination);
        $this->assign('h1Title', 'Tableau de bord');
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
                $this->flash('Le contenu ne doit pas exécéder <strong>5000</strong> caractères.<br>Le contenu doit être supérieur à <strong>10</strong> caractères', 'danger');
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

            // Pour éviter de ressaisir la entity en cas d'erreur
            if(!empty($_POST['content'])) {
                $_SESSION['content'] = strip_tags(trim($_POST['content']));
            }

            if(empty($_POST['content']) || empty($_POST['category'])) {
                $this->flash('Informations manquantes.<br>Vous devez ajouter un <strong>contenu</strong> et sélectionner une <strong>catégorie</strong>.', 'danger');
                $this->redirect('/update/entity/' . $id);
            }
            
            $content = strip_tags(trim($_POST['content']));
            $categoryId = intval($_POST['category']);

            if(strlen($content) < 10 || strlen($content) > 5000) {                
                $this->flash('Le contenu ne doit pas exécéder <strong>5000</strong> caractères.<br>Le contenu doit être supérieur à <strong>10</strong> caractères', 'danger');
                $this->redirect('/update/entity/' . $id);
            }

            unset($_SESSION['content']);
            
            $entityInstance = new EntityModel();
            $entityToUpdate = $entityInstance->getById(intval($id));
            $entityToUpdate->setContent($content);
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

        $entityToDelete = new EntityModel();
        $entityToDelete->delete($id);

        $this->flash('Entity #' . $id . ' supprimée avec succès', 1);
        $this->redirect('/dashboard');
    }
}