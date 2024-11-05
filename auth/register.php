<?php
include '../functions/uuid.php';

session_start();
include '../db/db_connection.php'; // Conexão com o banco de dados

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $password = $_POST['password'];
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);
  $uuid = generateUUIDv4(); // Gerando o UUID

  // Verifica se o nome de usuário já existe
  $checkQuery = "SELECT COUNT(*) FROM users WHERE username = :username";
  $checkStmt = $db->prepare($checkQuery);
  $checkStmt->execute([':username' => $username]);
  $userExists = $checkStmt->fetchColumn();

  if ($userExists) {
    echo "<p>Esse nome de usuário já está em uso. Por favor, escolha outro.</p>";
  } else {
    // Inserir o novo usuário no banco de dados
    $query = "INSERT INTO users (id, username, password) VALUES (:id, :username, :password)";
    $statement = $db->prepare($query);
    $statement->execute([
      ':id' => $uuid,
      ':username' => $username,
      ':password' => $hashed_password
    ]);

    echo "<p>Registro bem-sucedido! Você pode fazer login agora.</p>";
  }
}
include_once '../includes/header.php';  // Cabeçalho HTML e link CSS
include_once '../includes/navbar.php';  // Navegação

// Conteúdo do formulário de registro
echo '<div class="form-container">';
echo '<h2>Criar Conta</h2>';
if (!empty($error)) { // Mostra a mensagem de erro se existir
  echo '<p class="error-message">' . htmlspecialchars($error) . '</p>';
}
echo '<form method="POST" action="register.php">';
echo '  <label for="username">Usuário:</label>';
echo '  <input type="text" id="username" name="username" required>';
echo '  <label for="password">Senha:</label>';
echo '  <input type="password" id="password" name="password" required>';
echo '  <button type="submit">Registrar</button>';
echo '</form>';
echo '</div>';

include_once '../includes/footer.php'; // Rodapé
