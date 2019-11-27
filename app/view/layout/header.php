<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="/asset/css/bootstrap.min.css">
    <link rel="stylesheet" href="/asset/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="/asset/css/style.css">
    <meta name="description" content="<?= !empty($pageDescription) ? $pageDescription : 'Bienvenue sur Humour API'; ?>"> 
    <meta name="keywords" content="<?= !empty($pageKeywords) ? $pageKeywords : 'humour, blague, devinette, chuck norris fact, api, entity api, blague, fr, français, blague française'; ?>">
    
    <title><?= !empty($pageTitle) ? $pageTitle : 'Humour API'; ?></title>

</head>
<body>
<div class="container-fluid">

    <div class="row col-12 mx-0">

    <!-- Titre H1 -->
    <h1 class="col-12 mx-auto mt-5 mb-3 p-0 text-center">
        <a href="/">
            <?php if(!empty($h1Title)) : ?>
            <?= $h1Title; ?>
            <?php else : ?>
            <?= CFG_H1_TITLE; ?>
            <?php endif; ?>
        </a>
    </h1>

    <!-- Gestion de la navbar -->
    <div class="col-12 mx-auto p-0">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark mb-3">
        <span class="navbar-brand">Menu</span>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse d-md-flex justify-content-center" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <li class="nav-item <?php if(empty($_GET['_url'])) : ?>active<?php endif; ?>">
                    <a class="nav-link" href="/"><i class="fas fa-home"></i> Accueil</a>
                </li>
                <?php if(!$user) : ?>
                <li class="nav-item <?php if($_GET['_url'] == '/token') : ?>active<?php endif; ?>">
                    <a class="nav-link" href="/token"><i class="fas fa-key"></i> Token</a>
                </li>
                <?php endif; ?>
                <?php if($user) : ?>
                <li class="nav-item <?php if($_GET['_url'] == '/dashboard') : ?>active<?php endif; ?>">
                    <a class="nav-link" href="/dashboard"><i class="fas fa-smile-wink"></i> Dashboard</a>
                </li>
                <?php endif; ?>
                <?php if($user && $user->getRole()->getCode() == 'ROLE_ADMIN') : ?>
                <li class="nav-item <?php if($_GET['_url'] == '/users') : ?>active<?php endif; ?>">
                    <a class="nav-link" href="/users"><i class="fas fa-users"></i> Utilisateurs</a>
                </li>
                <?php endif; ?>
                <?php if(!$user) : ?>
                <li class="nav-item <?php if($_GET['_url'] == '/login') : ?>active<?php endif; ?>">
                    <a class="nav-link" href="/login"><i class="fas fa-sign-in-alt"></i> Connexion</a>
                </li>
                <?php else : ?>
                <li class="nav-item <?php if($_GET['_url'] == '/logout') : ?>active<?php endif; ?>">
                    <a class="nav-link" href="/logout"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
        </nav>
    </div>

    <!-- Gestion de l'affichage des messages flash -->
    <?php if(!empty($_SESSION['flash'])) : ?>
        <div class="col-12 col-md-10 mx-auto my-2 p-2 alert alert-<?= $_SESSION['flash']['type']; ?>" role="alert">
            <?= $_SESSION['flash']['message']; ?>
        </div>
        <!-- Suppression du message flash -->
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>


