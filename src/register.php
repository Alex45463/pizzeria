<?php
session_start();
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/util/database.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader(__DIR__ . '/templates');
$twig = new Environment($loader);

function returnError($error) {
    echo $twig->render('signup.html.twig', [
        'error' => $error
    ]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(!isset($_POST['email']) || !isset($_POST['password']) || !isset($_POST['repeat-password'])) {
        returnError('Credentials missing');
    }
    if($_POST['password'] != $_POST['repeat-password']) {
        returnError('Passwords are missmatching');
    }

    $email = $_POST['email'];

    $pdo = require __DIR__ . "/util/connect.php"; 
    $sql = "SELECT * FROM `Users` WHERE email = :email;";
	$stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

	if ($result) {
        returnError('Email already used');
    }

    $password_hash = password_hash($_POST['password'], PASSWORD_BCRYPT, ['cost' => 10]);

    $sql = "INSERT INTO `Users`(email, password_hash) VALUES(:email, :password_hash);";
	$stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':email' => $email,
        ':password_hash' => $password_hash,
    ]);

    $_SESSION['logged'] = true;
    $_SESSION['user_id'] = $pdo->lastInsertId();;

    $pdo = null;
    header('Location: ../index.php');
    exit;
}
echo $twig->render('signup.html.twig');
?>
