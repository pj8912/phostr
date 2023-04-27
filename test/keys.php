<?php


require_once '../vendor/autoload.php';

use Phostr\Keys\Key;



// $postdata = file_get_contents("php://input");
// $request = json_decode($postdata);

// if ($request->is_request == "create_new_key") {

$key = new Key();
$pr_key = $key->generatePrivateKey();
$pub_key = $key->getPublicKey($pr_key);
// return public and private key in  bech32 format
exit(
    json_encode(
        [
            'private_key' =>  $key->convertPrivateKeyToBech32($pr_key),
            'public_key' => $key->convertPublicKeyToBech32($pub_key)
        ]
    ));

// }
