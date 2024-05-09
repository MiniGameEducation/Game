
<?php

include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $userAnswer = $_POST['answer'];

 
    $correctAnswer = 15;
    if ($userAnswer == $correctAnswer) {
        echo "Congratulations! Your answer is correct!";
    } else {
        echo "Sorry, your answer is incorrect. Please try again!";
    }


    if(isset($_COOKIE['user_id'])){
        $userId = $_COOKIE['user_id'];
        $gameData = "Game data to be saved"; 
       
        $sql = "REPLACE INTO Autosave (user_id, game_data) VALUES ('$userId', '$gameData')";

        if ($conn->query($sql) === TRUE) {
            echo "Game saved successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "User is not logged in.";
    }
}
?>
