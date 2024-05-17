<?php
include "/xampp2/htdocs/Game/main_menu/database/koneksi.php";

// Mengambil data dari database
$query = "SELECT * FROM profile";
$hasil = mysqli_query($conn, $query);

if ($data = mysqli_fetch_array($hasil)) {
    ?>
    <form method="post" action="proses_profile.php" class="profile" enctype="multipart/form-data">
        <div class="img-profile">
            <img src="<?php echo $data['foto']; ?>" alt="" width="100" height="100">
        </div>
    </form>
    <?php
}
?>
