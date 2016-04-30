<?php
// Define o caminho do diretório app
defined('APP_PATH')
    || define('APP_PATH', realpath(dirname(__FILE__) . '/../app'));

// Nome da pasta public
define('PUBLIC_FOLDER', basename(__DIR__));

// Inclui as configurações gerais
require_once APP_PATH . '/config/config.php';

// Inclui e registra as classes no autoload
require_once APP_PATH . '/../vendor/Ever/Autoload/Autoload.php';
\Ever\Autoload\Autoload::autoloadRegister();

// Instância da classe de inicialização
$init = new App\Init;
// Roda a aplicação
$init->run();