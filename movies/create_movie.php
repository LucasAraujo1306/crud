<?php

session_start(); // Inicie a sessão para acessar os dados do usuário

// Verifique se o usuário está logado e se é um administrador
if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] !== 1) {
  header('Location: ../index.php'); // Redirecione para a página inicial se não estiver autorizado
  exit();
}

include_once '../db/db_connection.php'; // Conexão com o banco de dados
include_once '../includes/header.php';  // Cabeçalho HTML e link CSS
include_once '../includes/navbar.php';  // Navegação
include_once '../functions/uuid.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $title = $_POST['title'];
  $release_year = $_POST['release_year'];
  $duration = $_POST['duration'];
  $age_rating = $_POST['age_rating'];
  $trailer_url = $_POST['trailer_url'];
  $cover_image_url = $_POST['cover_image_url'];

  $uuid = generateUUIDv4();

  $query = "INSERT INTO movies (id, title, release_year, duration, age_rating, trailer_url, cover_image_url) 
              VALUES (:id, :title, :release_year, :duration, :age_rating, :trailer_url, :cover_image_url)";
  $statement = $db->prepare($query);
  $statement->execute([
    ':id' => $uuid,
    ':title' => $title,
    ':release_year' => $release_year,
    ':duration' => $duration,
    ':age_rating' => $age_rating,
    ':trailer_url' => $trailer_url,
    ':cover_image_url' => $cover_image_url
  ]);

  echo "<p class='success-message'>Filme adicionado com sucesso!</p>";
}

echo "<div class='form-container'>
        <h2>Adicionar Novo Filme</h2>
        <form method='POST' action='create_movie.php' class='movie-form'>
          <label for='title'>Título:</label>
          <input type='text' id='title' name='title' required>

          <label for='release_year'>Ano de lançamento:</label>
          <input type='text' id='release_year' name='release_year' required>

          <label for='duration'>Duração (minutos):</label>
          <input type='number' id='duration' name='duration' required>

          <label for='age_rating'>Classificação etária:</label>
          <input type='text' id='age_rating' name='age_rating' required>

          <label for='trailer_url'>URL do trailer:</label>
          <input type='text' id='trailer_url' name='trailer_url' required>

          <label for='cover_image_url'>URL da capa do filme:</label>
          <input type='text' id='cover_image_url' name='cover_image_url' required>

          <button type='submit' class='submit-button'>Adicionar Filme</button>
        </form>
      </div>";


include_once '../includes/footer.php';
