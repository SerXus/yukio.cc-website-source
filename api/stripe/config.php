<?php  

// Product Details  
// Minimum amount is $0.50 US  
$productName = "Yukio Classic";  
$productID = "prod_IeEv1IGqYBq0Ms";  
$productPrice = "1690"; 
$currency = "eur"; 
 
// Convert product price to cent 
// $stripeAmount = round($productPrice*100, 2); 
  
// Stripe API configuration   
define('STRIPE_API_KEY', '');  
define('STRIPE_PUBLISHABLE_KEY',''); // si je change, il faut modifier dans purchase.php aussi !!!!!
define('STRIPE_SUCCESS_URL', 'https://yukio.cc/api/stripe/success.php'); 
define('STRIPE_CANCEL_URL', 'https://yukio.cc/api/stripe/cancel.php'); 
   
