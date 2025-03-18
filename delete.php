<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
    die('Доступ запрещён!');
}

if (isset($_POST['delete_one'])) {
    $data = json_decode(file_get_contents('data.json'), true);
    $index = $_POST['index'];

    if (isset($data[$index])) {
        unlink("uploads/" . $data[$index]['image']); // Удаляем картинку
        array_splice($data, $index, 1); // Удаляем запись из массива
        file_put_contents('data.json', json_encode($data, JSON_PRETTY_PRINT));
    }
    header("Location: admin.php"); // Перенаправляем обратно
    exit();
}

if (isset($_POST['delete_all'])) {
    array_map('unlink', glob("uploads/*")); // Удаляем все файлы в uploads/
    file_put_contents('data.json', json_encode([])); // Очищаем JSON
    header("Location: admin.php"); // Перенаправляем обратно
    exit();
}
?>
