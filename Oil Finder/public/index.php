<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Oil Finder</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container mt-5">
    <h1>Find the Right Oil</h1>
    <form id="oilFinderForm">
        <div class="form-group">
            <label for="brand">Brand</label>
            <select class="form-control" id="brand" name="brand" required></select>
        </div>
        <div class="form-group">
            <label for="model">Model</label>
            <select class="form-control" id="model" name="model" required></select>
        </div>
        <div class="form-group">
            <label for="year">Year</label>
            <select class="form-control" id="year" name="year" required></select>
        </div>
        <div class="form-group">
            <label for="engine">Engine</label>
            <select class="form-control" id="engine" name="engine" required></select>
        </div>
        <button type="submit" class="btn btn-primary">Find Oil</button>
    </form>
    <div id="result" class="mt-3"></div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="js/script.js"></script>
</body>
</html>
