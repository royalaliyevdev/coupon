<?php
require '../config.php';

$name = $_POST['name'];

$sql = "INSERT INTO stores (name) VALUES ('$name')";
if ($conn->query($sql) === TRUE) {
    echo "New store created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
header("Location: add_store.php");
exit;
?>
<?php
