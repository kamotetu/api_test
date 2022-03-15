<?php

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
    echo '404';
    die;
}

global $http_method;

if ($http_method !== 'POST') {
    header('HTTP/1.1 500 Internal Server Bad Request');
    header('Content-Type: application/json; charset=UTF-8');
    die(json_encode(array('message' => 'ERROR', 'code' => 500)));
}

global $params;

$text = null;
if (isset($params['text'])) {
    $text = $params['text'];
}

$words = ['あ', 'あい', 'あいう', 'あいうえ', 'あいうえお'];

$response = [];
if (!is_null($text)) {
    foreach ($words as $word) {
        if (strpos($word, $text) !== false) {
            $response[] = $word;
        }
    }
}

header("Content-type: application/json; charset=UTF-8");
echo json_encode($response);
exit;
