<?php
include("src/INC/includes.php");
includeHeader();
includeNavbar();

if(isset($_POST["submit"])){
    $name = $_POST["name"];
    if($_FILES["image"]["error"] === 4){
        echo "<script> alert('Image does not exist'); </script>";
    }
    else {
        $fileName = $_FILES["image"]["name"];
        $fileSize = $_FILES["image"]["size"];
        $tmpName = $_FILES["image"]["tmp_name"];

        $validImageExtension = ['.png, .jpg, .jpeg'];
        $imageExtension = explode('.' , $fileName);
        $imageExtension = strtolower(end($imageExtension));
        if(!in_array($imageExtension, $validImageExtension)){
            echo "<script> alert('Invalid Image Extension'); </script>";
        }
        else if($fileSize > 1000000){
            echo "<script> alert('Image Size Is Too Large'); </script>";
        }
        else{
            $newImageName = uniqid();
            $newImageName .= '.' . $imageExtension;

            move_uploaded_file($tmpName, '/Travelime/src/IMG/PROFILEIMG/' ,$newImageName);
            $query = "INSERT INTO users VALUE('picture')";
        }
    }
}
?>

<!-- <?php dd($_SESSION); ?> -->

<div class="account">
    <div class="container">
        <h1>Welcome <?php echo $_SESSION["username"]; ?>!</h1>
        <div>
            <h2>Upload/Change profile picture</h2>
                <form method="POST" enctype="multipart/form-data">
                    <div>
                        <label for="name">Image Name : </label>
                        <input type="text" name="name" id="name" required value=""> <br>
                        <label for="image">Upload new profile picture</label>
                        <input type="file" id="image" name="image" accept=".png, .jpg, .jpeg" />
                    </div>
                    <div>
                        <button type="submit" name="submit">Upload</button>
                    </div>
                </form>
        </div>
        <div class="bookmarks">
            <h2>Your bookmarks</h2>
                <?php foreach ($_SESSION["bookmarks"] as $bookmarks) {
                } ?>
        </div>
    </div>
</div>

<?php
includeFooter();
