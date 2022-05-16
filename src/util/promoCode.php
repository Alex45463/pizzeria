<?php
session_start();
print_r($_POST);

function returnError($type){
    $_SESSION['error'] = 'Invalid Promo Code';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST['promoCode'])){
        $promoCode = $_POST['promoCode'];
        if(is_string($promoCode)){
            $promoCode = is_promoCode_valid($promoCode);
            if(isset($is_valid)){
                $_SESSION['promoCode'] = $promoCode;
            }
            else returnError();
        }
        else returnError();
    }
}
header('Location: /cart.php');
exit;
?>