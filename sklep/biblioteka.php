<?php
require_once 'config.php';

// Edycja 
if (isset($_GET['edit'])) {
    $edit_id = (int)$_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM songs WHERE id = ?");
    $stmt->execute([$edit_id]);
    $edit_song = $stmt->fetch();
}

// Aktualizacja 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_song'])) {
    $id = (int)$_POST['id'];
    $title = trim($_POST['title']);
    $artist = trim($_POST['artist']);
    $year = (int)$_POST['year'];
    $duration = trim($_POST['duration']);
    
    if (!empty($title) && !empty($artist) && !empty($year) && !empty($duration)) {
        $stmt = $pdo->prepare("UPDATE songs SET title = ?, artist = ?, year = ?, duration = ? WHERE id = ?");
        if ($stmt->execute([$title, $artist, $year, $duration, $id])) {
            $success = "Utwór został zaktualizowany pomyślnie!";
            $edit_song = null;
        } else {
            $error = "Błąd podczas aktualizacji utworu.";
        }
    } else {
        $error = "Wszystkie pola są wymagane!";
    }
}

// Dodawanie 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_song'])) {
    $title = trim($_POST['title']);
    $artist = trim($_POST['artist']);
    $year = (int)$_POST['year'];
    $duration = trim($_POST['duration']);
    
    if (!empty($title) && !empty($artist) && !empty($year) && !empty($duration)) {
        $stmt = $pdo->prepare("INSERT INTO songs (title, artist, year, duration) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$title, $artist, $year, $duration])) {
            $success = "Utwór został dodany pomyślnie!";
        } else {
            $error = "Błąd podczas dodawania utworu.";
        }
    } else {
        $error = "Wszystkie pola są wymagane!";
    }
}

// Usuwanie
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM songs WHERE id = ?");
    if ($stmt->execute([$id])) {
        $success = "Utwór został usunięty pomyślnie!";
    } else {
        $error = "Błąd podczas usuwania utworu.";
    }
}

// Pobieranie 
$stmt = $pdo->query("SELECT * FROM songs ORDER BY id DESC");
$songs = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteka muzyczna</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'menu.php'; ?>
    
    <div class="container">
        <h1>Biblioteka muzyczna</h1>
        
        <?php if(isset($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <?php if(isset($error)): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <div style="background: #f9f9f9; padding: 20px; border-radius: 10px; margin-bottom: 30px;">
            <h2><?php echo isset($edit_song) ? 'Edytuj utwór' : 'Dodaj nowy utwór'; ?></h2>
            <form method="POST" style="display: grid; gap: 10px;">
                <?php if(isset($edit_song)): ?>
                    <input type="hidden" name="id" value="<?php echo $edit_song['id']; ?>">
                <?php endif; ?>
                
                <div>
                    <label for="title">Tytuł utworu:</label>
                    <input type="text" name="title" id="title" required 
                           value="<?php echo isset($edit_song) ? htmlspecialchars($edit_song['title']) : ''; ?>" 
                           style="width: 100%; padding: 8px; margin-top: 5px;">
                </div>
                
                <div>
                    <label for="artist">Artysta:</label>
                    <input type="text" name="artist" id="artist" required 
                           value="<?php echo isset($edit_song) ? htmlspecialchars($edit_song['artist']) : ''; ?>" 
                           style="width: 100%; padding: 8px; margin-top: 5px;">
                </div>
                
                <div>
                    <label for="year">Rok wydania:</label>
                    <input type="number" name="year" id="year" required 
                           value="<?php echo isset($edit_song) ? $edit_song['year'] : ''; ?>" 
                           style="width: 100%; padding: 8px; margin-top: 5px;">
                </div>
                
                <div>
                    <label for="duration">Czas trwania (np. 3:45):</label>
                    <input type="text" name="duration" id="duration" required 
                           value="<?php echo isset($edit_song) ? htmlspecialchars($edit_song['duration']) : ''; ?>" 
                           placeholder="np. 3:45" 
                           style="width: 100%; padding: 8px; margin-top: 5px;">
                </div>
                
                <button type="submit" name="<?php echo isset($edit_song) ? 'update_song' : 'add_song'; ?>" style="margin-top: 10px;">
                    <?php echo isset($edit_song) ? 'Zaktualizuj utwór' : 'Dodaj utwór'; ?>
                </button>
                
                <?php if(isset($edit_song)): ?>
                    <a href="biblioteka.php" style="text-align: center; margin-top: 5px;">Anuluj edycję</a>
                <?php endif; ?>
            </form>
        </div>
        
        <h2>Lista utworów</h2>
        <p>Liczba utworów: <?php echo count($songs); ?></p>
        
        <div class="songs-grid">
            <?php if(count($songs) > 0): ?>
                <?php foreach($songs as $song): ?>
                    <div class="song-card">
                        <h3><?php echo htmlspecialchars($song['title']); ?></h3>
                        <p><strong>Artysta:</strong> <?php echo htmlspecialchars($song['artist']); ?></p>
                        <p><strong>Rok:</strong> <?php echo $song['year']; ?></p>
                        <p><strong>Czas:</strong> <?php echo $song['duration']; ?></p>
                        <div style="margin-top: 10px;">
                            <a href="?edit=<?php echo $song['id']; ?>" 
                               class="btn" 
                               style="display: inline-block; text-decoration: none; margin-right: 5px;">
                               Edytuj
                            </a>
                            <a href="?delete=<?php echo $song['id']; ?>" 
                               class="btn btn-danger" 
                               style="display: inline-block; text-decoration: none;"
                               onclick="return confirm('Czy na pewno chcesz usunąć utwór "<?php echo htmlspecialchars($song['title']); ?>"?')">
                               Usuń
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>brak utworow dodaj: </p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>