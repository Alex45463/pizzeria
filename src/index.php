<?php
session_start();
// unset( $_SESSION['cart']);
if(!isset($_SESSION['cart'])){
    $_SESSION['cart'] = array();
}
print_r($_SESSION);

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/util/database.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader(__DIR__ . '/templates');
$twig = new Environment($loader);

// $pizze = getPizze();
$pizza = array(
            array('price'=>"12.30", 'name'=>"Pizza Margherita"),
            array('price'=>"12.30", 'name'=>"Pizza Margherita 2"),
            array('price'=>"12.30", 'name'=>"Pizza Margherita 3")
);

echo $twig->render('list.html.twig', [
    'list_products' => $pizza,
    'logged' => $_SESSION['logged'] ?? false
]);
?>