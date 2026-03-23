<?php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sklep Internetowy - Strona Główna</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'menu.php'; ?>
    
    <div class="container">
        <h1>Witaj w sklepie!</h1>
        <p>Znajdziesz tu super produkty</p>
        <p>Wybierz jedna z opcji w menu powyżej</p>
        
        <?php if(isLoggedIn()): ?>
            <p>Jestes zalogowany jako: <strong><?php echo htmlspecialchars(getUserName()); ?></strong></p>
        <?php else: ?>
            <p>Zaloguj sie aby robić zakupy!</p>
        <?php endif; ?>
    </div>
</body>
</html>