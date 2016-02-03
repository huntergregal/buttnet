<?php
function snowdenEnc($string) {

 $white = base64_decode(base64_decode('U0cxTU5pbzNSR1pGTTBCZVZqRkpURWx1WHk0K1YwQnJNMVZ3S1FvPQo='));
 $text = $string;
 $black = '';

 for($i=0,$j=0;($i<strlen($text) && $j<strlen($white));$i++,$j++)
 {
         $black .= $text{$i} ^ $white{$j};
 }
 return base64_encode(base64_encode($black));
}

function snowdenDec($string) {

 $white = base64_decode(base64_decode('U0cxTU5pbzNSR1pGTTBCZVZqRkpURWx1WHk0K1YwQnJNMVZ3S1FvPQo='));
 $text = base64_decode(base64_decode($string));
 $black = '';

 for($i=0,$j=0;($i<strlen($text) && $j<strlen($white));$i++,$j++)
 {
         $black .= $text{$i} ^ $white{$j};
 }

 return $black;
}

$enc = snowdenEnc($argv[1]);

echo 'Encrypted '.$enc."\n";
echo 'Decrypted '.snowdenDec($enc)."\n";

?>
