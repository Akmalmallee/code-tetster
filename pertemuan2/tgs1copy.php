<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Daftar Produk</title>
    <style>
        body {
            font-family: "Arial", sans-serif;
            /* Font default halaman */
            color: #000;
            /* Warna tulisan default */
        }

        table {
            border-collapse: collapse;
            width: 700px;
            margin: 20px auto;
            border: 1px solid black;
            font-family: "Times New Roman", serif;
            /* Font khusus tabel */
            color: #000;
            /* Warna font di tabel */
        }

        caption {
            background-color: moccasin;
            font-weight: bold;
            padding: 8px 0;
            font-size: 1.2rem;
            border: 1px solid black;
            color: darkblue;
            /* Warna font caption */
            font-family: "Georgia", 'Courier New', Courier, monospace;
        }

        td,
        th {
            border: 1px solid black;
            padding: 6px 8px;
            vertical-align: top;
            font-size: 0.95rem;
        }

        .left-col {
            background-color: #fff9b0;
            width: 180px;
            text-align: center;
            color: #333333;
            /* Warna font kolom kiri */
            font-style: italic;
            /* Contoh style font */
        }

        .left-col img {
            width: 100%;
            height: 100;
            object-fit: cover;
            max-height: 200px;
        }

        .label-cell {
            background-color: #32cd32;
            width: 120px;
            font-weight: bold;
            text-align: left;
            padding-left: 10px;
            font-size: 0.9rem;
            line-height: 1.4;
            color: white;
            /* Warna font label */
            font-family: "Verdana", sans-serif;
        }

        .info-cell {
            background-color: violet;
            font-size: 0.9rem;
            line-height: 1.4;
            color: black;
            /* Warna font isi */
            font-family: "Calibri", sans-serif;
        }

        ul {
            margin: 0;
            padding-left: 20px;
        }
    </style>
</head>

<body>
    <table>
        <caption>DAFTAR PRODUK</caption>
        <tbody>
            <tr>
                <td class="left-col" rowspan="4">
                    <img src="pikachu canon.jpg" />
                </td>
                <td class="label-cell">Nama Produk</td>
                <td class="info-cell">Canon EOS M10 Kit EF-M 15-45mm</td>
            </tr>
            <tr>
                <td class="label-cell">Harga</td>
                <td class="info-cell">Rp 4,899,000</td>
            </tr>
            <tr>
                <td class="label-cell" rowspan="2">Fitur Produk</td>
                <td class="info-cell">
                    <ul>
                        <li>Kamera mirrorless</li>
                        <li>Efektifitas Piksel : 18 MP</li>
                        <li>Tipe sensor : CMOS DIGIC 6</li>
                        <li>Layar : 3.0 Inch</li>
                        <li>Memiliki lampu flash dengan jarak jangkauan hingga 5 meter</li>
                    </ul>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>