<?php

include('./src/MailChimp.php');
use \DrewM\MailChimp\MailChimp;

require_once('./config.php');

$mailchimp = new MailChimp($config["mailchimp_api_key"]);

$result = $mailchimp->post("lists/{$config["mailchimp_list_id"]}/members", [
  'email_address' => $_POST["email"],
  'merge_fields'  => ['FNAME'=>$_POST["name"], 'LNAME'=>$_POST["surname"], 'EMAIL'=>$_POST["email"]],
  'status'        => 'subscribed',
]);

if ($mailchimp->success()) {
  $response = array(
    'result' => true
  );
} else {
  $response = array(
    'result' => false,
    'error' => $mailchimp->getLastError(),
    'name' => $_POST['name'],
    'surname' => $_POST['surname'],
    'email' => $_POST['email']
  );
}

echo json_encode($response);

?>
