<div class="user-table">
    <div class="table-body">
        <form action="../database/update.php" method="post">    
            <h1 class="judul">Kelola Pengguna</h1>        
            <div class="checkbox-container">
                <button type="submit" name="delete" class="delete-button">Delete</button>
            </div>
            <table>
                <tr>
                    <th><input type="checkbox" id="select_all" class="checkbox"></th>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Skor</th>
                    <th>Picture</th>
                </tr>
                <?php
                include "../database/koneksi.php";
                $sql = "SELECT id, username, email, password, score, foto FROM user";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td><input type='checkbox' name='user_ids[]' value='" . $row["id"] . "' class='user_checkbox'></td>";
                        echo "<td><input type='text' name='id[]' class='input_id' value='" . $row["id"] . "' readonly></td>";
                        echo "<td><input type='text' name='username[]' class='input_text' value='" . $row["username"] . "'></td>";
                        echo "<td><input type='email' name='email[]' class='input_text' value='" . $row["email"] . "'></td>";
                        echo "<td><input type='text' name='password[]' class='input_text' value='" . $row["password"] . "'></td>";
                        echo "<td><input type='text' name='score[]' class='input_text' value='" . $row["score"] . "'></td>";
                        echo "<td><img src='" . $row["foto"] . "'><input type='hidden' name='foto[]' value='" . $row["foto"] . "'></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No users found</td></tr>";
                }
                ?>
            </table>

        </form>
    </div>
</div>
