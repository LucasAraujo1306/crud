<nav>
  <a href="/crud/index.php">Início</a>
  <a href="/crud/movies/list_movies.php">Filmes</a>
  <?php
  $isLogged = isset($_COOKIE['is_logged']) && $_COOKIE['is_logged'] === "true";
  $isAdmin = isset($_COOKIE['is_admin']) && $_COOKIE['is_admin'] === "1";

  // Exibir link "Adicionar Filme" apenas para administradores logados
  if ($isLogged && $isAdmin) {
    echo "<a href='/crud/movies/create_movie.php'>Adicionar Filme</a>";
  }

  // Exibir "Registrar" e "Login" apenas se o usuário NÃO estiver logado
  if (!$isLogged) {
    echo "<a href='/crud/auth/register.php'>Registrar</a>";
    echo "<a href='/crud/auth/login.php'>Login</a>";
  } else {
    // Exibir "Sair" apenas se o usuário estiver logado
    echo "<a href='/crud/auth/logout.php'>Sair</a>";
  }
  ?>

</nav>