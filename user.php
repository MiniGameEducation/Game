<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Level</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <a href="leaderboard.php">leaderboard</a>
    <div class="level-container">
        <?php
        
        for ($i = 1; $i <= 10; $i++) {
            
            $class = ($i == 10) ? 'level-card level-10' : 'level-card';
            
            if ($i == 1) {
                $class .= ' level-1';
                
                echo "<a href='game.html' class='$class'>";
            } else {
                
                echo "<div class='$class'>";
            }
        ?>
                <div>
                    <h2>Level <?php echo $i; ?></h2>
                    <p>Deskripsi level <?php echo $i; ?></p>
                </div>
        <?php 
         
            echo ($i == 1) ? "</a>" : "</div>";
        } 
        ?>
    </div>
</body>
</html>
