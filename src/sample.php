<?php
include __DIR__."/../vendor/autoload.php";

define("CONCURRENCY", 50);
define("ACCESS_TOKEN", "google-fcm-token");

$client_list= [
    [
        'to' => $to,
        'id' => "msg_1",
        'name' => 'John',
        'last_name' => 'Snow'
    ],
    [
        'to' => $to,
        'id' => "msg_2",
        'name' => 'Tyreon',
        'last_name' => 'Laniter'
    ],
    [
        'to' => $to,
        'id' => "msg_3",
        'name' => 'John',
        'last_name' => 'Snow'
    ],
    [
        'to' => $to,
        'id' => "msg_4",
        'name' => 'Tyreon',
        'last_name' => 'Laniter'
    ],
    [
        'to' => $to,
        'id' => "msg_5",
        'name' => 'John',
        'last_name' => 'Snow'
    ],
    [
        'to' => $to,
        'id' => "msg_6",
        'name' => 'Tyreon',
        'last_name' => 'Laniter'
    ],
    [
        'to' => $to,
        'id' => "msg_7",
        'name' => 'John',
        'last_name' => 'Snow'
    ],
    [
        'to' => $to,
        'id' => "msg_8",
        'name' => 'Tyreon',
        'last_name' => 'Laniter'
    ],
    [
        'to' => $to,
        'id' => "msg_9",
        'name' => 'John',
        'last_name' => 'Snow'
    ],
    [
        'to' => $to,
        'id' => "msg_10",
        'name' => 'Tyreon',
        'last_name' => 'Laniter'
    ],
    
];

$pack = PHPFCM\FCMClient::makeNotificationPool(
    function($client){
        return array(
            "id" => $client['id'],
            "to" => $client['to'],
            "message_options" => array(
                "dry_run" => false
            ),
            "notification" => array(
                "title" => "Hello {$client['name']}!",
                "body" => "have a look at our offers, Mr. {$client['last_name']}! "
            )
        );
    },
    $client_list
);

$fcm = new PHPFCM\FCMClient(
    ACCESS_TOKEN,
    CONCURRENCY
);

$response = $fcm->sendAsync($pack);

foreach($response as $k => $r) {
    print_r($k);
    echo "\n";
}