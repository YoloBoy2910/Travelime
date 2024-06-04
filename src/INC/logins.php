<?php

function LoginForm()
{
?>
  <div>
    <div class="ageSelectorBG"></div>
    <div class="ageSelectorHL"></div>
    <div class="ageSelectorLogo"></div>
    <div class="container">
      <div class="loginE">
        <form method="POST" action="/login/authenticate">
          <H1>Log In Here</H1>
          <input type="text" name="username" placeholder="Enter your username or email" required>
          <input type="password" name="password" placeholder="Enter your password" required>
          <?php 
            if(isset($_SESSION['message'])) {
                ?><p><?php echo $_SESSION['message']; ?></p><?php
                unset($_SESSION['message']);
            } 
          ?>
          <button type="submit" name="login">Login</button>
        </form>
        <a href="/register" class="row-md-6">Register a new user</a>
        <a href="/home" class="row-md-6">Use the website as a guest</a>
      </div>
    </div>
  </div>
<?php
}