<?php
global $params;
$post_path = Route::createRouteUrl('/post');
?>

<div>
    <label for="text1">テキスト1</label>
    <input type="text" id="text1" name="text" data-post_path="<?php echo $post_path; ?>">
</div>
<div>
    <label for="text2">テキスト2</label>
    <input type="text" id="text2" name="text" data-post_path="<?php echo $post_path; ?>">
</div>
<div style="display: flex;">
    <div>タイマー:&emsp;</div>
    <div id="timer">
        3<!--insert_timer_js-->
    </div>
</div>

<ul id="insert_js">
    <!--insert_js-->
</ul>
<script>
    $(function () {
        // 入力後通信までの秒数
        const timer_default_count = 3;
        // 入力文字数最低文字数
        const text_length = 3;
        // ajaxの結果受け取り用変数
        let jqxhr;
        // サーバーから返された値を表示する要素
        let insert_elem = $('#insert_js');
        // inputフォーム1
        let text_elem1 = $('#text1');
        // inputフォーム2
        let text_elem2 = $('#text2');
        // 入力後通信までの秒数を表示する要素
        let timer_elem = $('#timer');
        // setTimeoutのid用変数
        let timeout_id = null;
        // 入力後通信までの秒数を動的に表示するための変数
        let timer_count = timer_default_count;
        // setIntervalのid用変数
        let interval_id = null;
        // text_formの1と2を区別する用変数
        let form_type = null;

        // text_formの1に入力があったら(時間差で通信するフォーム)
        text_elem1.on('keyup', function () {
            // setTimeoutが実行中だったらカウントダウンをストップする
            ajaxClearTimeoutId();
            // 入力フォームの値をtextにセット
            let text = $(this).val();
            // 送信先のurlをurlにセット
            let url = $(this).data('post_path');
            // textが空もしくは規定の文字数以下の場合は
            if (
                text === '' ||
                text === null ||
                text.length < text_length
            ) {
                // ajax通信するまでのカウントダウンアニメーションをリセットする
                resetTimerCount();
                // 検索結果表示場所をクリアする
                cleanUpResult();
                return false;
            }
            // サーバーに送るパラメータをセットするFormDataをnew
            let data = new FormData();
            // FormDataのインスタンスにtextをセット
            data.append('text', text);
            // 時間差でajax通信するか判断するためform_typeに1をセット
            form_type = 1;
            // setTimeout関数で時間差でajax通信を実行する
            ajaxSetTimeoutId(url, data, form_type);
        });

        // text_formの2に入力があったら(時間差を使用しないフォーム)
        // 途中まで上記に同じ
        text_elem2.on('keyup', function () {
            ajaxClearTimeoutId();
            let text = $(this).val();
            let url = $(this).data('post_path');
            if (
                text === '' ||
                text === null ||
                text.length < text_length
            ) {
                resetTimerCount();
                // 時間差を使用しないので分かりやすくするためにcleanUpResult関数は実行しない
                return false;
            }
            let data = new FormData();
            data.append('text', text);
            form_type = 2;
            // 時間差を使用しないのでそのままajax通信処理を実行
            doAjax(url, data, form_type);
        });

        // 検索結果表示を削除する
        function cleanUpResult () {
            insert_elem.empty();
        }

        // ajax通信を時間差で実行する
        function ajaxSetTimeoutId (url, data, form_type) {
            // ajax通信までの時間をカウントダウンする
            countDown();
            // setTimeoutの返り値のidをtimeout_idにセット
            timeout_id = setTimeout(function () {
                // ajax通信を実行
                doAjax(url, data, form_type);
            }, 3000);// 3秒後に実行
        }

        // ajax通信をするためのsetTimeoutが実行中の場合、ストップする
        function ajaxClearTimeoutId () {
            if (timeout_id !== null) {
                clearTimeout(timeout_id);
                // timeout_idをリセット
                timeout_id = null;
            }
        }

        // ajax通信処理
        function doAjax (url, data, form_type) {
            // ajax通信中の場合ajax通信をストップする
            if (jqxhr) {
                jqxhr.abort();
            }
            // ajax通信処理の返り値をjqxhrにセット(↑これで上記の条件分岐ができる)
            jqxhr = $.ajax({
                type: 'POST',
                url: url,
                data: data,
                processData: false,
                contentType: false,
                dataType: 'json',
                timeout: 10000,
            }).done(function (data) {
                // 分かりやすくするため、text_form1の場合だけ検索結果をリセットする
                if (form_type === 1) {
                    cleanUpResult();
                }
                // 検索結果を表示する
                for (let i = 0;data.length > i;++i) {
                    insert_elem.append('<li>' + data[i] + '</li>');
                }
            }).fail(function (x,s,e) {
                // 通信失敗時は検索結果をリセットする
                cleanUpResult();
                console.log(x,s,e);
            });
        }

        // 入力からajax通信するまでの時間を表示する処理
        function countDown () {
            timer_count = timer_default_count;
            ajaxClearIntervalId();
            timer_elem.empty();
            timer_elem.append(timer_count);
            interval_id = setInterval(function () {
                if (timer_count <= 0) {
                    return false;
                }
                timer_count -= 1;
                timer_elem.empty();
                timer_elem.append(timer_count);

            }, 1000);
        }

        // 上記のsetInterval関数をストップしてタイマーの表示を初期値にリセットする処理
        function resetTimerCount () {
            ajaxClearIntervalId();
            timer_count = timer_default_count;
            timer_elem.empty();
            timer_elem.append(timer_count);
        }

        // タイマーをストップする処理
        function ajaxClearIntervalId () {
            if (interval_id !== null) {
                clearInterval(interval_id);
            }
        }
    });
</script>
