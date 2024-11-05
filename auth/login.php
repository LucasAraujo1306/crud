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

include_once '../includes/header.php';  // Cabeçalho HTML e link CSS
include_once '../includes/navbar.php';  // Navegação

// Conteúdo do formulário de login
echo '<div class="form-container">';
echo '<h2>Login</h2>';
if (isset($error)) {
  echo '<p style="color: red;">' . htmlspecialchars($error) . '</p>';
}
echo '<form method="POST" action="login.php">';
echo '  <label for="username">Usuário:</label>';
echo '  <input type="text" id="username" name="username" required>';
echo '  <br>';
echo '  <label for="password">Senha:</label>';
echo '  <input type="password" id="password" name="password" required>';
echo '  <br>';
echo '  <button type="submit">Entrar</button>';
echo '</form>';
echo '</div>';

include_once '../includes/footer.php'; // Rodapé
