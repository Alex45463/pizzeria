<?php
session_start();
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/util/database.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader(__DIR__ . '/templates');
$twig = new Environment($loader);

function returnError($error) {
    echo $twig->render('signin.html.twig', [
        'error' => $error
    ]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(!isset($_POST['email']) || !isset($_POST['password'])) {
        returnError('Credentials missing');
    }

    $pdo = require __DIR__ . "/util/connect.php";

    $sql = "SELECT * FROM `Users` WHERE email = :email;";
	$stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $_POST['email'], PDO::PARAM_STR);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

	if (!$result) {
        returnError('User not found');
    }

	if(!password_verify($_POST['password'], $result->password_hash)) {
        returnError('Invalid credentials');
	}

    $_SESSION['logged'] = true;
    $_SESSION['user_id'] = $result->id;

    $pdo = null;
    header('Location: ../index.php');
    exit;
}

echo $twig->render('signin.html.twig');
?>
