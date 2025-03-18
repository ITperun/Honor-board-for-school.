<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
    die(json_encode(['status' => 'error', 'message' => 'You Shall Not Pass!']));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['image']) && isset($_POST['name']) && isset($_POST['class']) && isset($_POST['record_description']) && isset($_POST['date'])) {
        $name = $_POST['name'];
        $class = $_POST['class'];
        $record_description = $_POST['record_description'];
        $date = $_POST['date'];
        $image = $_FILES['image'];

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
        if (!in_array($image['type'], $allowedTypes)) {
            die(json_encode(['status' => 'error', 'message' => 'Incorrect image format. Try jpeg, png or gif.']));
        }

        $uploadDir = 'uploads/';
        $imageName = uniqid() . '-' . basename($image['name']);
        $uploadFile = $uploadDir . $imageName;

        if (move_uploaded_file($image['tmp_name'], $uploadFile)) {
            $data = json_decode(file_get_contents('data.json'), true);

            $newPost = [
                'image' => $imageName,
                'name' => $name,
                'class' => $class,
                'record' => $record_description,
                'date' => $date,
            ];

            $data[] = $newPost;
            file_put_contents('data.json', json_encode($data, JSON_PRETTY_PRINT));

            // Переадресация в админ-панель после успешного добавления поста
            header('Location: admin.php');
            exit;
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error.']);
        }
    }
}
?>
