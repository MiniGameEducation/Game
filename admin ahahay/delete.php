<?php
include "koneksi.php";

// Periksa apakah ada data yang dikirimkan dari form
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    if (isset($_POST['user_ids'])) {
        // Ambil data user_ids yang dikirimkan dari form
        $user_ids = $_POST['user_ids'];

        // Sanitasi data user_ids untuk menghindari serangan SQL Injection
        $sanitized_ids = array_map('intval', $user_ids);

        // Ubah array user_ids menjadi string yang dipisahkan oleh koma
        $ids = implode(",", $sanitized_ids);

        // Buat query DELETE untuk menghapus data dari tabel user berdasarkan id yang dipilih
        $sql = "DELETE FROM user WHERE id IN ($ids)";

        // Jalankan query DELETE
        if ($conn->query($sql) === TRUE) {
            echo "Record deleted successfully";
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    }
}

// Tutup koneksi
$conn->close();
?>
