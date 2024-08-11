<?php
session_start();
define('HOST', 'localhost');
define('USER', 'root');
define('PASS', '');
define('DB', 'neumático rd');
define('CHARSET', 'utf8');

$conn = new mysqli(HOST, USER, PASS, DB);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset(CHARSET);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT id, password, is_admin, firstname FROM login WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($user_id, $hashed_password, $is_admin, $firstname);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $user_id;
            $_SESSION['is_admin'] = $is_admin;
            $_SESSION['firstname'] = $firstname;
            $_SESSION['email'] = $email; // Agrega esta línea

            if ($is_admin === 1) {
                header("Location: admin_dashboard.php");
            } elseif ($is_admin === 2) {
                header("Location: delivery_dashboard.php");
            } else {
                header("Location: dashboard.php");
            }
            exit();
        } else {
            echo "Invalid credentials.";
        }
    } else {
        echo "Invalid credentials.";
    }

    $stmt->close();
}

$conn->close();
?>
