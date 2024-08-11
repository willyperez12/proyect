<?php
require_once 'C:\xampp\htdocs\neumati\Config\Database.php';

if (!isset($_GET['id'])) {
    header("Location: admin_dashboard.php?section=messages");
    exit();
}

$message_id = intval($_GET['id']);

// Actualizar el estado del mensaje a "leído"
$update_query = "UPDATE mensajes SET status = 'leído' WHERE id = ?";
$stmt = $conn->prepare($update_query);
$stmt->bind_param("i", $message_id);
$stmt->execute();

// Obtener el mensaje
$query = "SELECT * FROM mensajes WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $message_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header("Location: admin_dashboard.php?section=messages");
    exit();
}

$message = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Message</title>
    <link rel="stylesheet" href="css/admin_dashboard.css">
    <style>
        body {
            background-color: #000;
            color: #fff;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            padding: 20px;
        }
        .button {
            padding: 10px 20px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>View Message</h1>
    <p><strong>Name:</strong> <?php echo htmlspecialchars($message['name']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($message['email']); ?></p>
    <p><strong>Subject:</strong> <?php echo htmlspecialchars($message['subject']); ?></p>
    <p><strong>Message:</strong> <?php echo htmlspecialchars($message['message']); ?></p>
    <p><strong>Created At:</strong> <?php echo htmlspecialchars($message['created_at']); ?></p>
    <p><strong>Status:</strong> <?php echo htmlspecialchars($message['status']); ?></p>
    <a href="admin_dashboard.php?section=messages" class="button">Back to Messages</a>
</div>
</body>
</html>
