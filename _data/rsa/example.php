<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<?php
include('rsa.class.php');
$RSA = new RSA();

/* Example */
//echo"<i>Keys:</i><br />";
//$keys = $RSA->generate_keys ('9990454949', '9990450271');
$keys[0] = "81482927542014896177322756250316553637";
$keys[1] = "875283503";
$keys[2] = "49278609749252008771364345271028949967";


$message="테스트 내용";
$encoded = $RSA->encrypt ($message, $keys[1], $keys[0], 5);
$decoded = $RSA->decrypt ($encoded, $keys[2], $keys[0]);

echo "<b>Message:</b> $message<br />\n";
echo "<b>Encoded:</b> $encoded<br />\n";
echo "<b>Decoded:</b> $decoded<br />\n";
echo "Success: ".(($decoded == $message) ? "True" : "False");
/*
$message = "testtest";
$signature = $RSA->sign($message, $keys[1], $keys[0]);
echo "<b>Original Message:</b> <div dir=rtl>$message</div><br />\n";
echo "<b>Message Signature:</b><br /> $signature<br /><br />\n";

$fake_msg = "testtest";
echo "<b>Fake Message:</b> <div dir=rtl>$fake_msg</div><br />\n";

echo "<b>Check original message against given signature:</b><br />\n";
echo "Success: ".(($RSA->prove($message, $signature, $keys[2], $keys[0])) ? "True" : "False")."<br /><br />\n";

echo "<b>Check fake message against given signature:</b><br />\n";
echo "Success: ".(($RSA->prove($fake_msg, $signature, $keys[2], $keys[0])) ? "True" : "False")."<br /><hr />\n";

$file = 'about.html';
$signature = $RSA->signFile($file, $keys[1], $keys[0]);
echo "<b>Original File:</b> $file<br /><br />\n";
echo "<b>File Signature:</b><br /> $signature<br /><br />\n";

$fake_file = 'style.css';
echo "<b>Fake File:</b> $fake_file<br /><br />\n";

echo "<b>Check original file against given signature:</b><br />\n";
echo "Success: ".(($RSA->proveFile($file, $signature, $keys[2], $keys[0])) ? "True" : "False")."<br /><br />\n";

echo "<b>Check fake file against given signature:</b><br />\n";
echo "Success: ".(($RSA->proveFile($fake_file, $signature, $keys[2], $keys[0])) ? "True" : "False")."<br /><br />\n";
*/
?>