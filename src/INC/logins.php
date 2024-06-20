<?php
function LoginForm()
{
?>

  <section class="vh-100">
    <div class="loginBG"></div>
    <div class="loginHL"></div>
    <div class="loginLogo"></div>
    <div class="container py-5 h-100">
      <div class="d-flex justify-content-center align-items-center h-100">
        <div class="loginBox col col-xl-10">
          <div class="card">
            <div class="row g-0">

              <div class="col-md-6 col-lg-5 d-none d-md-block">
                <img class="loginBanner" src="src/IMG/PromoDeal.webp" alt="login form" />
              </div>

              <div class="col-md-6 col-lg-7 d-flex align-items-center">
                <div class="card-body p-4 p-lg-5 text-black">
                  <form action="/Travelime/login/authenticate" method="POST" autocomplete="off">

                    <div class="d-flex align-items-center mb-3 pb-1">
                      <span class="h1 fw-bold mb-0">TRAVELIME</span>
                    </div>

                    <h5 class="fw-normal mb-3 pb-3 h4" style="letter-spacing: 1px;">Sign into your account</h5>

                    <div data-mdb-input-init class="form-outline mb-4">
                      <label class="form-label" for="username">Username or Email</label>
                      <input type="text" name="username" placeholder="Enter your username or email" class="form-control form-control-lg" required />
                    </div>

                    <div data-mdb-input-init class="form-outline mb-4">
                      <label class="form-label" for="password">Password</label>
                      <input type="password" name="password" placeholder="Enter your password" class="form-control form-control-lg" required />
                    </div>

                    <?php
                    if (isset($_SESSION['message'])) { ?>
                      <p><?php echo $_SESSION['message']; ?></p>
                    <?php unset($_SESSION['message']);
                    }
                    ?>

                    <div class="pt-1 mb-4">
                      <button class="btn btn-dark btn-lg btn-block" type="submit" name="login">Login</button>
                    </div>

                    <a href="/Travelime/register" class="loginLink row-md-6">Don't have an account yet? Register here</a><br>
                    <a href="/Travelime/home" class="loginLink row-md-6">Use the website as a guest</a>

                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php
}
