<?php
if (isset($_GET['page'])) {
    $page = $_GET['page'];
    $page = intval($page);
    if (!(is_int($page))) {
        $page = 0;
    }
    if ($page < 0) {
        $page = 0;
    }
} else {
    $page = 0;
}
$perPage = 100;
$offSet = $page * $perPage;
