<?php

require_once 'src/controllers/SecurityController.php';
require_once 'src/controllers/MonsterController.php';
require_once 'src/controllers/AdminController.php';

class Routing {
    public static $routes = [
        'login' => [
            'controller' => 'SecurityController',
            'action' => 'login'
        ],
        'register' => [
            'controller' => 'SecurityController',
            'action' => 'register'
        ],
        'logout' => [
            'controller' => 'SecurityController',
            'action' => 'logout'
        ],
        'monsters' => [
            'controller' => 'MonsterController',
            'action' => 'monsters'
        ],
        'monsters/(\d+)' => [
            'controller' => 'MonsterController',
            'action' => 'monster'
        ],
        'admin/users' => [
            'controller' => 'AdminController',
            'action' => 'users'
        ],
        'admin/monsters' => [
            'controller' => 'AdminController',
            'action' => 'adminMonsters'
        ],
        'admin/add-monster' => [
            'controller' => 'AdminController',
            'action' => 'addMonster'
        ],
        'admin/add-monster/(\d+)' => [
            'controller' => 'AdminController',
            'action' => 'addMonster'
        ],
        'admin/delete-user/(\d+)' => [
            'controller' => 'AdminController',
            'action' => 'deleteUser'
        ],
        '' => [
            'controller' => 'SecurityController',
            'action' => 'login'
        ]
    ];

    private static $instances = [];

    public static function run(string $path) {
        $method = $_SERVER['REQUEST_METHOD'];

        foreach (self::$routes as $pattern => $config) {
            $regex = "#^" . $pattern . "$#";

            if (preg_match($regex, $path, $matches)) {
                $controllerName = $config['controller'];
                $action = $config['action'];

                if (!isset(self::$instances[$controllerName])) {
                    self::$instances[$controllerName] = new $controllerName;
                }
                
                $controllerObj = self::$instances[$controllerName];
                $id = $matches[1] ?? null;

                $controllerObj->$action($id, $method);
                return;
            }
        }
    }
}