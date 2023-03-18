<style>
    img {
        max-width: 100%;
    }
</style>

<?php
require "../privileges/viewer.php";
require "../db_conn.php";

$requestID = $_COOKIE['requestID'];

$query = 'SELECT confirmationFile FROM requests WHERE requestID = ' . $requestID . '';
$result = mysqli_query($conn, $query);
while ($record = mysqli_fetch_assoc($result)) {
    if ($record['confirmationFile']) {
        echo '<img src="data:image/png;base64,' . $record['confirmationFile'] . '" />';
    } else {
        echo 'Файл отсутствует';
    }
}
