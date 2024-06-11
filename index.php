<?php

session_start();

require 'vendor/autoload.php';

Dotenv\Dotenv::createImmutable(__DIR__)->load();

require_once __DIR__ . '/routes/index.php';

require_once __DIR__ . '/vendor/PHPMailer/PHPMailer/src/Exception.php';
require_once __DIR__ . '/vendor/PHPMailer/PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/vendor/PHPMailer/PHPMailer/src/SMTP.php';

require_once __DIR__ . '/routes/admin.php';
