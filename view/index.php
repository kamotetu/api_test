<?php
global $params;
$post_path = Route::createRouteUrl('/post');
?>

<label for="text">テキスト</label>
<input type="text" id="text" name="text" data-post_path="<?php echo $post_path; ?>">
<div id="timer">
    3<!--insert_timer_js-->
</div>
<ul id="insert_js">
    <!--insert_js-->
</ul>
<script>
    $(function () {
        let jqxhr;
        let insert_elem = $('#insert_js');
        let text_elem = $('#text');
        let timer_elem = $('#timer');
        let timeout_id = null;
        let timer_count = 3;
        let interval_id = null;

        text_elem.on('input', function () {
            ajaxClearTimeoutId();
            let text = $(this).val();
            let url = $(this).data('post_path');
            if (text === '' || text === null) {
                cleanUpResult();
                return false;
            }
            let data = new FormData();
            data.append('text', text);
            ajaxSetTimeoutId(url, data);
        });
        function cleanUpResult () {
            insert_elem.empty();
        }
        function ajaxSetTimeoutId (url, data) {
            countDown();
            timeout_id = setTimeout(function () {
                doAjax(url, data);
            }, 3000);
        }
        function ajaxClearTimeoutId () {
            if (timeout_id !== null) {
                clearTimeout(timeout_id);
                timeout_id = null;
            }
        }
        function doAjax (url, data) {
            if (jqxhr) {
                jqxhr.abort();
            }
            jqxhr = $.ajax({
                type: 'POST',
                url: url,
                data: data,
                processData: false,
                contentType: false,
                dataType: 'json',
                timeout: 10000,
            }).done(function (data) {
                cleanUpResult();
                for (let i = 0;data.length > i;++i) {
                    insert_elem.append('<li>' + data[i] + '</li>');
                }
            }).fail(function (x,s,e) {
                cleanUpResult();
                console.log(x,s,e);
            });
        }
        function countDown () {
            timer_count = 3;
            if (interval_id !== null) {
                clearInterval(interval_id);
            }
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
    });
</script>
