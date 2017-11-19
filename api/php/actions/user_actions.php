<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
header('Access-Control-Allow-Credentials: true');
error_reporting(E_ALL); 
ini_set('display_errors', 'On');

try {

    // $_REQUEST = json_decode(file_get_contents('php://input'), true);

    $task = $_REQUEST['task'];

    // specify the full path to the project file
    $ROOT_DIR = "/var/www/html/api/";

    include $ROOT_DIR . '/php/objects/user.php';
    include $ROOT_DIR . '/php/recaptcha_verify.php';

    foreach (
    array(
        $ROOT_DIR . '/php/objects/dbConnection.php',
        $ROOT_DIR . '/php/objects/publicVariables.php',
    ) as $include_file) {
        if (!@include_once($include_file )) {
            throw new Exception($include_file . ' does not exist');
        }
    }

    $dbConnectionStatus = new DbConnectionClass();
    $dbConnectionWip = new DbConnectionClass();

    $user = new userClass();
    $user->api = $dbConnectionStatus->getDb('api');
    $user->root_path = $ROOT_DIR;

    if ($task == "login") {
        $emailId = $_REQUEST['emailId'];
        $password = $_REQUEST['password'];

        $response = $user->login($emailId, $password);
        echo $response;
        return;
    } elseif ($task == "register new user") {
        $response = $user->register($_REQUEST);
        echo $response;
        return;
    } elseif ($task == "get bills") {
        $user = array('authToken' => $_REQUEST['authToken'], 'userId'=>,$_REQUEST['userID']);
        $response = $user->get_bills($_REQUEST['billno'],$user);
        echo $response;
        return;
    } elseif ($task == "logout") {
        $response = $user->logout();
        echo $response;
        return;
    } else {
        echo '[{"status":"error", "message" : "Invalid Task Code."}]';
    }
} catch (PDOException $e) {
    echo '[{"status":"error","message":"' . $e->getMessage() . '"}]';
}
