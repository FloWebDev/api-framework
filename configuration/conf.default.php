<?php

// BDD - PDO Singleton
define('CFG_PDOS_SGBD', 'sqlite');
define('CFG_PDOS_HOST_DBNAME', __DIR__ . '/../app/DBData/database/data.db');
define('CFG_PDOS_USERNAME', null);
define('CFG_PDOS_PASSWORD', null);

// JWT
define('CFG_JWT_SECRET', '£Abc123!-?');

// Configuration du site
define('CFG_BASE_PATH', '');
define('CFG_SESSION_LIFETIME', 0);
define('CFG_H1_TITLE', 'Light API');
define('CFG_H2_TITLE', 'Quick Start');

// PHPMailer
define('CFG_EMAIL_DEBUG', 0);
define('CFG_EMAIL_HOST', 'smtp.example.com');
define('CFG_EMAIL_USERNAME', 'contact@example.com');
define('CFG_EMAIL_PASSWORD', 'your_password');
define('CFG_EMAIL_ENCRYPTION', 'tls');
define('CFG_EMAIL_PORT', 587);
