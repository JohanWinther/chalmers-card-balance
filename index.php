<?php
require("vendor/autoload.php");

use Goutte\Client;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Max-Age: 60");
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");
header("Access-Control-Allow-Methods: GET");
header('Content-type:application/json;charset=utf-8');

function invalid_number($code,$error_msg) {
    http_response_code($code);
    echo json_encode(['error'=>$error_msg]);
    die;
}

preg_match('/(\d{16})/', $_SERVER['REQUEST_URI'], $matches);
if (!array_key_exists(0 , $matches)) {
    invalid_number(400,"Invalid card number: should be 16 digits.");
}
$cardNumber = $matches[1];

$client = new Client();
$crawler = $client->request('GET', 'https://kortladdning3.chalmerskonferens.se/Default.aspx');
$form = $crawler->selectButton('Nästa')->form();
$crawler = $client->submit($form, array('txtCardNumber' => $cardNumber));
if ($crawler->filter('#txtPTMCardName')->count() != 1) {
    invalid_number(404,"Invalid card number: card not found.");
}

$cardHolder = $crawler->filter('#txtPTMCardName')->text();
$cardBalance = $crawler->filter('#txtPTMCardValue')->text();
$cardBalance = floatval(str_replace(',', '.', str_replace(' ', '', $cardBalance)));
$output = new stdClass();
$output->cardHolder = $cardHolder;
$output->cardNumber = $cardNumber;
$output->cardBalance = new stdClass();
$output->cardBalance->value = $cardBalance;
$output->cardBalance->currency = "kr";
echo json_encode($output);

?>
