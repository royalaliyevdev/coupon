<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XML Import</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1>Import XML to Database</h1>
    <form action="process_xml.php" method="POST">
        <div class="form-group">
            <label for="xmlUrl">Enter XML URL:</label>
            <input type="text" name="xmlUrl" id="xmlUrl" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Process XML</button>
    </form>
</div>
<script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>
