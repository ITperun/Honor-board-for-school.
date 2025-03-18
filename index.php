<?php
$data = json_decode(file_get_contents('data.json'), true);
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Školní rekordy</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>SÍŇ ÚSPĚCHŮ A REKORDŮ</h1>
    <div class="carousel">
        <?php foreach ($data as $item): ?>
            <div class="slide">
                <div class="slide-content">
                    <img src="uploads/<?php echo $item['image']; ?>" alt="Obrázek">
                    <div class="text">
                        <h2><?php echo htmlspecialchars($item['record']); ?></h2>
                        <p><strong>Datum:</strong> <?php echo htmlspecialchars($item['date']); ?></p>
                        <p><strong>Jméno:</strong> <?php echo htmlspecialchars($item['name']); ?></p>
                        <p><strong>Třída:</strong> <?php echo htmlspecialchars($item['class']); ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <script src="script.js"></script>
</body>
</html>
