<?php
include "../database/koneksi.php";


if (!isset($_SESSION['id'])) {
    echo "Anda harus login terlebih dahulu.";
    exit();
}

$id = $_SESSION['id'];

// Mengambil data dari database berdasarkan ID user yang login
$query = "SELECT * FROM user WHERE id='$id'";
$hasil = mysqli_query($conn, $query);

if ($data = mysqli_fetch_array($hasil)) {
?>
    <form method="post" action="proses_profile.php" class="profile" enctype="multipart/form-data">
        <div class="img-profile">
            <img src="<?php echo "" . $data['foto']; ?>" alt="Profile Picture" width="100==" height="100">
        </div>
        <div class="profile-txt">
            <input type="text" value="<?php echo $data['username'] ?>" readonly>
            <input type="text" value="<?php echo $data['score'] ?>" readonly>
        </div>
    </form>
<?php
} else {
    echo "Data user tidak ditemukan.";
}
?>