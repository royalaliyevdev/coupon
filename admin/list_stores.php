<?php
include '../resources/views/admin/header.php';
?>
    <h2>List of Stores</h2>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Store ID</th>
            <th>Store Name</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php
        require '../config.php';
        $sql = "SELECT * FROM stores";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td><form action='delete_store.php' method='post' style='display:inline;'>
                              <input type='hidden' name='store_id' value='uponButton" . $row['id'] . "'>
                              <button type='submit' class='btn btn-danger'>Delete</button>
                          </form></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No stores found.</td></tr>";
        }
        ?>
        </tbody>
    </table>
    <a href="add_store.php" class="btn btn-primary uponButton">Add New Store</a>

<?php include '../resources/views/admin/footer.php'; ?>
