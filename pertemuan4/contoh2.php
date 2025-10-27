<?php
$show_quiz = false;
$hasil = "";

if (isset($_POST['masuk'])) {
    $show_quiz = true;
}

if (isset($_POST['jawaban'])) {
    if ($_POST['jawaban'] === "4") {
        $hasil = "<h2 style='color:lightgreen;'>Benar! Kamu selamat 😎</h2>
                  <img src='https://www.google.com/imgres?q=jokowi&imgurl=https%3A%2F%2Fupload.wikimedia.org%2Fwikipedia%2Fcommons%2Fthumb%2Fb%2Fbe%2FJoko_Widodo_2019_official_portrait.jpg%2F250px-Joko_Widodo_2019_official_portrait.jpg&imgrefurl=https%3A%2F%2Fid.wikipedia.org%2Fwiki%2FJoko_Widodo&docid=0erImBKMv8y1MM&tbnid=fPS63SzLCCvjyM&vet=12ahUKEwjN5KjniqSQAxXAyjgGHWFWK9AQM3oECBgQAA..i&w=250&h=301&hcb=2&ved=2ahUKEwjN5KjniqSQAxXAyjgGHWFWK9AQM3oECBgQAA' width='300'>"; // Gambar selamat
    } else {
        $hasil = "<h2 style='color:red;'>Salah! Kamu kena kutuk 👹</h2>
                  <img src='memeowi.jpg width='300'>"; // Gambar setan
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Quiz Horor</title>
    <style>
        body {
            text-align: center;
            font-family: Arial;
            background: #111;
            color: white;
            margin-top: 100px;
        }

        button,
        input {
            padding: 10px 20px;
            font-size: 18px;
        }
    </style>
</head>

<body>

    <?php if (!$show_quiz && $hasil == ""): ?>
        <!-- HALAMAN MASUK -->
        <h1>Selamat Datang</h1>
        <form method="POST">
            <button type="submit" name="masuk">Masuk</button>
        </form>

    <?php elseif ($show_quiz): ?>
        <!-- HALAMAN QUIZ -->
        <h2>Jawab dulu pertanyaan ini</h2>
        <p>siapa kah yang melakukan perjalanan dari indonesia ke cina menggunakan sepedah?</p>
        <form method="POST">
            <input type="text" name="jawaban" required>
            <button type="submit">Jawab</button>
        </form>

    <?php else: ?>
        <!-- HASIL -->
        <?= $hasil ?>
    <?php endif; ?>

</body>

</html>