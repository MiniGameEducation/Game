<?php
// Enable error reporting for debugging purposes
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../database/koneksi.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Ensure user is logged in
if (!isset($_SESSION["id"])) {
    die("User is not logged in.");
}

$user_id = $_SESSION["id"];

// Check if a category is selected
if (isset($_GET['kategori_id']) && isset($_GET['level_id'])) {
    $kategori_id = $_GET['kategori_id'];
    $level_id = $_GET['level_id'];

    // Update the last_selected_kategori_id in the user table
    $sql = "UPDATE user SET last_selected_kategori_id = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $kategori_id, $user_id);
    if (!$stmt->execute()) {
        die("Failed to update last selected category: " . $stmt->error);
    }

    // Redirect to the game page with selected category and level
    header("Location: mainMenu.php?kategori_id=$kategori_id&level_id=$level_id");
    exit;
}

// Fetch categories and user progress from the database
$sql = "
    SELECT k.kategori_id, k.kategori, COALESCE(MAX(up.level_id), 1) AS level_id
    FROM kategori k
    LEFT JOIN autosave up ON k.kategori_id = up.kategori_id AND up.user_id = ?
    GROUP BY k.kategori_id, k.kategori
";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    die("Query failed: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href="img/Ratsel.png" />
    <link rel="stylesheet" href="kategori.css">
    <link rel="icon" type="image/x-icon" href="../img/Ratsel.png" />
    <title>Pilih Kategori</title>
</head>
<body>
<h1>Pilih Kategori</h1>
    <ul class="category-list">
        <?php while ($row = $result->fetch_assoc()): ?>
            <li class="category-item">
                <a href="?kategori_id=<?php echo $row['kategori_id']; ?>&level_id=<?php echo $row['level_id']; ?>">
                    <?php echo htmlspecialchars($row['kategori']); ?>
                </a>
            </li>
        <?php endwhile; ?>
    </ul>
</body>
</html>
