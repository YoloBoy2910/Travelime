<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  handlePOST();
}

function handlePOST()
{
  if (isset($_POST['login'])) {
    authenticate();
  }
  else if(isset($_POST['age'])) {
    setAge();
  }
}

function authenticate()
{

  $username = $_POST['userName'];
  $password = $_POST['userPassword'];

  $db = db_connect_temp();

  $statement = $db->prepare("SELECT username, `password` FROM users WHERE username = ?");

  if ($statement) {
    $statement->bind_param("s", $_POST['userName']);

    $statement->execute();

    $result = $statement->get_result();

    if (!$result) {
      die("Something went wrong. Error: " . $statement->error);
    }

    if ($result->num_rows > 1) {
      $_SESSION['message'] = "User " . $_POST['userName'] . " exists multiple times in the database, contact the user owners!";
    } else if ($result->num_rows < 0) {
      $_SESSION['message'] = "User " . $_POST['userName'] . " not found.";
    } else {
      $credentials = $result->fetch_row();

      $username = $credentials[0];
      $password = $credentials[1];

      if (password_verify($_POST['userPassword'], $password)) {
        $_SESSION['logged-in'] = 1;
        $_SESSION['message'] = "Login succesful, Welcome " . $username . "!";
      } else {
        $_SESSION['message'] = "Password is invalid.";
      }
    }
  }
  $statement->close();
  $db->close();

  //If login succesful redirect to the home page else redirect back to login.
  if (isset($_SESSION['logged-in']) && $_SESSION['logged-in'] == 1) {
    header("Location: home.php");
  } else {
    header("Location: login.php");
  }
  exit;
}

function setAge() {
  
}

function LoginForm()
{
?>
  <div>
    <div class="ageSelectorBG"></div>
    <div class="ageSelectorHL"></div>
    <div class="ageSelectorLogo"></div>
    <div class="container">
      <div class="loginE">
        <form method="POST">
          <H1>Log In Here</H1>
          <input type="text" name="userName" placeholder="Enter your username or email" required>
          <input type="password" name="userPassword" placeholder="Enter your password" required>
          <?php 
            if(isset($_SESSION['message'])) {
                ?><p><?php echo $_SESSION['message']; ?></p><?php
                unset($_SESSION['message']);
            }
          ?>
          <button type="submit" name="login">Login</button>
        </form>
        <a href="register.php" class="row-md-6">Register a new user</a>
        <a href="index.php" class="row-md-6">Use the website as a guest</a>
      </div>
    </div>
  </div>
<?php
}
