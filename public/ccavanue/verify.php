<?php
$working_key = '7C291686908D846738B36BE858FA8E8F';

// Provide access code Shared by CCAVENUES

$access_code = 'AVYI02GG79AB08IYBA';

// Provide URL shared by ccavenue (UAT OR Production url)

$URL="https://apitest.ccavenue.com/apis/servlet/DoWebTrans";

// Sample request string for the API call
$merchant_json_data = array(
    'order_List' => array(
        array('reference_no' => '308005354789', 'order_no' => 'AVI1771754493','amount' => '639.20'),
    )
);


// Generate json data after call below method
$merchant_data = json_encode($merchant_json_data);

// Encrypt merchant data with working key shared by ccavenue
$encrypted_data = encrypt($merchant_data, $working_key);

//make final request string for the API call
$final_data = "reference_no=308005242653&amount=1.00&request_type=JSON&access_code=" . $access_code . "&command=confirmOrder&version=1.1&response_type=JSON&enc_request=" . $encrypted_data;
//$final_data ="reference_no=308005241379&amount=1.00&request_type=JSON&access_code=".$access_code."&command=confirmOrder&response_type=JSON&enc_request=".$encrypted_data;
//echo $final_data;exit;
// Initiate api call on shared url by CCAvenues
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $URL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_VERBOSE, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $final_data);

// Get server response ... curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);

$information = explode('&', $result);
$dataSize = sizeof($information);
$status1 = explode('=', $information[0]);
$status2 = explode('=', $information[1]);

if ($status1[1] == '1') {
$recorddata = $status2[1];
print_r($recorddata);exit;
} else {
$status = decrypt(trim($status2[1]), $working_key);
$status = json_decode($status);
print_r($status->success_count);exit;
}
// Sample request string for the API call
    function encrypt($plainText, $key) {
    $key = hextobin(md5($key));
    $initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
    $openMode = openssl_encrypt($plainText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
    $encryptedText = bin2hex($openMode);
    return $encryptedText;
}

function decrypt($encryptedText, $key) {
    $key = hextobin(md5($key));
    $initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
    $encryptedText = hextobin($encryptedText);
    $decryptedText = openssl_decrypt($encryptedText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
    return $decryptedText;
}

function hextobin($hexString) {
    $length = strlen($hexString);
    $binString = "";
    $count = 0;
    while ($count < $length) {
        $subString = substr($hexString, $count, 2);
        //echo $subString;exit;           
        $packedString = pack("H*", $subString);
        if ($count == 0) {
            $binString = $packedString;
        } else {
            $binString .= $packedString;
        }

        $count += 2;
    }
    return $binString;
}
?>