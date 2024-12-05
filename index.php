
<?php
//include "./config/Database.php";
///$db = new Database();
//$valida = $db -> connect();

//if ($valida) {
  ///  echo "conexion establecida correctamente";
//}else{
      //  echo "conexion establecida";

    //}


//Manjo de errroes
 error_reporting (E_ALL);
 ini_set('display_errors', 1);

 // cargar achivo de configracion 
 require_once 'config/config.php';

 // autolad de la clase

 spl_autoload_register(function ($class_name) {
    $directories = [
        'controllers/',
        'models/',
        'config/',
        'utils/',
        ''
    ];
    
    foreach ($directories as $directory) {
        $file = $directory . $class_name . '.php';
        if (file_exists($file)) {
            // var_dump($file);
            require_once $file;
            return;
        }
    }
});


// crear una instancia de router
$router = new Router();

$public_routes = [
    '/web', 
    '/login',
    '/register',


];

//obtener la ruta actual
$current_route = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$current_route = str_replace (dirname($_SERVER['SCRIPT_NAME']),'', $current_route);

//echo $current_router;
//var_dump(dirname($_SERVER['SCRIPT_NAME']
//var_dump($current_router);
//

$router -> add ('GET','/web','WebCotroller', 'index');
//login and registros
$router -> add ('GET','/login','AuthController', 'sowLogin');
$router -> add ('GET','/register','AuthController', 'sowRegister');


$router -> add ('POST','auth/login','AuthController', 'login');
$router -> add ('POST','auth/register','AuthController', 're');



//despachar la ruta

try {
    $router->dispatch($current_route, $_SERVER['REQUEST_METHOD']);
} catch (Exception $e) {
    // Manejar el error
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        include 'views/errors/404.php';
    } else {
        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
    }
}