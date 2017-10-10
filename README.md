# phpfcm

## PHP API for Firebase cloud message

```php
<?php
include __DIR__."/../vendor/autoload.php";

define("CONCURRENCY", 50);
define("ACCESS_TOKEN", "google_access_token");

$client_list; // <=list of clients loaded from database

// You also can use PHPFCM\FCMClient::makeMessagePool()
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
    $client_list
);

$fcm = new PHPFCM\FCMClient(
    ACCESS_TOKEN,
    CONCURRENCY
);

$response = $fcm->sendPack($pack);

foreach($response as $r) {
    echo $r->getMessageID();
    echo "\n";
}
```
