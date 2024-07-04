<?php
// Pastikan hanya request method POST yang diterima
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete']) && isset($_POST['user_ids'])) {
    // Include file koneksi database
    include "../database/koneksi.php";

    // Validasi data input
    $user_ids = $_POST['user_ids'];
    if (!empty($user_ids) && is_array($user_ids)) {
        // Escape input untuk menghindari SQL injection
        $safe_user_ids = array_map('intval', $user_ids);

        // Gabungkan ID pengguna yang aman menjadi string terpisah dengan koma untuk query
        $user_ids_string = implode(",", $safe_user_ids);

        // Mulai transaksi
        $conn->begin_transaction();

        try {
            // Hapus data di tabel autosave terlebih dahulu
            $delete_autosave_sql = "DELETE FROM autosave WHERE user_id IN ($user_ids_string)";
            if (!$conn->query($delete_autosave_sql)) {
                throw new Exception("Error deleting autosave data: " . $conn->error);
            }

            // Hapus data di tabel user
            $delete_user_sql = "DELETE FROM user WHERE id IN ($user_ids_string)";
            if (!$conn->query($delete_user_sql)) {
                throw new Exception("Error deleting users: " . $conn->error);
            }

            // Commit transaksi
            $conn->commit();
            // Redirect kembali ke halaman sebelumnya atau halaman sukses
            header("Location: ../admin/admin.php");
            exit();
        } catch (Exception $e) {
            // Rollback transaksi jika terjadi kesalahan
            $conn->rollback();
            echo $e->getMessage();
        }
    } else {
        // Tampilkan pesan jika tidak ada pengguna yang dipilih
        echo "No users selected for deletion.";
    }

    // Tutup koneksi database
    $conn->close();
} else {
    // Jika bukan request method POST atau tidak ada 'delete' dalam POST, redirect atau tampilkan pesan sesuai kebutuhan
    echo "Invalid request method or missing parameters.";
}
?>
