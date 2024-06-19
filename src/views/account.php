<?php
include("src/INC/includes.php");
includeHeader();
includeNavbar($travelAdvices, $user);

// var_dump($user);
// die();

if (isset($_POST["submit"])) {
    $name = $_POST["name"];
    if ($_FILES["image"]["error"] === 4) {
        echo "<script> alert('Image does not exist'); </script>";
    } else {
        $fileName = $_FILES["image"]["name"];
        $fileSize = $_FILES["image"]["size"];
        $tmpName = $_FILES["image"]["tmp_name"];

        $validImageExtension = ["png", "jpg", "jpeg"];
        $imageExtension = explode('.', $fileName);
        $imageExtension = strtolower(end($imageExtension));
        if (!in_array($imageExtension, $validImageExtension)) {
            echo "<script> alert('Invalid Image Extension'); </script>";
        } else if ($fileSize > 1000000) {
            echo "<script> alert('Image Size Is Too Large'); </script>";
        } else {
            $newImageName = uniqid() . '.' . $imageExtension;
            $destinationPath = "src/IMG/PROFILEIMG/" . $newImageName;

            if (move_uploaded_file($tmpName, $destinationPath)) {
                $query = "UPDATE users SET image = ? WHERE username = ?";
                $stmt = $connection->prepare($query);
                $stmt->bind_param("ss", $newImageName, $username);
                $stmt->execute();
                $stmt->close();
                echo "<script> alert('Image Uploaded Successfully'); </script>";
                // Refresh the image path
                $imagePath = $newImageName;
            } else {
                echo "<script> alert('Failed to upload image'); </script>";
            }
        }
    }
}
?>

<div class="account">
    <div class="container">
        <h1 class="welcomeText">Welcome <?php echo $_SESSION["username"]; ?>!</h1>
        <div class="accountLine"></div>
        <div class="accountBox">
            <h2>Account details</h2>
            <form method="POST" enctype="multipart/form-data">
                <div>
                    <img src="/Travelime/src/IMG/PROFILEIMG/<?php echo $user['picture']; ?>" alt="Profile Picture"><br>
                    <label for="name">Image name: </label><br>
                    <input type="text" name="name" id="name" value="<?php echo $_SESSION["username"]; ?>" required><br>
                    <label for="image">Upload new profile picture: </label><br>
                    <input type="file" id="image" name="image" accept=".png, .jpg, .jpeg" />
                </div>
                <div>
                    <button type="submit" name="submit">Upload</button>
                </div>
            </form>
        </div>
        <div class="accountBox">
            <h2>Your bookmarks</h2>
            <?php foreach ($_SESSION["bookmarks"] as $bookmark) {
                echo "<p>$bookmark</p>";
            } ?>
        </div>
    </div>
</div>

<?php
includeFooter();
