<?php 
session_start();
  if (isset($_SESSION['logged']['email'])) {
      session_destroy();
      header('location: ../?logout=success');
      exit();
  }

  header('location: ../');
?>