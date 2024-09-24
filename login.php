<?php
require 'config.php';
require 'session_manager.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_type'] = $user['user_type'];
            $_SESSION['store_id'] = $user['store_id'];

            // Kullanıcı türüne göre yönlendirme
            switch ($user['user_type']) {
                case 'admin':
                    header("Location: admin/index.php");
                    break;
                case 'manager':
                    header("Location: manager/index.php");
                    break;
                case 'store':
                    header("Location: store/index.php");
                    break;
                default:
                    header("Location: login.php");
                    break;
            }
            exit();
        } else {
            $error = "Invalid password";
        }
    } else {
        $error = "User not found";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="manifest" href="/manifest.json">
    <title>Giriş</title>
<!--    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">-->
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        .container {
            max-width: 400px;
            width: 100%;
            padding: 20px;
            text-align: center;
            background-color: white;
            border-radius: 8px;
        }

        .container img {
            width: 150px;
            margin-bottom: 20px;
        }

        h2 {
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0 15px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
            color: #999;
        }

        /*input[type="text"]::placeholder, input[type="password"]::placeholder {*/
        /*    color: #bbb;*/
        /*}*/

        button {
            background-color: #d0021b!important;
            color: white;
            padding: 15px 20px;
            margin: 5px 0 15px 0;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }

        button:hover {
            background-color: #a30215!important;
        }

        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #aaa;
            text-align: center;
        }

        a {
            color: #a30215;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <img src="resources/images/Upon-logo-full.png" alt="Logo">
    <h2>Giriş</h2>
    <?php if (isset($error)) { echo "<div class='alert alert-danger'>$error</div>"; } ?>
    <form method="post" action="">
        <div class="form-group">
            <input type="text" class="form-control" name="username" placeholder="İstifadəçi adı" required>
        </div>
        <div class="form-group">
            <input type="password" class="form-control" name="password" placeholder="Şifrə" required>
        </div>
        <button type="submit" class="btn btn-primary">Daxil ol</button>
    </form>
</div>
<script>
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
            navigator.serviceWorker.register('/service-worker.js')
                .then((registration) => {
                    console.log('ServiceWorker registration successful with scope: ', registration.scope);
                }, (error) => {
                    console.log('ServiceWorker registration failed: ', error);
                });
        });
    }
</script>
</body>
</html>
