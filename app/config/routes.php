<?php
/**
 * Application routes
 * 
 * This route will define to which controller and action the user will be 
 * directed. Every route should be an array and must 
 * contain the following indexes:
 * 
 * <b>route</b> the name of the route, which will be the value typed in the url.
 * <b>controller</b> controller that the route will seek, if not set will 
 * arrange for the Index controller.
 * <b>action</b> action that the route will seek, if not set will arrange for 
 * the Index action.
 * <b>params</b> parameters passed, the indices should receive an array as 
 * value, with the key the parameter name and value their worth.
 *
 * @return Array containing the defined routes
 */
return array(
    array('route' => 'home', 'controller' => 'index', 'action' => 'index')
);