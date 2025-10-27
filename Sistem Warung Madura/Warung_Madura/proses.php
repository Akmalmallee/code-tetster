<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST["nama"];
    $telepon = $_POST["telepon"];
    $alamat = $_POST["alamat"];
    $barang = $_POST["barang"];
    $jumlah = $_POST["jumlah"];
    $harga = $_POST["harga"];
    $total = $jumlah * $harga;

    $data = "$nama | $telepon | $alamat | $barang | $jumlah | $harga | $total\n";
    file_put_contents("data.txt", $data, FILE_APPEND);

    echo "<script>alert('Data berhasil disimpan!');window.location='data.php';</script>";
}
