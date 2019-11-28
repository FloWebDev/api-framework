<!DOCTYPE html>
<html lang="fr">
<head>
    <title><?= !empty($pageTitle) ? $pageTitle : 'Humour API'; ?></title>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= !empty($pageDescription) ? $pageDescription : 'Bienvenue sur Humour API'; ?>"> 
    <meta name="keywords" content="<?= !empty($pageKeywords) ? $pageKeywords : 'humour, blague, devinette, chuck norris fact, api, entity api, blague, fr, français, blague française'; ?>">
    <meta name="author" content="">    
    <link rel="shortcut icon" href="favicon.ico">  
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>

    <!--<script defer src="https://use.fontawesome.com/releases/v5.8.2/js/all.js" integrity="sha384-DJ25uNYET2XCl5ZF++U8eNxPWqcKohUUBUpKGlNLMchM7q4Wjg2CUpjHLaL8yYPH" crossorigin="anonymous"></script>-->
    <!-- Global CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap/bootstrap.min.css">   
    <!-- Plugins CSS -->    
    <link rel="stylesheet" href="assets/css/prism/prism.css">
    <link rel="stylesheet" href="assets/css/elegant_font/style.css">  
      
    <!-- Theme CSS -->
    <link id="theme-style" rel="stylesheet" href="assets/css/styles.css">
    <link id="theme-style" rel="stylesheet" href="assets/css/style.css">
    
</head> 

<body class="body-green">
    <div class="page-wrapper">
        <!-- ******Header****** -->
        <header id="header" class="header">
            <div class="container">
                <div class="branding">
                    <h1 class="logo">
                        <a href="/">
                            <span aria-hidden="true" class="icon_documents_alt icon"></span>
                            <span class="text-highlight">Light</span><span class="text-bold">API</span>
                        </a>
                    </h1>
                    
                </div><!--//branding-->
                
                <!-- Navbar -->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item <?php if(empty($_GET['_url'])) : ?>active<?php endif; ?>"><a href="/"><i class="fas fa-home"></i> Accueil</a></li>
                    
                    <?php if(!$user) : ?>
                    <li class="breadcrumb-item <?php if($_GET['_url'] == '/token') : ?>active<?php endif; ?>"><a href="/token"><i class="fas fa-key"></i> Token</a></li>
                    <?php endif; ?>

                    <?php if($user) : ?>
                    <li class="breadcrumb-item <?php if($_GET['_url'] == '/dashboard') : ?>active<?php endif; ?>"><a href="/dashboard"><i class="fas fa-smile-wink"></i> Dashboard</a></li>
                    <?php endif; ?>

                    <?php if($user && $user->getRole()->getCode() == 'ROLE_ADMIN') : ?>
                    <li class="breadcrumb-item <?php if($_GET['_url'] == '/users') : ?>active<?php endif; ?>"><a href="/users"><i class="fas fa-users"></i> Utilisateurs</a></li>
                    <?php endif; ?>
                    
                    <?php if(!$user) : ?>
                    <li class="breadcrumb-item <?php if($_GET['_url'] == '/login') : ?>active<?php endif; ?>"><a href="/login"><i class="fas fa-sign-in-alt"></i> Connexion</a></li>
                    <?php else : ?>
                    <li class="breadcrumb-item <?php if($_GET['_url'] == '/logout') : ?>active<?php endif; ?>"><a href="/logout"><i class="fas fa-sign-out-alt"></i> Déconnexion</a></li>
                    <?php endif; ?>
                </ol>
                
                <!-- Formulaire de recherche 
                uniquement si connecté
                A développer -->
                <?php if($user) : ?>
                <div class="top-search-box">
	                 <form class="form-inline search-form justify-content-center" action="" method="get">
	            
			            <input type="text" placeholder="Search..." name="search" class="form-control search-input">
			            
			            <button type="submit" class="btn search-btn" value="Search"><i class="fas fa-search"></i></button>
			            
			        </form>
                </div>
                <?php endif; ?>
                
            </div><!--//container-->
        </header><!--//header-->


    <!-- Gestion de l'affichage des messages flash -->
    <?php if(!empty($_SESSION['flash'])) : ?>
        <div class="col-12 col-md-10 mx-auto my-2 p-2 alert alert-<?= $_SESSION['flash']['type']; ?>" role="alert">
            <?= $_SESSION['flash']['message']; ?>
        </div>
        <!-- Suppression du message flash -->
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>

    <div class="doc-wrapper">
            <div class="container">
                <div id="doc-header" class="doc-header text-center">
                    <h2 class="doc-title"><i class="icon fa fa-paper-plane"></i> 
                        <!-- Gestion dynamique du titre H2 -->
                        <?php if(!empty($h2Title)) : ?>
                            <?= $h2Title; ?>
                            <?php else : ?>
                            <?= CFG_H2_TITLE; ?>
                        <?php endif; ?>
                    </h2>

                    <div class="meta"><i class="far fa-clock"></i> Dernière mise à jour : le <?php
                        $date = date('d/m/Y', strtotime('-1 days'));
                        echo $date;
                    ?></div>
                </div><!--//doc-header-->
                <div class="doc-body row">