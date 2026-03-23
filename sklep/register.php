<?php
require_once 'config.php';

if (isLoggedIn()) {
    header('Location: index.php');
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    if (strlen($username) < 3) {
        $error = 'min 3 znaki';
    } elseif (strlen($password) < 6) {
        $error = 'min 6 znakow';
    } elseif ($password !== $confirm_password) {
        $error = 'hasla nie sa takie same';
    } else {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);
        
        if ($stmt->fetch()) {
            $error = 'nazwa zajeta';
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            
            if ($stmt->execute([$username, $hashed_password])) {
                $success = 'Rejestracja zakonczona';
            } else {
                $error = 'Wystapil blad';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rejestracja</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'menu.php'; ?>
    
    <div class="container">
        <h1>Rejestracja</h1>
        
        <?php if($error): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
            <p><a href="login.php">Przejdź do logowania</a></p>
        <?php else: ?>
            <form method="POST">
                <div class="form-group">
                    <label for="username">Nazwa użytkownika:</label>
                    <input type="text" name="username" id="username" required minlength="3">
                </div>
                
                <div class="form-group">
                    <label for="password">Hasło:</label>
                    <input type="password" name="password" id="password" required minlength="6">
                </div>
                
                <div class="form-group">
                    <label for="confirm_password">Potwierdź hasło:</label>
                    <input type="password" name="confirm_password" id="confirm_password" required>
                </div>
                
                <button type="submit">Zarejestruj się</button>
            </form>
            
            <p style="margin-top: 1rem;">Masz już konto? <a href="login.php">Zaloguj się</a></p>
        <?php endif; ?>
    </div>
</body>
</html>