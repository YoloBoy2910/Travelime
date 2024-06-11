<?php
include("src/INC/includes.php");
include("src/INC/functions.php");

includeHeader();
includeNavbar($travelAdvices);
?>

<div style="color: white;">
    <h1>W.I.P... Imagine some hotels here or something....</h1>
    <?php
        if(isset($country)) {
            echo "You selected: $country!";
        }
    ?>
</div>
<?php
includeFooter();