<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<div class="menu">
    <ul>
        <li><a href="index.php">Strona główna</a></li>
        <li><a href="sklep.php">Sklep</a></li>
        <li><a href="koszyk.php">Koszyk (<?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>)</a></li>
        <li><a href="biblioteka.php">Biblioteka</a></li>
        
        <?php if(isset($_SESSION['user_id'])): ?>
            <li class="welcome">Witaj, <?php echo htmlspecialchars($_SESSION['username']); ?>!</li>
            <li><a href="logout.php" class="logout-btn">Wyloguj się</a></li>
        <?php else: ?>
            <li><a href="login.php">Zaloguj się</a></li>
            <li><a href="register.php">Zarejestruj się</a></li>
        <?php endif; ?>
    </ul>
</div>