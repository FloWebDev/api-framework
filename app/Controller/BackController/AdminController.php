<?php

namespace App\Controller\BackController;

use App\Model\RoleModel;
use App\Model\UserModel;
use App\Controller\CoreController;
use App\Controller\SecurityController;

class AdminController extends CoreController {
    
    /**
     * Permet d'afficher la liste complète des entités
     * 
     */
    public function userList() {
        // Vérifie que l'utilisateur soit connecté ET administrateur
        SecurityController::isAdmin();

        $userInstance = new UserModel();
        $users = $userInstance->getAllByUsername();

        $roleInstance = new RoleModel();
        $roles = $roleInstance->getAll();

        $roleArray = array();

        foreach($roles as $role) {
            $roleArray[$role->getId()] = $role->getName();
        }
        
        $this->assign('h1Title', 'Gestion des utilisateurs');
        $this->assign('pageTitle', 'Gestion des utilisateurs');
        $this->assign('users', $users);
        $this->assign('roles', $roleArray);
        $this->showView('users');
    }

    /**
     * Permet de supprimer un utilisateur
     * 
     */
    public function userDelete($id) {
        // Vérifie que l'utilisateur soit connecté ET administrateur
        SecurityController::isAdmin();
        // Vérification du token de session
        SecurityController::checkToken();

        $userInstance = new UserModel();
        $user = $userInstance->getById($id);
        if($user->getRole()->getCode() === 'ROLE_ADMIN') {
            $this->flash('Vous ne pouvez pas supprimer un profil Administrateur', 'danger');
            $this->redirect('/users');
        }
        $userInstance->delete($id);

        $this->flash('Utilisateur n° ' . $id . ' supprimé avec succès.', 1);
        $this->redirect('/users');
    }

    /**
     * Permet de mettre à jour un utilisateur
     * 
     */
    public function userUpdate() {
        // Vérifie que l'utilisateur soit connecté ET administrateur
        SecurityController::isAdmin();
        // Vérification du token de session
        SecurityController::checkToken();

        // Vérifications de l'exhaustivité des informations transmises
        if(empty($_POST['user']) || empty($_POST['username']) || empty($_POST['role'])) {
            $this->flash('Informations manquantes.', 'danger');
            $this->redirect('/users');
        }

        // Récupération des données du formulaire
        $user_id = intval($_POST['user']);
        $username = strip_tags(trim($_POST['username']));
        $role_id = intval($_POST['role']);
        $actif = !empty($_POST['actif']) && $_POST['actif'] == '1' ? true : false;

        $userInstance = new UserModel();
        $user = $userInstance->getById($user_id);

        // Si user inexistant, on ne peut pas traiter de modification
        if(!$user) {
            $this->flash('Utilisateur inconnu.', 'danger');
            $this->redirect('/users');
        }

        // On update les différentes valeurs
        $user->setUsername($username);
        $user->setRoleId($role_id);
        $user->setIsActive($actif);

        // Traitement particulier du champ mot de passe
        if(empty(trim($_POST['password']))) {
            $user->setPassword($user->getPassword());
        } else {
            $password = strip_tags(trim($_POST['password']));
            $encryptPassword = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
            $user->setPassword($encryptPassword);
        }

        $user->update();

        $this->flash('Utilisateur <strong>"' . $user->getUsername() . '"</strong> modifié avec succès', 1);
        $this->redirect('/users');
    }
}