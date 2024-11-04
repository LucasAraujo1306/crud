<?php
// Limpa o cookie 'is_logged' definindo uma data de expiração no passado
setcookie('is_logged', '', time() - 3600, '/');

// Limpa outros cookies, como o 'is_admin' (caso você tenha)
setcookie('is_admin', '', time() - 3600, '/');

// Também é uma boa prática destruir a sessão do usuário ao fazer logout
session_start();
session_unset();
session_destroy();

// Redireciona para a página de login após limpar os cookies e a sessão
header('Location: ../index.php');
exit();
