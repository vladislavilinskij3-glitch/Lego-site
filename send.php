<?php
// ================= НАСТРОЙКИ =================

// 1. ВСТАВЬТЕ СЮДА ВАШ API КЛЮЧ (токен)
$token = 'Мvk1.a.YqpT3tnh5kc0QvJgJCQWWR5LAevrjNVna-2qIbwGPkO-94I-rijEpCblP2XzJYGw90zo6ZgwHcqLW6XDdK1zHnQP8MrACkpTTMn2DzRDSbYsX9ACBWCKWvaSyN3nH7TgVPbO1PGmWZpi9MxzEbGXMj0Pffl0gd8xiIxYb0f_w40-CrqFuBJeFdoXF6Tw2GDaX4ooSZwJfEudeFgOpbF1fw
'; 

// 2. ID получателя (кому отправляем сообщение). 
$owner_id = 673627887;

// ============== ПОЛУЧАЕМ ДАННЫЕ ИЗ ФОРМЫ ==============
$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
$age = isset($_POST['age']) ? trim($_POST['age']) : '';

// Проверяем, заполнены ли обязательные поля
if (empty($name) || empty($phone)) {
    die(json_encode(['status' => 'error', 'message' => 'Не заполнены обязательные поля']));
}

// Формируем текст сообщения
$message = "📌 Новая заявка с сайта Лего-Студии!\n";
$message .= "Имя: $name\n";
$message .= "Телефон: $phone\n";
if (!empty($age)) {
    $message .= "Возраст ребёнка: $age\n";
}

// ============== ОТПРАВКА ЧЕРЕЗ API ВК ==============
$api_url = "https://api.vk.com/method/messages.send";

// Параметры запроса
$params = [
    'v' => '5.131',
    'access_token' => $token,
    'peer_id' => $owner_id,    
    'message' => $message,
    'random_id' => rand(1, 10000) // Защита от дублирования сообщений
];

// Формируем URL
$url = $api_url . '?' . http_build_query($params);

// Отправляем запрос
$response = file_get_contents($url);
$data = json_decode($response, true);

// Проверяем, что ответ ВК успешный
if (isset($data['response'])) {
    echo json_encode(['status' => 'ok', 'message' => 'Сообщение успешно отправлено!']);
} else {
    // Если произошла ошибка, показываем её текст
    $error_msg = isset($data['error']['error_msg']) ? $data['error']['error_msg'] : 'Неизвестная ошибка VK';
    echo json_encode(['status' => 'error', 'message' => 'Ошибка ВК: ' . $error_msg]);
}
?>