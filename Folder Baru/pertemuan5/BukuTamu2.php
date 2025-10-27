<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Output Komentar</title>
    <style>
        /* Gaya dasar untuk output */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 650px;
            margin: 0 auto;
            padding: 25px;
            background-color: white;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #007bff;
            border-bottom: 2px solid #ccc;
            padding-bottom: 10px;
        }

        h2 {
            color: #333;
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        td {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }

        .label {
            font-weight: bold;
            width: 30%;
            color: #007bff;
        }

        .value {
            color: #333;
        }

        .komentar-box {
            border: 1px dashed #28a745;
            padding: 15px;
            background-color: #e6ffe6;
            margin-top: 10px;
            white-space: pre-wrap;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Hasil Input Komentar</h1>

        <?php
        // Cek apakah data dikirimkan melalui metode POST
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            // Mengambil dan membersihkan data dari form
            // htmlspecialchars() digunakan untuk mencegah Cross-Site Scripting (XSS)
            $nama = isset($_POST['nama']) ? htmlspecialchars($_POST['nama']) : 'Data Nama Tidak Ditemukan';
            $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : 'Data Email Tidak Ditemukan';
            $komentar = isset($_POST['komentar']) ? htmlspecialchars($_POST['komentar']) : 'Data Komentar Tidak Ditemukan';

            // Tampilkan data yang diterima
            echo "<h2>Data yang Anda Masukkan:</h2>";
            echo "<table>";
            echo "<tr><td class='label'>Nama Anda</td><td>:</td><td class='value'>$nama</td></tr>";
            echo "<tr><td class='label'>Email Anda</td><td>:</td><td class='value'>$email</td></tr>";
            echo "</table>";

            echo "<h2>Isi Komentar:</h2>";
            echo "<div class='komentar-box'>$komentar</div>";
        } else {
            // Jika file diakses langsung tanpa mengirim form
            echo "<p style='color: red; text-align: center;'>Akses tidak sah. Silakan isi formulir di halaman sebelumnya.</p>";
        }
        ?>

        <a href="BukuTamu.php" class="back-link">← Kembali ke Form Input</a>

    </div>

</body>

</html>