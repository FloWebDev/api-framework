<?php

// BDD - PDO Singleton
define('CFG_PDOS_SGBD', 'sqlite');
define('CFG_PDOS_HOST_DBNAME', __DIR__ . '/../app/DBData/database/data.db');
define('CFG_PDOS_USERNAME', null);
define('CFG_PDOS_PASSWORD', null);

// JWT
define('CFG_JWT_SECRET', 'ABCd123!');

// Configuration du site
define('CFG_SESSION_LIFETIME', 0);
define('CFG_H1_TITLE', 'Gros Titre API');
define('CFG_H2_TITLE', 'Titre API');

// PHPMailer
define('CFG_EMAIL_DEBUG', 0);
define('CFG_EMAIL_HOST', null);
define('CFG_EMAIL_USERNAME', null);
define('CFG_EMAIL_PASSWORD', null);
define('CFG_EMAIL_ENCRYPTION', 'tls');
define('CFG_EMAIL_PORT', 587);