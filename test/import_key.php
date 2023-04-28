<?php
 require_once '../vendor/autoload.php';
 use Phostr\Keys\Key;

 $postdata = file_get_contents("php://input");
 $request = json_decode($postdata);
 $key = new Key();
 $input_key  = $request->input_private_key;
 $hexPirvateKey = $key->convertToHex($input_key);
 //create respective public key
$pub_key = $key->getPublicKey($hexPirvateKey);
$keys = [
    'publickey' =>$key->convertPublicKeyToBech32($pub_key),
    'privatekey' => $input_key
];
exit(json_encode($keys));

// $pr_key = $key->generatePrivateKey();
// $pub_key = $key->getPublicKey($pr_key);