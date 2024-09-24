<?php
$mysqli = new mysqli("localhost", "root", "", "royalaliyev");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Slider öğelerini çekme
$result = $mysqli->query("SELECT * FROM sliders");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slider Yönetimi</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Admin Panel</a>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Ana Sayfa</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="slider_edit.php">Slider Yönetimi</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container mt-4">
    <h2>Slider Yönetimi</h2>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Başlık</th>
            <th>Görsel</th>
            <th>Aksiyon</th>
        </tr>
        </thead>
        <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['title']; ?></td>
                <td><img src="images/<?php echo $row['image']; ?>" alt="Slider Image" width="100"></td>
                <td>
                    <a href="edit_slider.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">Düzenle</a>
                    <a href="delete_slider.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">Sil</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$mysqli->close();
?>
