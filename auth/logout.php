<?php
session_start(); // Inicie a sessão

// Destrua todas as variáveis de sessão
$_SESSION = array();

// Destrua a sessão
session_destroy();

// Redirecione para a página de login ou página inicial
header("Location: projeto-grupo/index.php"); // Altere para a página que você deseja
exit();
