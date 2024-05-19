<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="game.css">
    <title>Mini Question</title>
</head>

<body>
    <div class="game">
        <div class="img">
            <img src="image1.png" alt="" class="image-1">

           
            <form action="proses_game.php" method="post" id="gameForm">
                <input type="hidden" name="start_time" value="<?php echo time(); ?>">
                <h1>Mini Game Math</h1>
                function calculateIntegerPlusInteger(A, B) {<br>

                const intValueA = parseInt(A);<br>
                const intValueB = parseInt(B); <br>

                if (isNaN(intValueA) || isNaN(intValueB)) {<br>
                return "A or B is not a valid integer.";<br>
                }<br>

                // Calculate the result<br>
                const result = intValueA + intValueB;<br>

                return result;<br>
                }<br>

                const integerA = 10;<br>
                const integerB = 5; <br>

                const hasil = calculateIntegerPlusInteger(integerA, integerB);<br>
                console.log(hasil); <br>

                <label for="answer">berapa hasilnya</label>
                <input type="text" id="answer" name="answer">
                <button type="submit">Submit</button>
            </form>
            <img src="image3.png" alt="" class="image-2">
        </div>

    </div>

</body>

</html>