<?php
session_start();

// Kullanıcı adı ve şifre ayarları (Buradan değiştirebilirsiniz)
$admin_user = "admin";
$admin_pass = "scorpion123";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST['username'] === $admin_user && $_POST['password'] === $admin_pass) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Geçersiz kullanıcı adı veya şifre!";
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Giriş | Scorpion MC</title>
    <link rel="stylesheet" href="../assets/mobile.css">
    <link rel="stylesheet" href="../assets/animations.css">
    <style>
        body {
            background-color: #000;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: 'Inter', sans-serif;
        }
        .login-card {
            width: 100%;
            max-width: 400px;
            padding: 3rem;
            text-align: center;
        }
        h1 {
            font-family: 'Hessian', serif;
            font-size: 2.5rem;
            margin-bottom: 2rem;
            letter-spacing: 5px;
            color: #fff;
        }
        .form-group {
            margin-bottom: 1.5rem;
            text-align: left;
        }
        label {
            display: block;
            color: #888;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        input {
            width: 100%;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            padding: 1rem;
            color: #fff;
            font-family: inherit;
            outline: none;
            transition: all 0.3s ease;
        }
        input:focus {
            border-color: #fff;
            background: rgba(255,255,255,0.1);
        }
        .btn-login {
            width: 100%;
            margin-top: 1rem;
            cursor: pointer;
        }
        .error-msg {
            color: #ff4d4d;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="login-card glass-card reveal visible">
        <h1>GİRİŞ YAP</h1>
        <?php if ($error): ?>
            <div class="error-msg"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label for="username">Kullanıcı Adı</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Şifre</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn-primary btn-login">GİRİŞ</button>
        </form>
    </div>
    <script src="../assets/animations.js" defer></script>
</body>
</html>
