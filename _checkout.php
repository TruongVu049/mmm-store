<?php

if (strtoupper($_SERVER['REQUEST_METHOD']) === 'POST') {
    if ($_POST['bankCode'] == "cod") {
        require __DIR__ . '/_thanhtoan.php';
    } else {
        require __DIR__ . '/vnpay/vnpay_create_payment.php';
    }
}
