<html>

<head>
    <title>input data mahasiswa</title>
</head>

<body bgcolor="green">
    <form action="contoh2.php" method="post">
        <b>pengolaan data mahasiswa</b>
        <br>
        <pre>
            Nama     : <input type="text" name="nama" size="25"maxlength="25">
            Alamat   : <input type="text" name="alamat" size="50" maxlength="50">
            </pre>
        Jenis Kelamin :
        <input type="radio" name="jk" value="Laki-laki">Laki-laki
        <input type="radio" name="jk" value="Perempuan">Perempuan
        <p>
            Pekerjaan :
            <select name="pekerjaan">
                <option value="Pelajar">Pelajar</option>
                <option value="Mahasiswa">Mahasiswa</option>
                <option value="Karyawan Swasta">Karyawan Swasta</option>
                <option value="PNS">PNS</option>
                <option value="Wiraswasta">Wiraswasta</option>
            </select>
        </p>
        <p>
            Hobi :
            <input type="checkbox" name="hobi1" value="Olahraga"> Olahraga
            <input type="checkbox" name="hobi2" value="Musik"> Musik
            <input type="checkbox" name="hobi3" value="Jalan-Jalan"> Jalan-Jalan
        <p>
            <input type="submit" value="Kirim">
            <input type="reset" value="Batal">
        </p>
    </form>
</body>

</html>

</html>