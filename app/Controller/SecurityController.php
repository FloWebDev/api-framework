<?php

namespace App\Controller;

use App\Model\RoleModel;
use App\Model\UserModel;

class SecurityController extends CoreController {

    /**
     * Permet d'afficher et gérer le formulaire de connexion
     * 
     */
    public function signIn() {
        // Permet de vérifier que l'utilisateur n'est pas connecté.
        self::isNotConnected();

        if(!empty($_POST)) {

            // Pour éviter de resaisir le login en cas d'erreur
            if(!empty($_POST['username'])) {
                $_SESSION['username'] = strip_tags(trim($_POST['username']));
            }
            
            if(empty($_POST['username']) || empty($_POST['password'])) {
                $this->flash('Informations manquantes.<br>Merci de renseigner votre <strong>identifiant</strong> et <strong>mot de passe</strong>.', 'danger');
                $this->redirect('/login');
            }

            $username = strip_tags(trim($_POST['username']));
            $password = strip_tags(trim($_POST['password']));

            $userInstance = new UserModel();
            $user = $userInstance->getByUsername($username);

            // Si utilisateur inconnu
            if(!$user) {
                $this->flash('Identifiant et/ou mot de passe incorrect(s).', 'danger');
                $this->redirect('/login');
            }

            // Si utilisateur bloqué
            if(!$user->getIsActive()) {
                $this->flash('Compte bloqué. Contactez si besoin l\'administrateur du site.', 'danger');
                $this->redirect('/login');
            }

            // Si mot de passe incorrect
            if(!password_verify($password, $user->getPassword())) {
                $this->flash('Identifiant et/ou mot de passe incorrect(s).', 'danger');
                $this->redirect('/login');
            }

            unset($_SESSION['username']);

            // Enregistrement de la date et heure de dernière connexion
            $currentDate = date('Y-m-d H:i:s');
            $user->setConnectedAt($currentDate);
            $user->updateConnectedAt();

            $this->createSessionUser($user);
            // $this->flash('Connexion effectuée avec succès.', 1);
            $this->redirect('/dashboard');

        }

        $this->assign('pageTitle', 'Connexion au panneau d\'administation');
        $this->assign('pageDescription', 'Connexion au panneau d\'administation');
        $this->assign('h2Title', 'Connexion au panneau d\'administation');
        $this->showView('signIn');
    }

        /**
     * Permet d'afficher et gérer le formulaire de connexion
     * 
     */
    public function signUp() {
        // Permet de vérifier que l'utilisateur n'est pas connecté.
        // self::isAdmin();

        if(!empty($_POST)) {

            // Pour éviter de resaisir le l'identifiant en cas d'erreur
            if(!empty($_POST['username'])) {
                $_SESSION['username'] = strip_tags(trim($_POST['username']));
            }
            
            if(empty(trim($_POST['username'])) || empty(trim($_POST['password'])) || empty(trim($_POST['confirmPassword']))) {
                $this->flash('Informations manquantes.<br>Merci de renseigner un <strong>identifiant</strong> et un <strong>mot de passe</strong>.', 'danger');
                $this->redirect('/inscription');
            }

            $username = strip_tags(trim($_POST['username']));
            $password = strip_tags(trim($_POST['password']));
            $confirmPassword = strip_tags(trim($_POST['confirmPassword']));

            $newUser = new UserModel();
            $userToCheck = $newUser->getByUsername($username);

            if($userToCheck) {
                $this->flash('Cet utilisateur existe déjà. Merci de modifier l\'identifiant.', 'danger');
                $this->redirect('/inscription');
            }

            if($password !== $confirmPassword) {
                $this->flash('Attention ! Les deux mots de passe saisis sont différents.', 'danger');
                $this->redirect('/inscription');
            }

            $encryptPassword = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
            // dd($encryptPassword);

            if(!empty($_POST['role'])) {
                $role = intval($_POST['role']);
            } else {
                $instanceRole = new RoleModel();
                $redacRole = $instanceRole->getByCode('ROLE_REDAC');

                $role = intval($redacRole->getId());
            }

            $newUser->setUsername($username);
            $newUser->setPassword($encryptPassword);
            $newUser->setRoleId($role);
            $newUser->new();
            
            // dd($newUser);

            unset($_SESSION['username']);
            $this->flash('Inscription enregistrée avec succès.', 1);
            $this->redirect('/users');

        }

        $instanceRole = new RoleModel();
        $roles = $instanceRole->getAll();

        $this->assign('h1Title', 'Gestion des utilisateurs');
        $this->assign('pageTitle', 'Formulaire d\'inscription');
        $this->assign('pageDescription', 'Formulaire d\'inscription');
        $this->assign('roles', $roles);
        $this->showView('signUp');
    }

    /**
     * Permet d'enregistrer l'utilisateur en session
     * 
     * @param obj $user
     */
    private function createSessionUser($user) {
        if(!empty($user)) {
            $_SESSION['user'] = $user;
        }
    }

    /**
     * Permet de déconnecter l'utilisateur
     * et vider la session utilisateur
     * 
     */
    public function logout() {
        // Permet de vérifier que l'utilisateur est connecté.
        self::isConnected();

        unset($_SESSION['user']);
        // $this->flash('Déconnexion effectuée avec succès.', 'danger');
        $this->redirect('/');
    }

    /**
     * Permet de vérier si un utilisateur est connecté
     * 
     */
    public static function isConnected() {
        if(empty($_SESSION['user'])) {
            self::flash('Vous devez être connecté pour accéder à cette page', 'danger');
            self::redirect('/');
        }

        return true;
    }

    /**
     * Permet de vérier qu'un utilisateur n'est pas connecté
     * 
     */
    public static function isNotConnected() {
        if(!empty($_SESSION['user'])) {
            self::redirect('/dashboard');
        }

        return true;
    }

    /**
     * Permet de vérier si un utilisateur est connecté en tant qu'administrateur
     * 
     */
    public static function isAdmin() {
        // Vérifie dans un premier temps que l'utilisateur soit connecté
        self::isConnected();

        if(!empty($_SESSION['user']) && $_SESSION['user']->getRole()->getName() === 'ROLE_ADMIN') {
            self::flash('Vous devez être administrateur pour accéder à cette page', 'danger');
            self::redirect('/dashboard');
        }

        return true;
    }

    /**
     * Permet de vérier si un utilisateur est connecté en tant que modérateur ou administrateur
     * 
     */
    public static function isModo() {
        // Vérifie dans un premier temps que l'utilisateur soit connecté
        self::isConnected();

        if(!empty($_SESSION['user']) && in_array($_SESSION['user']->getRole()->getCode(), ['ROLE_ADMIN', 'ROLE_MODO'])) {
            self::flash('Vous devez être modérateur ou administrateur pour accéder à cette page', 'danger');
            self::redirect('/dashboard');
        }

        return true;
    }
}