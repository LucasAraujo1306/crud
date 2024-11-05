<?php
include_once '../includes/header.php';
include_once '../includes/navbar.php';
require '../db/db_connection.php';

echo "<div class='movie-container'>";

$query = "SELECT * FROM movies";
$statement = $db->prepare($query);
$statement->execute();
$movies = $statement->fetchAll(PDO::FETCH_ASSOC);

$isLogged = isset($_COOKIE['is_logged']) && $_COOKIE['is_logged'] === "true";
$isAdmin = isset($_COOKIE['is_admin']) && $_COOKIE['is_admin'] === "1";

foreach ($movies as $movie) {
  echo "<div class='movie-card'>";
  echo "<h2 class='movie-title'>" . htmlspecialchars($movie['title']) . "</h2>";
  echo "<p class='movie-info'>Ano: " . htmlspecialchars($movie['release_year']) . "</p>";

  // Conversão de minutos para horas e minutos
  $durationInMinutes = $movie['duration'];
  $hours = floor($durationInMinutes / 60);
  $minutes = $durationInMinutes % 60;

  echo "<p class='movie-info'>Duração: " . $hours . " horas e " . $minutes . " minutos</p>";

  //echo "<p>Duração: " . htmlspecialchars($movie['duration']) . " minutos</p>";
  echo "<p class='movie-info'>Classificação: " . htmlspecialchars($movie['age_rating']) . "+</p>";
  // Exibir o vídeo do trailer com o URL correto
  echo "<iframe class='movie-trailer' src='" . htmlspecialchars($movie['trailer_url']) . "' frameborder='0' allowfullscreen></iframe>";

  echo "<img class='movie-cover' src='" .
    htmlspecialchars($movie['cover_image_url']) . "' alt='Capa do filme'>";

  if ($isLogged && $isAdmin) {
    echo "<div class='movie-actions'>";
    echo "<a class='button' href='update_movie.php?id=" . $movie['id'] . "'>Editar</a> | ";
    echo "<a class='button delete-button' href='delete_movie.php?id=" . $movie['id'] . "'>Excluir</a>";
    echo "</div>";
  }
  echo "</div>";
}
?>
</div>


<?php
include_once '../includes/footer.php';

?>