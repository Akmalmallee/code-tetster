<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Pendapatan</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
</head>

<body>
    <div class="container">
        <h2>Form Pendapatan Warung Madura</h2>
        <form action="proses.php" method="POST" onsubmit="return validasiForm()">
            <label>Nama Pemilik:</label>
            <input type="text" name="nama" id="nama" required>

            <label>No. Telepon:</label>
            <input type="text" name="telepon" id="telepon" required>

            <label>Alamat:</label>
            <textarea name="alamat" id="alamat" required></textarea>

            <label>Nama Barang:</label>
            <input type="text" name="barang" id="barang" required>

            <label>Jumlah Terjual:</label>
            <input type="number" name="jumlah" id="jumlah" required>

            <label>Harga Satuan (Rp):</label>
            <input type="number" name="harga" id="harga" required>

            <button type="submit" class="btn">Simpan</button>
            <a href="data.php" class="btn secondary">Lihat Data</a>
        </form>
    </div>
</body>

</html>