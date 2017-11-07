<?php

$time_start = microtime(true);
/*
  function getWordpressImageSize($url) {
  $headers = array(
  "Range: bytes=0-32768"
  );

  $curl = curl_init($url);
  curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
  $data = curl_exec($curl);
  curl_close($curl);

  $raw = $data;
  $im = imagecreatefromstring($raw);
  $width = imagesx($im);
  $height = imagesy($im);
  return array($width, $height);
  }
 */

function isFolder($www) {
    if (strpos($www, 'dropbox.com/sh/') > 0) {
        $homepage = file_get_contents($www);
        if (strpos($homepage, 'http') > 0)
            return TRUE;
        else
            return FALSE;
    } else
        return FALSE;
}

function isFileFolder($www) {
    if (strpos($www, 'dropbox.com/sh/') > 0) {
        $homepage = file_get_contents($www);
        if (strpos($homepage, 'nonempty-folder') > 0 || strpos($homepage, 'nonmedia-folder') > 0 || strpos($homepage, 'empty-folder') > 0)
            return TRUE;
        else
            return FALSE;
    } else
        return FALSE;
}

function getFolderLink($url) {
    $homepage = file_get_contents($url);
    $start = strpos($homepage, 'Name</div>');
    $stop = strpos($homepage, 'Flag for copyright');
    $text = substr($homepage, $start, $stop - $start);
    $regexp = "<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>(.*)<\/a>";
    if (preg_match_all("/$regexp/siU", $text, $matches, PREG_SET_ORDER)) {
        $linki = array();
        $tmp = array();
        $sizeArray = sizeof($matches);
        for ($i = 0; $i < $sizeArray; $i++) {
            if (strpos(trim($matches[$i][2]), '/sh/')) {
                array_push($tmp, $matches[$i][2]);
            }
        }
        $tmp = array_values(array_unique($tmp));
        foreach ($tmp as $match) {
            set_time_limit(360);
            $machMod = substr($match, strrpos($match, '/') + 1);
            if (strpos($machMod, '.') > 0) {
                array_push($linki, $match);
            }
        }
        return $linki;
    } else {
        return false;
    }
}

function checkLink($www) {
    if (strpos($www, 'dropbox.com/') > 0)
        return TRUE;
    else
        return FALSE;
}

function insertInput($str) {
    $str = str_replace('"', '&quot;', $str);
    $tekst = '<input class="form-control" type="text" value="' . $str . '" onClick="this.select();" readonly size=30>';
    return $tekst;
}

function isImageUrl($str) {
    $extensionsArray = array('jpg', 'jpeg', 'png', 'gif', 'bmp');
    $str = substr($str, strrpos($str, ".") + 1);
    if (in_array($str, $extensionsArray)) {
        return true;
    } else {
        return false;
    }
}

