<!DOCTYPE html>
<html lang="pl">
<head>
    <title>Hosting checker</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>
<body>
<?php
$time_start = microtime(true);
set_time_limit(120);

function testCatshare($zrodlo)
{
    if (!($zrodlo === FALSE) && strpos($zrodlo, 'Wolne pobieranie') > 0)
        return TRUE;
    else
        return FALSE;
}

function testRapidu($zrodlo)
{
    if (!($zrodlo === FALSE) && (strpos($zrodlo, 'Pobierz za darmo') > 0 || strpos($zrodlo, 'Download for free') > 0))
        return TRUE;
    else
        return FALSE;
}

function testLunaticfiles($zrodlo)
{
    if (!($zrodlo === FALSE) && strpos($zrodlo, 'Pobieranie Darmowe') > 0)
        return TRUE;
    else
        return FALSE;
}

function testZippyshare($zrodlo)
{
    if (!($zrodlo === FALSE) && strpos($zrodlo, 'You have requested the file') > 0)
        return TRUE;
    else
        return FALSE;
}

function testFileshark($zrodlo)
{
    if (!($zrodlo === FALSE) && (strpos($zrodlo, 'Pobierz za darmo') > 0 || strpos($zrodlo, 'Jeżeli chcesz pobrać ten plik, wykup konto Premium') > 0))
        return TRUE;
    else
        return FALSE;
}

function wwwDetector($www, $zrodlo)
{
    if (strpos($www, 'catshare') > 0) {
        return testCatshare($zrodlo);
    } elseif (strpos($www, 'rapidu') > 0) {
        return testRapidu($zrodlo);
    } elseif (strpos($www, 'fileshark.') > 0) {
        return testFileshark($zrodlo);
    } elseif (strpos($www, 'lunaticfiles.') > 0) {
        return testLunaticfiles($zrodlo);
    } elseif (strpos($www, 'zippyshare.') > 0) {
        return testZippyshare($zrodlo);
    } else {
        return FALSE;
    }
}

function checkLink($www)
{
    $hosting = array('catshare', 'rapidu', 'fileshark', 'zippyshare', 'lunaticfiles',);
    foreach ($hosting as $value) {
        if (strpos($www, $value) > 0)
            return TRUE;
    }
    return FALSE;
}

if (!empty($_POST['hosting_url'])) {
    $urlTab = nl2br($_POST['hosting_url']);
    $urlTab = explode('<br />', $urlTab);
    if (!empty($_POST['hosting_url'])) {
        //
        $aContext = array(
            'http' => array(
                'method' => 'GET',
                'header' => 'Accept-language: pl, en\r\n',
                'proxy' => 'tcp://37.128.116.34:8080',
                'request_fulluri' => true,
                'timeout' => 10,
            ),
        );

        //DODAJ TIMEOUT DLA PROXY JAKBY PADŁO i zaimplementuj proxy inne
        //37.128.116.34:8080
        //178.33.52.175:8080
        //82.214.137.66:8080
        $cxContext = stream_context_create($aContext);
        //
        $activeLink = $deactiveLink = 0;
        //
        echo '<table class="table">';
        echo('<thead><tr><th>Adres www</th><th>Stan</th></tr></thead>');
        foreach ($urlTab as $value) {
            set_time_limit(16);
            $value = trim($value);
            if (!empty($value) && checkLink($value)) {

                if (strpos($value, 'catshare') > 0)
                    @$homepage = file_get_contents($value, False, $cxContext);
                else
                    @$homepage = file_get_contents($value);
                //echo $homepage;

                if (wwwDetector($value, $homepage)) {
                    $value = htmlspecialchars($value);
                    echo '<tr class="success">';
                    echo "<td><a href=\"$value\">$value</a></td>";
                    echo '<td>Ok!</td>';
                    $activeLink++;
                } else {
                    $value = htmlspecialchars($value);
                    echo '<tr class="danger">';
                    echo "<td><a href=\"$value\">$value</a></td>";
                    echo '<td>Odnośnik wygasł!</td>';
                    $deactiveLink++;
                }
                echo '</tr>';
            }
        }
        echo '</table>';
        echo '<p><b>Razem:</b> ' . ($activeLink + $deactiveLink);
        echo ' <b>Aktywnych:</b> ' . $activeLink . ' <b>Nieaktywnych:</b> ' . $deactiveLink . '</p>';
    }
} else {
    echo('<div class="alert alert-danger"><strong>Ostrzeżenie!</strong> Brak linków.</div>');
}
echo 'Czas wykonania: ' . round(microtime(true) - $time_start, 2) . 's';
?>
</body>
</html>

