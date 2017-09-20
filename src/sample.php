<?php
include __DIR__."/../vendor/autoload.php";

define("CONCURRENCY", 50);
define("ACCESS_TOKEN", "google_access_token");

$client_list; // <= Loaded a list of clients from database

$pack = PHPFCM\FCMClient::makeNotificationPool(
    function($client){
        return array(
            "to" => $client->token,
            "message_options" => array(
                "dry_run" => false
            ),
            "notification" => array(
                "title" => "Hello {$client->name}!",
                "body" => "have a look at our offers, Mr. {$client->last_name}! "
            )
        );
    },
    range(0,1)
);

$fcm = new PHPFCM\FCMClient(
    ACCESS_TOKEN,
    CONCURRENCY
);

$response = $fcm->sendPack($pack)[""];

foreach($response as $r) {
    echo $r->getMessageID();
    echo "\n";
}
