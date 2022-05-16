<?php
session_start();
print_r($_POST);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST['product'])){
        $product = $_POST['product'];
        if(isset($_SESSION['cart'][$product]['quantity'])){
            if($_SESSION['cart']["$product"]['quantity'] > 0)
                $_SESSION['cart'][$product]['quantity']--;
            if($_SESSION['cart'][$product]['quantity'] <= 0)
                unset($_SESSION['cart'][$product]);
        }
    }
}
header('Location: /cart.php');
exit;
?>