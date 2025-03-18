<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    exit();
}

$data = json_decode(file_get_contents('data.json'), true);

// Nastavení stránkování
$postsPerPage = 5; // Počet příspěvků na stránku
$totalPosts = count($data); // Celkový počet příspěvků
$totalPages = ceil($totalPosts / $postsPerPage); // Celkový počet stránek

// Získání aktuální stránky z GET parametru, pokud není – nastavíme na 1
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
if ($page > $totalPages) $page = $totalPages;

// Určení, které záznamy zobrazit na aktuální stránce
$startIndex = ($page - 1) * $postsPerPage;
$postsToShow = array_slice($data, $startIndex, $postsPerPage);
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Administrátorský panel</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Administrátorský panel</h1>
    <h2>Všechny záznamy</h2>
    <table>
        <tr>
            <th>Obrázek</th>
            <th>Co udělal</th>
            <th>Akce</th>
        </tr>
        <?php foreach ($postsToShow as $index => $item): ?>
            <tr>
                <td><img src="uploads/<?php echo $item['image']; ?>" width="100"></td>
                <td><?php echo htmlspecialchars($item['record']); ?></td>
                <td>
                    <form action="delete.php" method="post" style="display:inline;">
                        <input type="hidden" name="index" value="<?php echo $startIndex + $index; ?>">
                        <button type="submit" name="delete_one">Smazat</button>
                    </form>
                    <form action="edit.php" method="get" style="display:inline;">
                        <input type="hidden" name="index" value="<?php echo $startIndex + $index; ?>">
                        <button type="submit">Upravit</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <!-- Stránkování -->
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?page=<?php echo $page - 1; ?>">← Předchozí</a>
        <?php endif; ?>

        <span>Stránka <?php echo $page; ?> z <?php echo $totalPages; ?></span>

        <?php if ($page < $totalPages): ?>
            <a href="?page=<?php echo $page + 1; ?>">Další →</a>
        <?php endif; ?>
    </div>

    <form action="delete.php" method="post">
        <button type="submit" name="delete_all">Smazat všechny záznamy</button>
    </form>

    <h2>Přidat nový příspěvek</h2>
    <form id="addPostForm" action="upload.php" method="post" enctype="multipart/form-data">
        <input type="file" name="image" required><br>
        <input type="text" name="name" placeholder="Jméno osoby" required><br>
        <input type="text" name="class" placeholder="Třída (skupina)" required><br>
        <input type="text" name="record_description" placeholder="Co udělal?" required><br><br>
        <input type="date" name="date" required><br><br>

        <div id="preview">
            <!-- Zde se zobrazí náhled -->
        </div>

        <button type="submit">Přidat</button>
    </form>

    <br><a href="index.php">Zpět na stránku</a>

    <script src="preview.js"></script>
</body>
</html>
