<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Daftar Produk</title>
    <style>
        table {
            border-collapse: collapse;
            width: 700px;
            margin: 20px auto;
            border: 1px solid black;
            font-family: serif;
        }

        caption {
            background-color: moccasin;
            font-weight: bold;
            padding: 8px 0;
            font-size: 1.2rem;
            border: 1px solid black;
        }

        td,
        th {
            border: 1px solid black;
            padding: 6px 8px;
            vertical-align: top;
        }

        .left-col {
            background-color: #fff9b0;
            /* pale yellow */
            width: 180px;
            text-align: center;
        }

        .left-col img {
            width: 100%;
            height: auto;
            object-fit: cover;
            max-height: 200px;
        }

        .label-cell {
            background-color: #ffee07ff;
            /* green */
            width: 120px;
            font-weight: normal;
            text-align: left;
            padding-left: 10px;
            font-size: 0.9rem;
            line-height: 1.4;
        }

        .info-cell {
            background-color: violet;
            font-size: 0.9rem;
            line-height: 1.4;
        }

        ul {
            margin: 0;
            padding-left: 20px;
        }
    </style>
</head>

<body>
    <table>
        <caption>Daftar Hero</caption>
        <tbody>
            <tr>
                <td class="left-col" rowspan="4">
                    <img src="prabowo.jpeg" />
                </td>
                <td class="label-cell">Nama Hero</td>
                <td class="info-cell">Prabowo S.</td>
            </tr>
            <tr>
                <td class="label-cell">Rolle</td>
                <td class="info-cell">Tank</td>
            </tr>
            <tr>
                <td class="label-cell" rowspan="2">Keahlian</td>
                <td class="info-cell">Joget joget gemoy
            </tr>
            <tr>
            <tr>
                <td class="label-cell">Pesan Rahasia</td>
                <td class="info-cell" colspan="2">
                    <audio controls>
                        <source src="hidup-jokowi.mp3" type="audio/mpeg">
                    </audio>
                </td>
            </tr>

            </ul>
            </td>
            </tr>
        </tbody>
    </table>

    <table>
        <caption>DAFTAR HERO</caption>
        <tbody>
            <tr>
                <td class="left-col" rowspan="4">
                    <img src="gus_miftah.jpg" />
                </td>
                <td class="label-cell">Nama Hero</td>
                <td class="info-cell">Gus Miftah</td>
            </tr>
            <tr>
                <td class="label-cell">Rolle</td>
                <td class="info-cell">Mage</td>
            </tr>
            <tr>
                <td class="label-cell" rowspan="2">Keahlian</td>
                <td class="info-cell">Public Enemy
                </td>
            </tr>
            <tr>
            <tr>
                <td class="label-cell">Pesan Rahasia</td>
                <td class="info-cell" colspan="2">
                    <audio controls>
                        <source src="hidup-lonte.mp3" type="audio/mpeg">
                    </audio>
                <td>
            </tr>
        </tbody>
    </table>
    <table>
        <caption>DAFTAR HERO</caption>
        <tbody>
            <tr>
                <td class="left-col" rowspan="4">
                    <img src="aripin.jpg" />
                </td>
                <td class="label-cell">Nama Hero</td>
                <td class="info-cell">Aripin tulip</td>
            </tr>
            <tr>
                <td class="label-cell">Rolle</td>
                <td class="info-cell">Fighter</td>
            </tr>
            <tr>
                <td class="label-cell" rowspan="2">Keahlian</td>
                <td class="info-cell">Dagang
                </td>
            </tr>
            <tr>
            <tr>
                <td class="label-cell">Pesan Rahasia</td>
                <td class="info-cell" colspan="2">
                    <audio controls>
                        <source src="hidup-lonte.mp3" type="audio/mpeg">
                    </audio>
                <td>
            </tr>
        </tbody>
</body>


</html>