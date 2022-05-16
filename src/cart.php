<?php
session_start();

print_r($_SESSION);

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/util/database.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader(__DIR__ . '/templates');
$twig = new Environment($loader);

// $pizze = getPizze();
if(!empty($_SESSION['cart'])){

    $AllProducts = array(
		array('price' => '12.30', 'name' => 'Pizza Margherita 1'),
        array('price' => '12.30', 'name' => 'Pizza Margherita 2'),
        array('price' => '12.30', 'name' => 'Pizza Margherita 3')
    );

    $carrello = array();
    foreach ($_SESSION['cart'] as $key => $product) {
        $carrello[$key] = array_merge(
            $AllProducts[$key],
            $product
        );
    }
} else {
    $carrello = array();
}

print_r($carrello);

if($_SESSION['logged']){
    echo $twig->render('list.html.twig', [
        'type' => 'cart',
        'list_products' => $carrello,
        "logged" => $_SESSION['logged'] ?? false,
        'error' => $_SESSION['error']

    ]);
}
else{
    header('Location: /');
    exit;
}
?>