<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    exit();
}

$data = json_decode(file_get_contents('data.json'), true);
$index = $_GET['index'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $image = $_FILES['image'];
    $record = $_POST['record'];
    $name = $_POST['name'];
    $class = $_POST['class'];
    $date = $_POST['date'];

    // Если новая картинка была загружена
    if ($image['name']) {
        // Удаляем старое изображение, если оно существует
        if (file_exists('uploads/' . $data[$index]['image'])) {
            unlink('uploads/' . $data[$index]['image']);
        }

        // Проверяем, что изображение загружено корректно
        if ($image['error'] === UPLOAD_ERR_OK) {
            // Генерируем уникальное имя для нового изображения
            $imageName = uniqid() . '-' . basename($image['name']);
            move_uploaded_file($image['tmp_name'], 'uploads/' . $imageName);

            // Обновляем имя картинки в данных
            $data[$index]['image'] = $imageName;
        } else {
            echo "Ошибка загрузки файла. Пожалуйста, попробуйте снова.";
        }
    }

    // Обновляем текст, имя, класс и дату
    $data[$index]['record'] = $record;
    $data[$index]['name'] = $name;
    $data[$index]['class'] = $class;
    $data[$index]['date'] = $date;

    // Записываем данные обратно в файл
    file_put_contents('data.json', json_encode($data, JSON_PRETTY_PRINT));

    // Перенаправляем на админ-панель
    header("Location: admin.php");
    exit();
}

$item = $data[$index];
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Upravit příspěvek</title>
</head>
<body>
    <h1>Upravit příspěvek</h1>
    <form action="edit.php?index=<?php echo $index; ?>" method="post" enctype="multipart/form-data">
        <img src="uploads/<?php echo $item['image']; ?>" width="100" alt="Aktuální obrázek"><br><br>
        
        <label for="image">Nový obrázek:</label>
        <input type="file" name="image" id="image"><br><br>

        <label for="record">Popis:</label><br>
        <textarea name="record" rows="4" cols="50"><?php echo htmlspecialchars($item['record']); ?></textarea><br><br>

        <label for="name">Jméno:</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($item['name']); ?>"><br><br>

        <label for="class">Třída:</label>
        <input type="text" name="class" value="<?php echo htmlspecialchars($item['class']); ?>"><br><br>

        <label for="date">Datum:</label>
        <input type="date" name="date" value="<?php echo htmlspecialchars($item['date']); ?>"><br><br>

        <button type="submit">Uložit změny</button>
    </form>

    <br><a href="admin.php">Zpět na administrátorskou stránku</a>
</body>
</html>
