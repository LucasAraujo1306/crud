<?php
include_once '../includes/header.php';
include_once '../includes/navbar.php';
require '../db/db_connection.php';

$query = "SELECT * FROM movies";
$statement = $db->prepare($query);
$statement->execute();
$movies = $statement->fetchAll(PDO::FETCH_ASSOC);

$isLogged = isset($_COOKIE['is_logged']) && $_COOKIE['is_logged'] === "true";
$isAdmin = isset($_COOKIE['is_admin']) && $_COOKIE['is_admin'] === "1";

foreach ($movies as $movie) {
  echo "<div class='movie'>";
  echo "<h2>" . htmlspecialchars($movie['title']) . "</h2>";
  echo "<p>Ano: " . htmlspecialchars($movie['release_year']) . "</p>";

  // Conversão de minutos para horas e minutos
  $durationInMinutes = $movie['duration'];
  $hours = floor($durationInMinutes / 60);
  $minutes = $durationInMinutes % 60;

  echo "<p>Duração: " . $hours . " horas e " . $minutes . " minutos</p>";

  //echo "<p>Duração: " . htmlspecialchars($movie['duration']) . " minutos</p>";
  echo "<p>Classificação: " . htmlspecialchars($movie['age_rating']) . "+</p>";
  // Exibir o vídeo do trailer com o URL correto
  echo "<iframe width='800' height='600' src='" . htmlspecialchars($movie['trailer_url']) . "' frameborder='0' allowfullscreen></iframe>";

  echo "<img src='" .
    htmlspecialchars($movie['cover_image_url']) . "' alt='Capa do filme'>";

  if ($isLogged && $isAdmin) {
    echo "<a href='update_movie.php?id=" .
      $movie['id'] . "'>Editar</a> | ";
    echo "<a href='delete_movie.php?id=" . $movie['id'] . "'>Excluir</a>";
  }
  echo "</div>";
}
