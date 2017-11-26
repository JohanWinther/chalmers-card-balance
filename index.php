<?php
require("vendor/autoload.php");

use Goutte\Client;

$client = new Client();

$crawler = $client->request('GET', 'https://kortladdning3.chalmerskonferens.se/Default.aspx');
$form = $crawler->selectButton('Nästa')->form();
$crawler = $client->submit($form, array('txtCardNumber' => '3819285243692191'));
$name = $crawler->filter('#txtPTMCardName')->text();
$balance = $crawler->filter('#txtPTMCardValue')->text();
echo $name;
echo $balance . " kr";
?>
