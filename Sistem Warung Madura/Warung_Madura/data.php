<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pendapatan</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h2>Data Pendapatan Warung Madura</h2>
        <table>
            <tr>
                <th>Nama</th>
                <th>No. Telepon</th>
                <th>Alamat</th>
                <th>Barang</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Total</th>
            </tr>
            <?php
            if (file_exists("data.txt")) {
                $lines = file("data.txt", FILE_IGNORE_NEW_LINES);
                foreach ($lines as $line) {
                    echo "<tr>";
                    $cols = explode("|", $line);
                    foreach ($cols as $col) {
                        echo "<td>" . htmlspecialchars(trim($col)) . "</td>";
                    }
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>Belum ada data.</td></tr>";
            }
            ?>
        </table>
        <a href="form.php" class="btn">Kembali</a>
    </div>
</body>

</html>