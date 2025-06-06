<!DOCTYPE html>
<html>
<head>
    <title>Обратная связь с сайта</title>
</head>
<body>
    <h2>Новое сообщение с формы обратной связи</h2>
    <p><strong>Email:</strong> {{ $data['email'] }}</p>
    <p><strong>Сообщение:</strong></p>
    <p>{{ $data['message'] }}</p>
</body>
</html>