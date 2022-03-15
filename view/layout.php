<?php

require_once(__DIR__ . '/../Route.php');
global $route_name;
global $params;
$child_template_path = Route::getFilePathByName($route_name);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <script
        src="https://code.jquery.com/jquery-3.6.0.js"
        integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
        crossorigin="anonymous"></script>
</head>
<body>
<main>
    <?php
    include($child_template_path);
    ?>
</main>
</body>
</html>