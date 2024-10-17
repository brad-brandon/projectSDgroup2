<?php
session_start();

// Get the membership and price from the form
$membership = $_POST['membership'];
$price = $_POST['price'];

// Toyyibpay API integration settings (replace with your actual settings)
$categoryCode = "wmblp2jj"; // From Toyyibpay
$billName = "Gym Membership";
$billAmount = $price * 100; // Toyyibpay requires amount in cents
$billDescription = ucfirst($membership) . " Membership";
$secretKey = "g2l4vqtn-1h7u-hpss-rsj5-r7xwckpz9bqs"; // From Toyyibpay
$callbackUrl = "https://fasttrackgym.online/callback.php"; // URL for payment status callback

// Redirect to Toyyibpay FPX payment gateway
header("Location: https://toyyibpay.com/paymentgateway/$categoryCode?billName=$billName&billAmount=$billAmount&billDescription=$billDescription&callbackUrl=$callbackUrl");
exit();
?>