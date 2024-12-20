<?php
session_start();
include "../../../utils/isNotLoggedIn.php";
include "../../../utils/koneksi.php";

$rootDirectory = "/unikma";

// Mengambil ID dari URL (misalnya ?id=1)
if (isset($_GET['id'])) {
    $id_ukm = mysqli_real_escape_string($conn, $_GET['id']);
    
    // Query untuk mendapatkan data UKM berdasarkan ID
    $query = "SELECT * FROM ukm WHERE id_ukm = '$id_ukm'";
    $result = mysqli_query($conn, $query);
    
    // Jika data ditemukan, isi form dengan data tersebut
    if (mysqli_num_rows($result) > 0) {
        $ukm = mysqli_fetch_assoc($result);
        $nama_ukm = $ukm['nama_ukm'];
        $deskripsi = $ukm['deskripsi'];
        $ketua_ukm = $ukm['ketua_ukm'];
        $kontak = $ukm['kontak'];
    }
} else {
    // Jika tidak ada ID yang dikirimkan, arahkan ke halaman lain
    echo "<script>alert('ID UKM tidak ditemukan.'); window.location.href='" . $rootDirectory . "';</script>";
}

// Menangani proses form submission (untuk edit)
if (isset($_POST["submit"])) {
    $nama_ukm = mysqli_real_escape_string($conn, $_POST['nama']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $ketua_ukm = mysqli_real_escape_string($conn, $_POST['ketua']);
    $kontak = mysqli_real_escape_string($conn, $_POST['kontak']); 

    // Query untuk update data UKM berdasarkan ID
    $query = "UPDATE ukm SET nama_ukm = '$nama_ukm', deskripsi = '$deskripsi', ketua_ukm = '$ketua_ukm', kontak = '$kontak' WHERE id_ukm = '$id_ukm'";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data UKM berhasil diperbarui!'); window.location.href='" . $rootDirectory . "';</script>";
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
                        <label for="nama">Nama UKM:</label>
                        <input type="text" name="nama" value="<?php echo isset($nama_ukm) ? $nama_ukm : ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi:</label>
                        <input type="text" name="deskripsi" value="<?php echo isset($deskripsi) ? $deskripsi : ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="ketua">Ketua:</label>
                        <select name="ketua" id="ketua" required>
                            <option value="">Pilih Ketua</option>
                            <?php
                            // Query untuk mendapatkan data users
                            $query = "SELECT * FROM users";
                            $users = mysqli_query($conn, $query);
                            while ($row = mysqli_fetch_assoc($users)) {
                                $selected = ($row['id_user'] == $ketua_ukm) ? 'selected' : '';
                                echo '<option value="' . $row['id_user'] . '" ' . $selected . '>' . $row['nama'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="kontak">Kontak:</label>
                        <input type="text" name="kontak" value="<?php echo isset($kontak) ? $kontak : ''; ?>" required>
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
