<?php
/**
 * Application routes 
 * The route will define to which controller and action the user is redirected. 
 * The route should be an associative array, the key being the value 
 * of each route.
 * 
 * Each index should receive an array containing as the first value the 
 * controller as a second value to action, and as the third one 
 * parameter value array.
 * 
 * For example:
 * 
 * return array(
 *     'name-of-route' => array(
 *         'controller', 
 *         'action', 
 *         array('param1' => 'value1', 'param2' => 'value2')
 *     ),
 * )
 * 
 * You can also use wildcards in your routes
 * 
 * (any) = anything
 * (str) = only letters
 * (num) = only numbers
 * 
 * And to pass these values as parameters on the routes, just use $ 1 for 
 * the first value, $ 2 for the second and so on.
 * 
 * For example:
 * 
 * return array(
 *     'article/category/(str)/page/(num)' => array(
 *         'controller', 
 *         'action', 
 *         array('category' => '$1', 'page' => '$2')
 *     ),
 * )
 *
 * @return Array containing the defined routes
 */
return [
    'home' => ['index', 'index']
];