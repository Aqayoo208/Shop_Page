<?php
require_once 'config.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_GET['remove'])) {
    $id = (int)$_GET['remove'];
    if (isset($_SESSION['cart'][$id])) {
        unset($_SESSION['cart'][$id]);
        $message = "Usunięto produkt z koszyka";
    }
}

if (isset($_GET['clear'])) {
    $_SESSION['cart'] = [];
    $message = "Usunięto wszystkie produkty z koszyka";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_quantity'])) {
    $id = (int)$_POST['product_id'];
    $quantity = (int)$_POST['quantity'];
    
    if ($quantity > 0 && isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['quantity'] = $quantity;
    } elseif ($quantity <= 0) {
        unset($_SESSION['cart'][$id]);
    }
}

$total = 0;
foreach ($_SESSION['cart'] as $item) {
    $total += $item['price'] * $item['quantity'];
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koszyk zakupów</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'menu.php'; ?>
    
    <div class="container">
        <h1>Twój koszyk</h1>
        
        <?php if(isset($message)): ?>
            <div class="alert alert-success"><?php echo $message; ?></div>
        <?php endif; ?>
        
        <?php if(empty($_SESSION['cart'])): ?>
            <p>Twój koszyk jest pusty.</p>
            <a href="sklep.php" class="btn">Idź do sklepu</a>
        <?php else: ?>
            <?php foreach($_SESSION['cart'] as $id => $item): ?>
                <div class="cart-item">
                    <div class="cart-item-info">
                        <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                        <p>Cena: <?php echo number_format($item['price'], 2); ?> zł</p>
                        <p>Razem: <?php echo number_format($item['price'] * $item['quantity'], 2); ?> zł</p>
                    </div>
                    <div class="cart-item-actions">
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="product_id" value="<?php echo $id; ?>">
                            <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" style="width: 60px;">
                            <button type="submit" name="update_quantity">Aktualizuj</button>
                        </form>
                        <a href="?remove=<?php echo $id; ?>" class="btn btn-danger">Usuń</a>
                    </div>
                </div>
            <?php endforeach; ?>
            
            <div class="cart-summary">
                <h3>Razem do zapłaty: <?php echo number_format($total, 2); ?> zł</h3>
                <a href="?clear=true" class="btn btn-warning" onclick="return confirm('Czy na pewno chcesz usunąć wszystkie produkty?')">Usuń wszystko</a>
                <button onclick="alert('Zakupy zakończone! Dziękujemy!')">Zakończ zakupy</button>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>