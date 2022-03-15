<?php
global $http_method;
global $params;
// ajax通信ではなかったら404を表示して処理終了
if (
    !isset($_SERVER['HTTP_X_REQUESTED_WITH']) ||
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest'
) {
    echo '404';
    die;
}

// postメソッドではない場合エラーコードを返す
if (strtolower($http_method) !== 'post') {
    header('HTTP/1.1 500 Internal Server Bad Request');
    header('Content-Type: application/json; charset=UTF-8');
    die(json_encode(array('message' => 'ERROR', 'code' => 500)));
}

// 送られてきたtextパラメータを$textにセット
$text = null;
if (isset($params['text'])) {
    $text = $params['text'];
}

// 検索用文字の配列
$words = [
    'あ',
    'あい',
    'あいう',
    'あいうえ',
    'あいうえお',
    'か',
    'かき',
    'かきく',
    'かきくけ',
    'かきくけこ',
];

// $textの文字が入っている文字列を取得して$responseに格納
$response = [];
if (!is_null($text)) {
    foreach ($words as $word) {
        if (strpos($word, $text) !== false) {
            $response[] = $word;
        }
    }
}

// 検索結果を返して処理終了
header("Content-type: application/json; charset=UTF-8");
echo json_encode($response);
exit;
