<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Add Store</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Add Store</h2>
    <form action="submit_store.php" method="post">
        <div class="form-group">
            <input type="text" class="form-control" id="name" name="name" placeholder="Store Name" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Store</button>
    </form>
    <div class="mt-4">
        <a href="list_stores.php" class="btn btn-secondary">View Stores</a>
    </div>
</div>
</body>
</html>
