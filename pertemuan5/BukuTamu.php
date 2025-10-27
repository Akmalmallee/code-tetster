<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Komentar - BUKU TAMU</title>
    <style>
        /* Gaya dasar agar tampilan menyerupai contoh */
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
        }

        .subtitle {
            text-align: center;
            margin-bottom: 20px;
            color: #555;
            border-collapse: collapse;
        }

        td {
            padding: 8px 0;
            vertical-align: top;
        }

        input[type="text"],
        input[type="email"],
        textarea {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ddd;
            border-radius: 3px;
        }

        textarea {
            resize: vertical;
            height: 100px;
        }

        .input-label {
            width: 25%;
            font-weight: bold;
        }

        .separator {
            width: 5%;
        }

        .buttons {
            text-align: left;
            padding-top: 15px;
        }

        .buttons input {
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px;
        }

        .buttons input[type="submit"] {
            background-color: #28a745;
            color: white;
        }

        .buttons input[type="reset"] {
            background-color: #6c757d;
            color: white;
        }
    </style>
</head>

<body>

    <div class="container">
        <center>
            <img src="logo_bsi.png" alt="Logo Universitas" style="width: 50px; margin-bottom: 10px;">
        </center>
        <h1>BUKU TAMU</h1>
        <p class="subtitle">Komentar dan Saran Anda Sangat Kami Butuhkan Untuk Meningkatkan Kualitas Situs Kami</p>

        <form action="BukuTamu2.php" method="post">
            <table>
                <tr>
                    <td class="input-label">Nama Anda</td>
                    <td class="separator">:</td>
                    <td>
                        <input type="text" name="nama" placeholder="Bintang Galaxy" required>
                    </td>
                </tr>
                <tr>
                    <td class="input-label">Email Anda</td>
                    <td class="separator">:</td>
                    <td>
                        <input type="email" name="email" placeholder="bintang@gmail.com" required>
                    </td>
                </tr>
                <tr>
                    <td class="input-label">Komentar Anda</td>
                    <td class="separator">:</td>
                    <td>
                        <textarea name="komentar" placeholder="Webnya bagus, bisa ditambahkan konten lain yang menarik" required></textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <div class="buttons">
                            <input type="submit" value="Kirim">
                            <input type="reset" value="Batal">
                        </div>
                    </td>
                </tr>
            </table>
        </form>
    </div>

</body>

</html>