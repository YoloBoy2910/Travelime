<?php

function registerForm() {
    ?>
  <div>
    <div class="ageSelectorBG"></div>
    <div class="ageSelectorHL"></div>
    <div class="ageSelectorLogo"></div>
    <div class="container">
      <div class="loginE">
        <form method="POST" action="/register/createuser">
          <H1>Register here</H1>
          <input type="text" name="username" placeholder="Enter your username or email" required>
          <input type="password" name="password" placeholder="Enter your password" required>
          <input type="password" name="passwordcheck" placeholder="confirm password" required>
          <?php 
            if(isset($_SESSION['message'])) {
                ?><p><?php echo $_SESSION['message']; ?></p><?php
                unset($_SESSION['message']);
            }
          ?>
          <button type="submit" name="register">Create new user</button>
        </form>
        <a href="/login" class="row-md-6">Already registered? Click here to login.</a>
        <a href="/home" class="row-md-6">Prefer to go as guest?</a>
      </div>
    </div>
  </div>
<?php

}