<?php
function registerForm()
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
                                    <form action="/Travelime/register/createuser" method="POST" autocomplete="off">

                                        <div class="d-flex align-items-center mb-3 pb-1">
                                            <span class="h1 fw-bold mb-0">TRAVELIME</span>
                                        </div>

                                        <div data-mdb-input-init class="form-outline mb-4">
                                            <label class="form-label" for="username">Username or Email</label>
                                            <input type="text" name="username" placeholder="Enter your username or email" class="form-control form-control-lg" required>
                                        </div>

                                        <div data-mdb-input-init class="form-outline mb-4">
                                            <label class="form-label" for="password">Password</label>
                                            <input type="password" name="password" placeholder="Enter your password" class="form-control form-control-lg" required>
                                        </div>

                                        <div data-mdb-input-init class="form-outline mb-4">
                                            <label class="form-label" for="password">Repeat password</label>
                                            <input type="password" name="passwordcheck" placeholder="Repeat you password" class="form-control form-control-lg" required>
                                        </div>

                                        <?php
                                        if (isset($_SESSION['message'])) { ?>
                                            <p><?php echo $_SESSION['message']; ?></p>
                                        <?php unset($_SESSION['message']);
                                        }
                                        ?>

                                        <div class="pt-1 mb-4">
                                            <button class="btn btn-dark btn-lg btn-block" type="submit" name="register">Create new user</button>
                                        </div>

                                        <a href="/Travelime/login" class="loginLink row-md-6">Already registered? Click here to login</a><br>
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
