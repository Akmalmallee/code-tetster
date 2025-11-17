<html>

<head>
    <title>Penggunaan Foreach</title>
</head>

<body>
    Menggunakan Foreach
    <br>
    <?php
    $warna = array("merah", "hijau", "kuning");
    foreach ($warna as $nilai) {
        echo "$nilai <br>";
    }
    ?>
</body>

</html>