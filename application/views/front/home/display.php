<!DOCTYPE HTML>  
<html>
<head>
</head>
<body>  

<?php

$var1 = $_GET['payment_id'];
$var2 = $_GET['payment_request_id'];

//echo $var2;
echo '<br>';
//echo $var1;

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://test.instamojo.com/api/1.1/payment-requests/'.$var2);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
curl_setopt($ch, CURLOPT_HTTPHEADER,array("X-Api-Key:PLEASE PROVIDE YOUR API KEY HERE","X-Auth-Token:PLEASE PROVIDE YOUR API AUTH TOKEN HERE"));
$response = curl_exec($ch);
curl_close($ch); 

$myArray = array(json_decode($response, true));
echo '<br>';
//print_r($myArray);
echo '<br>';

$payment_id = $myArray[0]["payment_request"]["payments"][0]["payment_id"];
$amount = $myArray[0]["payment_request"]["payments"][0]["amount"];
$buyer_name = $myArray[0]["payment_request"]["payments"][0]["buyer_name"];
$buyer_phone = $myArray[0]["payment_request"]["payments"][0]["buyer_phone"];
$buyer_email = $myArray[0]["payment_request"]["payments"][0]["buyer_email"];
$status = $myArray[0]["payment_request"]["payments"][0]["status"];

echo "<br>Buyer name :".$buyer_name;
echo "<br>Buyer_phone :".$buyer_phone;
echo "<br>Buyer_email :".$buyer_email;
echo "<br>Amount :".$amount;
echo "<br>Payment ID :".$payment_id;
echo "<br>Status :".$status;
echo "<br>Data :".$DataSign;
?>

</body>
</html>