<div class="page-switching">
    <?php
    $pageStart = $offSet + 1;
    $pageEnd = $pageStart + $perPage - 1;

    //current page without query
    $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ||
        $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $url = str_replace("?", "", $url);
    $urlWithoutQuery = "'" . str_replace($_SERVER['QUERY_STRING'], "", $url) . "'";
    $statusTypeForPageSwitching = "'" . $_SESSION['statusType'] . "'";
    //current page without query

    if ($page > 0) {
        echo '<button class="button-blue" onclick="pagePrevious(' . $page . ', ' . $urlWithoutQuery . ', ' . $statusTypeForPageSwitching . ')">&#8249;</button>';
    }
    echo '&nbsp ' . $pageStart . '-' . $pageEnd . '&nbsp';
    echo '<button class="button-blue" onclick="pageNext(' . $page . ', ' . $urlWithoutQuery . ', ' . $statusTypeForPageSwitching . ')">&#8250;</button>';
    ?>
    <script src="../scripts/pageSwitching.js"></script>
</div>