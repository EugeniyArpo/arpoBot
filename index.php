<?php

file_put_contents(__DIR__ . '/log.txt', file_get_contents('php://input'));

const TOKEN = '1276287592:AAG8Bll-uyge042VPDdn3h02nnS3vyN35yM';
const BASE_URL = 'https://api.telegram.org/bot' . TOKEN . '/';

function sendRequest($method, $params = []){
    if (!empty($params)){
        $url = BASE_URL . $method . '?' . http_build_query($params);
    }else{
        $url = BASE_URL . $method;
    }
    return  json_decode(
        file_get_contents($url),
        JSON_OBJECT_AS_ARRAY);
}

$updates = sendRequest('getUpdates');

$time = date('Y-m-d H:i:s');

foreach ($updates['result'] as $update){
    $chat_id = $update['message']['chat']['id'];
    sendRequest('sendMessage', ['chat_id' => $chat_id, 'text' => $time]);
}