if (!empty($_POST['dropbox_url'])) {
    set_time_limit(180);
    $rawurlAll = array();
    $bbimgAll = array();
    $bburlAll = array();
    $htmlimgAll = array();
    $htmlaAll = array();
    $urlTab = nl2br($_POST['dropbox_url']);
    $urlTab = explode('<br />', $urlTab);
    $links = array();
    $unikalne = array();
    foreach ($urlTab as $value) {
        $value = trim($value);

        if (!in_array($value, $unikalne)) {
            array_push($unikalne, $value);
        } else {
            continue;
        }

        $max = 1;
        $folder = false;
        if (!empty($value) && checkLink($value)) {
            if (isFolder($value)) {
                $links = getFolderLink($value);
                if (empty($links)) {
                    continue;
                }
                $max = count($links);
                set_time_limit($max * 5 + 120);
                $folder = true;
            }


            for ($i = 0; $i < $max; $i++) {
                if ($folder == true)
                    $value = $links[$i];
                $tmpUrl = str_replace('dropbox.com', 'dl.getdropbox.com', $value);
                $tmpUrl = str_replace('www.', '', $tmpUrl);
                $tmpUrl = str_replace('?dl=0?lst', '', $tmpUrl);
                $url = htmlspecialchars(str_replace('?dl=0', '', $tmpUrl));
                $fileName = htmlspecialchars(urldecode(substr($url, strrpos($url, "/") + 1)));
                //--------------------------------
                $notAllAinks = (isset($_POST['bbimg']) && $_POST['bbimg'] == true || isset($_POST['bburl']) && $_POST['bburl'] == true || isset($_POST['htmlimg']) && $_POST['htmlimg'] == true || isset($_POST['htmla']) && $_POST['htmla'] == true || isset($_POST['raw']) && $_POST['raw'] == true);
                if ($notAllAinks)
                    echo('<div class="form-group"><span class="glyphicon glyphicon-file"></span> <label>File name: <a href="' . $url . '"><i>' . $fileName . '</i></a></label><br>');
                if (isset($_POST['raw']) && $_POST['raw'] == true)
                    echo('RAW URL: ' . insertInput($url) . '');

                array_push($rawurlAll, $url);

                $bbimg = '[img]' . $url . '[/img]';
                $bburl = "[url=$url]" . $fileName . "[/url]";
                $htmlimg = "<img src=\"$url\">";
                $htmla = "<a href=\"$url\">" . $fileName . "</a>";
                if (isImageUrl($url)) {
                    array_push($bbimgAll, trim($bbimg));
                    array_push($bburlAll, trim($bburl));
                    array_push($htmlimgAll, trim($htmlimg));
                    array_push($htmlaAll, trim($htmla));
                    if (isset($_POST['bbimg']) && $_POST['bbimg'] == true)
                        echo('BBCode img: ' . insertInput($bbimg));
                    if (isset($_POST['bburl']) && $_POST['bburl'] == true)
                        echo('BBCode url: ' . insertInput($bburl));
                    if (isset($_POST['htmlimg']) && $_POST['htmlimg'] == true)
                        echo('HTML img: ' . insertInput($htmlimg));
                    if (isset($_POST['htmla']) && $_POST['htmla'] == true)
                        echo('HTML a: ' . insertInput($htmla));
                } else {
                    array_push($bburlAll, trim($bburl));
                    array_push($htmlaAll, trim($htmla));
                    if (isset($_POST['bburl']) && $_POST['bburl'] == true)
                        echo('BBCode URL: ' . insertInput($bburl));
                    if (isset($_POST['htmla']) && $_POST['htmla'] == true)
                        echo('HTML URL: ' . insertInput($htmla));
                }
                if ($notAllAinks)
                    echo('</div><hr>');
            }
        }
    }
} else {
    echo('<div class="alert alert-danger"><strong>Error!</strong> Link not found!</div>');
}
if (isset($_POST['allurl']) && $_POST['allurl'] == true && count($rawurlAll) > 0) {
    echo('<a name="all_link"></a><span class="glyphicon glyphicon-copy"></span> <b>All links:</b><br><pre>');

    if (!empty($rawurlAll))
        foreach ($rawurlAll as $value) {
            echo htmlspecialchars(str_replace('\r\n', '', trim($value))) . '<br>';
        }
    echo('<br>');

    foreach ($htmlaAll as $value) {
        echo htmlspecialchars(str_replace('\r\n', '', trim($value))) . '<br>';
    }
    echo('<br>');
    foreach ($bburlAll as $value) {
        echo htmlspecialchars(str_replace('\r\n', '', trim($value))) . '<br>';
    }
    echo('<br>');
    foreach ($bbimgAll as $value) {
        echo htmlspecialchars(str_replace('\r\n', '', trim($value))) . '<br>';
    }
    echo('<br>');
    foreach ($htmlimgAll as $value) {
        echo htmlspecialchars(str_replace('\r\n', '', trim($value))) . '<br>';
    }

    echo('</pre>');
}
echo('<a href="index" class="btn btn-info" role="button">Back</a>');
$time_end = microtime(true);
$execution_time = ($time_end - $time_start);
//echo '<b>Total Execution Time:</b> ' . $execution_time . ' s';
?>