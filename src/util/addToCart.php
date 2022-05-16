<?php
require __DIR__ . '/database.php';

session_start();
print_r($_POST);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST['product'])){
        $product = $_POST['product'];
        if(isset($_SESSION['cart'][$product]['quantity'])){
            $_SESSION['cart'][$product]['quantity']++;
        } else {
            $_SESSION['cart'][$product]['quantity'] = 1;
            $_SESSION['cart'][$product]['price'] = "12.30";
            // $_SESSION['cart'][$product]['price'] = getProduct($product);
        }
    }
}
header('Location: /cart.php');
exit;
?>