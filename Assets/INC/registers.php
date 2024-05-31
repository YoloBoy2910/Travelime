<?php

if($_SERVER['REQUEST_METHOD'] == "POST") {
    handlePOST();
}

function handlePOST() {
    if(isset($_POST['register'])) {
        register();
    }
}

function register() {
    $username = $_POST['userName'];
    $password = $_POST['userPassword'];
    $passwordCheck = $_POST['userPasswordCheck'];

    if($password != $passwordCheck) {
        $_SESSION['message'] = "Passwords don't match.";
    }
    else {
        $db = db_connect_temp();

        $statement = $db->prepare("SELECT username FROM users WHERE username = ?");

        if($statement) {

            $statement->bind_param("s", $username);

            $statement->execute();

            $result = $statement->get_result();

            if(!$result) {
                die("Something went wrong. Error: " . $statement->error);
            }

            if($result->num_rows > 0 ) {
                $_SESSION['message'] = "The user " . $username . " already exists.";
            }
            else {
                $hash = password_hash($password, PASSWORD_DEFAULT);

                $statement = $db->prepare("INSERT INTO users (username, `password`) values (?, ?)");

                if($statement) {

                    $statement->bind_param("ss", $username, $hash);

                    $statement->execute();

                    $result = $statement->get_result();

                    if($result) {
                        $_SESSION['logged-in'] = 1;
                        $_SESSION['username'] = $username;
                        $_SESSION['message'] = "Succesfully created new user! Welcome " . $username . "!";
                    } else {
                        $_SESSION['message'] = "Unable to create new user something went wrong. Error: " . $statement->error;
                    }
                }
            }
        }
    }
    $db->close();
    $statement->close();

    if(isset($_SESSION['logged-in']) && $_SESSION['logged-in'] == 1) {
        header("Location: home.php");
    } else {
        header("Location: register.php");
    }
    exit;
}

function registerForm() {
    ?>
  <div>
    <div class="ageSelectorBG"></div>
    <div class="ageSelectorHL"></div>
    <div class="ageSelectorLogo"></div>
    <div class="container">
      <div class="loginE">
        <form method="POST">
          <H1>Register here</H1>
          <input type="text" name="userName" placeholder="Enter your username or email" required>
          <input type="password" name="userPassword" placeholder="Enter your password" required>
          <input type="password" name="userPasswordCheck" placeholder="confirm password" required>
          <?php 
            if(isset($_SESSION['message'])) {
                ?><p><?php echo $_SESSION['message']; ?></p><?php
                unset($_SESSION['message']);
            }
          ?>
          <button type="submit" name="register">Create new user</button>
        </form>
        <a href="login.php" class="row-md-6">Already registered? Click here to login.</a>
        <a href="index.php" class="row-md-6">Prefer to go as guest?</a>
      </div>
    </div>
  </div>
<?php
}