<?php
/**
 * Rotas da aplicação
 * 
 * Essa rota irá definir para qual controller e action 
 * o usuário será direcionado. 
 * toda rota deverá ser um array e deve conter os seguintes índices:
 * 
 * <b>route</b>      o nome da rota, que será o valor digitado na url.
 * <b>controller</b> controller que a rota irá buscar, se não for definido irá 
 *                   mandar para o controller Index.
 * <b>action</b>     action que a rota irá buscar, se não for definido irá 
 *                   mandar para a action Index.
 * <b>params</b>     paramêtros passados, esse indíce deve receber um array como 
 *                   valor, sendo a key o nome do paramêtro e o value o seu valor. 
 *
 * @return Array contendo as rotas definidas
 */
return array(
    array('route' => 'home', 'controller' => 'index', 'action' => 'index')
);