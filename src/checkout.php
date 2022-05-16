<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/util/database.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader(__DIR__ . '/templates');
$twig = new Environment($loader);

// $pizze = getPizze();

$pizza = array(
    array('price'=>"12.30", 'name'=>"Pizza Margherita", 'quantity'=>2),
    array('price'=>"12.30", 'name'=>"Pizza Margherita 2", 'quantity'=>3),
    array('price'=>"12.30", 'name'=>"Pizza Margherita 3", 'quantity'=>1)
);

echo $twig->render('checkout.html.twig', [
    "cart" => $pizza,
    'total' => '123',
    'error' => $_SESSION['error'] ?? null
]);

unset($_SESSION['error']);
?>
