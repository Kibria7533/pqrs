<?php

if (!function_exists('menu')) {
    function menu($menuName, $type = null, array $options = [])
    {
        return (new \Softbd\MenuBuilder\Models\Menu())->display($menuName, $type, $options);
    }
}

if (!function_exists('eng_to_bangla_codeM')) {
    function eng_to_bangla_code($input){
        $ban_number = array('১','২','৩','৪','৫','৬','৭','৮','৯','০','');
        $eng_number = array(1,2,3,4,5,6,7,8,9,0,'');
        return str_replace($eng_number,$ban_number,$input);
    }
}

if (!function_exists('bn2en')) {
    function bn2en($number)
    {
        $bn = array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
        $en = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
        return str_replace($bn, $en, $number);
    }
}



function apiLogin($url, $headers, $data)
{
    $curl = curl_init($url);

    curl_setopt($curl, CURLOPT_VERBOSE, 1);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));

    // TODO: blocking ssl validation for test purpose
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    $resp = curl_exec($curl);

    $info = curl_getinfo($curl);

    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $responseJson = json_decode($resp, true);

    if (isset($responseJson['success']) && $responseJson['success'] === false) {
        curl_close($curl);
        return array(
            "success" => false,
            "code" => $httpCode,
        );
    }
    curl_close($curl);
    return array(
        "success" => true,
        "code" => $httpCode,
        "body" => $responseJson,
        'access_token' => $responseJson['data']['access_token']
    );
}

function apiGetKhotian($url, $headers, $data)
{
    $curl = curl_init($url);

    curl_setopt($curl, CURLOPT_VERBOSE, 1);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));

    // TODO: blocking ssl validation for test purpose
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    $resp = curl_exec($curl);

    $info = curl_getinfo($curl);

    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $responseJson = json_decode($resp, true);

    if (isset($responseJson['success']) && $responseJson['success'] === false) {
        curl_close($curl);
        return array(
            "success" => false,
            "code" => $httpCode,
        );
    }

    curl_close($curl);
    return array("code" => $httpCode, "body" => $responseJson);
}


function apiLoginData()
{
    $headers = array(
        "content-type: application/json",
    );
    $data = array(
        "id" => 666600007594,
        "key" => 123456,
        "service" => "mobile-app"
    );
    $url = "http://v2.utility.eporcha.gov.bd/api/v1/postal-app-login";

    return apiLogin($url, $headers, $data);
}






