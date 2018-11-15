<?php
// Set all these variables for your Newsletter 
define('BOX_MAILCHIMP_NEWSLETTER_API_KEY', '...-us1');
define('BOX_MAILCHIMP_NEWSLETTER_ID', '...');
define('BOX_MAILCHIMP_NEWSLETTER_U', '...');


require_once(__DIR__.'/mailchimp.php');
$mailchimp = new MailChimp(BOX_MAILCHIMP_NEWSLETTER_API_KEY);

// Testcase for check if subscribed - used in Newsletter Discount
$email = 'test@some-test-domain.com'; 
$reply = $mailchimp->list_check_subscriber([
    'id_list' => BOX_MAILCHIMP_NEWSLETTER_ID, 
    'email' => $email
]);
if (isset($reply->type)) {
    $errorMessage = "Unable to run check_subscriber command()!\n" .
       "\tMsg=" . print_r($reply, true) . "\n";
    echo $errorMessage;
    return false; 
} 
if (isset($reply->status) && $reply->status == 'subscribed') { 
   echo "User is Subscribed" ;
} else {
   echo "User is not subscribed" ;
}

// Testcase for subscribe - used in Mailchimp Integration 
$email = 'test@some-test-domain.com'; 
$reply = $mailchimp->list_add_subscriber([
    'id_list' => BOX_MAILCHIMP_NEWSLETTER_ID, 
    'email' => $email
]);
if (isset($reply->type)) {
    $errorMessage = "Unable to run add_subscriber command()!\n" .
       "\tMsg=" . print_r($reply, true) . "\n";
    echo $errorMessage;
} else {
   echo "User is Subscribed" ;
}
