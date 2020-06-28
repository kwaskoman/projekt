<?php
  session_start();

  if (isset($_SESSION['logged']['email'])) {
    switch ($_SESSION['logged']['permission']) {
          case '1':
            header('location: ../pages/logged/admin.php');
          break;

          case '2':
            header('location: ../pages/logged/user.php');
            break;

          case '3':
            header('location: ../pages/logged/moderator.php');
            break;
        }

        exit();
  }

  if (!empty($_POST['email']) && !empty($_POST['pass'])) {
    require_once './connect.php';
    if ($conn->connect_errno != 0) {
      $_SESSION['error'] = 'Błędne połączenie z bazą danych!';
      header('location: ../');
      exit();
    }

    $email = htmlentities($_POST['email'], ENT_QUOTES, "UTF-8");
    $pass = htmlentities($_POST['pass'], ENT_QUOTES, "UTF-8");

    // $sql = "SELECT * FROM user WHERE email='$email' && pass='$pass'";

    $sql = sprintf("SELECT * FROM user WHERE email='%s'",
           mysqli_real_escape_string($conn, $email));

    if ($result = $conn->query($sql)) {
      $count = $result->num_rows;
      if ($count == 1) {
        //email w bazie, sprawdzamy hasło
        $row=$result->fetch_assoc();
        $passdb = $row['pass'];

        if (password_verify($pass, $passdb)) {
        //sprawdzenie czy użytkownik jest aktywny w bazie user (active==1)
        if ($row['active'] == 0) {
          $_SESSION['error'] = 'Użytkownik jest nieaktywny!';
          header('location: ../');
          exit();

        }

        //prawidłowy login i hasło
        $_SESSION['logged']['permission'] = $row['permissionid'];
        $_SESSION['logged']['name'] = $row['name'];
        $_SESSION['logged']['surname'] = $row['surname'];
        $_SESSION['logged']['email'] = $row['email'];
        $_SESSION['logged']['avatar'] = $row['avatar'];

        //aktualizacja daty i czasu ostatniego zalogowania do systemu
        $date = date("Y-m-d H:i:s");
        $email = $_SESSION['logged']['email'];
        $sql = "UPDATE `user` SET `last_login`= '$date' WHERE `email` = '$email'";

        $conn->query($sql);

        //sprawdzenie uprawnień
        // echo $_SESSION['logged']['permission'], $_SESSION['logged']['email'];

        switch ($_SESSION['logged']['permission']) {
          case '1':
            header('location: ../pages/logged/admin.php');
          break;

          case '2':
            header('location: ../pages/logged/user.php');
            break;

          case '3':
            header('location: ../pages/logged/moderator.php');
            break;

          case '4':
            header('location: ../pages/logged/banned.php');
        }

        exit();
      }
      // else {
      //   echo 'Invalid password db.';
      // }
      }
        $_SESSION['error'] = 'Podany login lub hasło jest błędne!';
        header('location: ../');
        exit();

    }else{
      echo "Błędne zapytanie!";
    }

  }else{
    $_SESSION['error'] = 'Wypełnij wszystkie pola!';
    header('location: ../');
  }
?>
