<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{ MyPrez</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="neon.css">
    <script src="funkcjeCanvasJS.js"></script>
    <script src="funkcjeEdytorJS.js"></script>
    <script src="jquery-1.10.2.min.js"></script>
    <script src="funkcjePrezentacja.js"></script>
    <?php include('wczytaj.php'); ?>
</head>
<body style="background-color: #c0c0c0" onload="zaladujPrezentacje(obecnySlajd, 1)">
<header id="pasek-gorny">
    <h1>
        <spain style="color: #ec7224;">{</spain>
        MyPrez
    </h1>
</header>
<article>
    <center>
        <canvas id="myCanvas" width="480" height="380"></canvas>
    </center>
</article>
<footer id="pasek-dol">
    <p style="color: red">Slajd
        <spain id="obecny">0</spain>
        z
        <spain id="maxSlajd">0</spain>
    </p>

    <input type="submit" onclick="zaladujPrezentacje(obecnySlajd, 0)" value="poprzedni">
    <input type="submit" onclick="zaladujPrezentacje(obecnySlajd, 1)" value="nastepny">

</footer>
</body>
</html>

