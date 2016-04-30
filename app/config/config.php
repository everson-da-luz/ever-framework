<?php
/**
 * Ever Framework
 * 
 * Configurações gerais da aplicação
 */

/** 
 * Defini se os erros serão exibidos ou não.
 * 1 = Exibi erros
 * 0 = Não exibi erros
 */
define('DISPLAY_ERROR', 1);

/** 
 * Diretório raiz da aplicação.
 * Essa constante irá obter o nome do diretório raiz,
 * com isso será usado para identificar se a aplicação esta rodando em um ambiente local,
 * também pode ser usuado para setar algum caminho começando pela raiz.
 */
define('BASE_DIR', basename(dirname(APP_PATH)));

// Nome da pasta dos controllers
define('CONTROLLER_FOLDER', 'controllers');

// Nome do controller para minipulação de erros
define('ERROR_CONTROLLER', 'Error');

// Separador de diretórios
define('DS', DIRECTORY_SEPARATOR);