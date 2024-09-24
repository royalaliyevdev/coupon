<?php
$mysqli = new mysqli("localhost", "username", "password", "database_name");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$id = $_GET['id'];

// Slider öğesini çekme
$result = $mysqli->query("SELECT * FROM sliders WHERE id=$id");
$slider = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $image = $_FILES['image']['name'];

    // Görseli yükleme
    if ($image) {
        move_uploaded_file($_FILES['image']['tmp_name'], "images/$image");
    } else {
        $image = $slider['image'];
    }

    // Slider öğesini güncelleme
    $mysqli->query("UPDATE sliders SET title='$title', image='$image' WHERE id=$id");

    header("Location: slider_edit.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slider Düzenle</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h2>Slider Düzenle</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Başlık</label>
            <input type="text" name="title" id="title" class="form-control" value="<?php echo $slider['title']; ?>" required>
        </div>
        <div class="form-group">
            <label for="image">Görsel</label>
            <input type="file" name="image" id="image" class="form-control">
            <img src="images/<?php echo $slider['image']; ?>" alt="Slider Image" width="100" class="mt-2">
        </div>
        <button type="submit" class="btn btn-success mt-3">Güncelle</button>
    </form>
</div>

<script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$mysqli->close();
?>
