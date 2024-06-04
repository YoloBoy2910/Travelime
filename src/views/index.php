<?php
include("src/INC/includes.php");

includeHeader();
?>

<div class="ageSelectorPage">
    <div class="ageSelectorBG"></div>
    <div class="ageSelectorHL"></div>
    <div class="ageSelectorLogo"></div>
    <div class="ageSelectorDiv">
        <div class="ageSelectorDiv2">
            <h1 class="travelime">TRAVELIME</h1>
            <h2 class="travelimeDesc">Please enter your age for the best user experience.</h2>
            <?php
                if(isset($_SESSION['message'])) {
                    ?><p><?php echo $_SESSION['message']; ?></p><?php
                    unset($_SESSION['message']);
                }
            ?>
            <form action="/guestage" method="POST">
                <input class="ageSelector" type="number" name="age" min="18" max="120" placeholder="ENTER AGE HERE" required>
                <button class="ageSelectorBtn" type="submit">CONTINUE</button>
            </form>
        </div>
    </div>
</div>