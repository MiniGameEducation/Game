<?php
session_start();
session_unset();
session_destroy();
<<<<<<< HEAD
header("Location:../index.php"); // Redirect ke halaman login setelah logout
=======
echo "<script>
alert('Anda telah Logout');
window.location.href='../index.php';
</script>";
>>>>>>> nizar
exit();
?>
