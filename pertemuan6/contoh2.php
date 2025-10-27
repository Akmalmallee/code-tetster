<html>

<head>
    <title>Data Mahasiswa</title>
</head>

<body>
    <?php
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $jk = $_POST['jk'];
    $pekerjaan = $_POST['pekerjaan'];
    $hobi1 = $_POST['hobi1'];
    $hobi2 = $_POST['hobi2'];
    $hobi3 = $_POST['hobi3'];
    ?>
    <table border=1 bgcolor="cyan">
        <tr>
            <
                <td cosplan="2" align="center"><b>DATA MAHASISWA</b></td>
        </tr>
        <tr>
            <td>Nama</td>
            <td><?php echo $nama; ?></td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td><?php echo $alamat; ?></td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td><?php echo $jk; ?></td>
        </tr>
        <tr>
            <td>Pekerjaan</td>
            <td><?php echo $pekerjaan; ?></td>
        </tr>
        <tr>
            <td>Hobi</td>
            <td>
                <?php
                if (isset($hobi1)) {
                    echo $hobi1 . " ";
                }
                if (isset($hobi2)) {
                    echo $hobi2 . " ";
                }
                if (isset($hobi3)) {
                    echo $hobi3 . " ";
                }
                ?>
            </td>
        </tr>

    </table>
    <a href="contoh1.php">Kembali</a>
</body>

</html>