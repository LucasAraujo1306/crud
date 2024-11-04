<?php

if (isset($_COOKIE['is_logged']) && $_COOKIE['is_logged'] === "true") {
  header('Location: ../index.php');
  exit();
}

include '../db/db_connection.php'; // Inclua sua conexão com o banco de dados

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $query = "SELECT * FROM users WHERE username = :username";
  $statement = $db->prepare($query);
  $statement->execute([':username' => $username]);
  $user = $statement->fetch(PDO::FETCH_ASSOC);

  if ($user && password_verify($password, $user['password'])) {
    session_start();
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['is_admin'] = $user['is_admin'];
    //setcookie('is_admin', $user['is_admin']);
    //setcookie('is_logged', "true");
    setcookie('is_logged', "true", time() + 3600, "/");
    setcookie('is_admin', $user['is_admin'], time() + 3600, "/");
    header('Location: ./login.php'); // Redireciona para a página inicial após o login
    exit();
  } else {
    echo "Nome de usuário ou senha incorretos.";
  }
}



?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
</head>

<body>
  <h2>Login</h2>
  <?php if (isset($error)): ?>
    <p style="color: red;"><?php echo $error; ?></p>
  <?php endif; ?>
  <form method="POST" action="login.php">
    <label for="username">Usuário:</label>
    <input type="text" id="username" name="username" required>
    <br>
    <label for="password">Senha:</label>
    <input type="password" id="password" name="password" required>
    <br>
    <button type="submit">Entrar</button>
  </form>
</body>

</html>