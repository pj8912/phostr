<?php

namespace Phostr\Keys;
require_once '../vendor/autoload.php';

use BitSwap\Bech32\Exception\Bech32Exception;
use Elliptic\EC;
use function BitWasp\Bech32\convertBits;
use function BitWasp\Bech32\decode;
use function BitWasp\Bech32\encode;
use Mdanter\Ecc\Crypto\Signature\SchnorrSignature;

//for key generation and conversions from hex-beche32 and vice-versa

class Key{
	


	public function generatePrivateKey():string{
		$ec = new EC('secp256k1');
		$key = $ec->genKeyPair();
		return $key->priv->toString('hex');
	}

	public function getPublicKey(string $private_hex):string{

		$ec = new EC('secp256K1');
		$private_key = $ec->keyFromPrivate($private_hex);
		//public key in hex
		$public_hex = $private_hex->getPublic(true, 'hex');
		return substr($public_hex,2);
	}
	
	public function convertPublicKeyToBech32(string $key): string
    {
        return $this->convertToBech32($key, 'npub');
    }

    public function convertPrivateKeyToBech32(string $key): string
    {
        return $this->convertToBech32($key, 'nsec');
    }

    protected function convertToBech32(string $key, string $prefix): string
    {
        $str = '';

        try {
            $dec = [];
            $split = str_split($key, 2);
            foreach ($split as $item) {
                $dec[] = hexdec($item);
            }
            $bytes = convertBits($dec, count($dec), 8, 5);
            $str = encode($prefix, $bytes);
        } catch (Bech32Exception) {
        }

        return $str;
    }

    public function SignEvent($event, string $private_key): void
    {
        $hash_content = $this->serializeEvent($event);
        if ($hash_content) {
            $id  = hash('sha256', utf8_encode($hash_content));
            $event->setId($id);
            $sign = new SchnorrSignature();
            $signature = $sign->sign($private_key, $event->getId());
            $event->setSignature($signature['signature']);
        }
    }

    public function serializeEvent($event): bool|string
    {
        $arr = [];
        return json_encode($arr, JSON_UNESCAPED_SLASHES);
    }
	

	
}

