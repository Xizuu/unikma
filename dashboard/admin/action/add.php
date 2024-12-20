<?php
session_start();
include "../../../utils/isNotLoggedIn.php";
include "../../../utils/koneksi.php";

$query = "SELECT * FROM users";
$users = mysqli_query($conn, $query);

$rootDirectory = "/unikma";

if (isset($_POST["submit"])) {
    $nama_ukm = mysqli_real_escape_string($conn, $_POST['nama']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $ketua_ukm = mysqli_real_escape_string($conn, $_POST['ketua']);
    $kontak = mysqli_real_escape_string($conn, $_POST['kontak']); 

    $query = "INSERT INTO ukm (nama_ukm, deskripsi, ketua_ukm, kontak) 
              VALUES ('$nama_ukm', '$deskripsi', '$ketua_ukm', '$kontak')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data UKM berhasil disimpan!'); window.location.href='" . $rootDirectory . "';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unit Kreativitas Mahasiswa</title>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anek+Devanagari:wght@100..800&family=Play:wght@400;700&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div id="template">

        <div id="content-wrapper">
            <div id="content">
                <h1 style="text-align: center;">Tambah UKM</h1>
                <form method="post" id="login-form">
                    <div class="form-group">
                        <label for="username">Nama:</label>
                        <input type="text" name="nama">
                    </div>
                    <div class="form-group">
                        <label for="password">Deskripsi:</label>
                        <input type="text" name="deskripsi">
                    </div>
                    <div class="form-group">
                        <label for="ketua">Ketua:</label>
                        <select name="ketua" id="ketua">
                            <option value="">Pilih Ketua</option>
                            <?php
                            while ($row = mysqli_fetch_assoc($users)) {
                                echo '<option value="' . $row['id_user'] . '">' . $row['nama'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="password">Kontak:</label>
                        <input type="text" name="kontak">
                    </div>
                    <div class="form-group">
                        <input type="submit" name="submit" value="Submit">
                    </div>
                </form>
            </div>
        </div>
    </div>   
</body>
</html>
