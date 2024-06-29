<div class="user-table">
        <div class="table-body">
            <form action="../database/delete.php" method="post">
                <table>
                    <tr>
                        <th><input type="checkbox" id="select_all" class="checkbox"></th>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Skor</th>
                        <th>Picture</th>
                    </tr>
                    <?php
                    include "../database/koneksi.php";
                    $sql = "SELECT id, username, email, score, foto FROM user";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td><input type='checkbox' name='user_ids[]' value='" . $row["id"] . "' class='user_checkbox'></td>";
                            echo "<td>" . $row["id"] . "</td>";
                            echo "<td>" . $row["username"] . "</td>";
                            echo "<td>" . $row["email"] . "</td>";
                            echo "<td>" . $row["score"] . "</td>";
                            echo "<td><img src='" . $row["foto"] . "'></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No users found</td></tr>";
                    }
                    ?>
                </table>
                <div class="checkbox-container">
                    <button type="submit" name="delete" class="delete-button">Delete</button>
                </div>
            </form>
        </div>
    </div>