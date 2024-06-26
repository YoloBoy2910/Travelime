<?php
include("src/INC/includes.php");

includeHeader();
includeNavbar();

// var_dump($user);
// die();

if (isset($_POST["submit"])) {

    // Ensure all necessary POST variables are set
    if (isset($_POST["username"], $_FILES["image"])) {
        $username = $_POST["username"];
        $name = $_POST["name"];
        
        if ($_FILES["image"]["error"] === 4) {
            echo "<script>alert('Image does not exist');</script>";
        } else {
            $fileName = $_FILES["image"]["name"];
            $fileSize = $_FILES["image"]["size"];
            $tmpName = $_FILES["image"]["tmp_name"];

            $validImageExtension = ["png", "jpg", "jpeg"];
            $imageExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            if (!in_array($imageExtension, $validImageExtension)) {
                echo "<script>alert('Invalid Image Extension');</script>";
            } else if ($fileSize > 1000000) { // Check file size
                echo "<script>alert('Image Size Is Too Large');</script>";
            } else {
                // Generate a unique image name
                $newImageName = uniqid() . '.' . $imageExtension;
                $destinationPath = "src/IMG/PROFILEIMG/" . $newImageName;

                // Move the uploaded file to the desired directory
                if (move_uploaded_file($tmpName, $destinationPath)) {
                    // Database connection
                    $servername = "localhost";
                    $dbUsername = "root";
                    $dbPassword = "";
                    $dbName = "travelime";

                    $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbName);

                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $query = "UPDATE users SET picture = ? WHERE username = ?";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("ss", $newImageName, $username);

                    if ($stmt->execute()) {
                        echo "<script>alert('Image Uploaded Successfully');</script>";
                        // Refresh the image path
                        $imagePath = $newImageName;
                    } else {
                        echo "<script>alert('Failed to update database');</script>";
                    }

                    $stmt->close();
                    $conn->close();
                } else {
                    echo "<script>alert('Failed to upload image');</script>";
                }
            }
        }
    } else {
        echo "<script>alert('Form data is incomplete');</script>";
    }
}
?>

<div class="account">
    <div class="container">
        <h1 class="welcomeText">Welcome <?php if (isset($_SESSION['username'])) echo $_SESSION["username"];
                                        else echo "Guest" ?>!</h1>
        <div class="accountLine"></div>
        <?php
        if (isset($_SESSION['username'])) {
        ?>
            <div class="accountBox container">
                <div class="row">
                    <div class="col-6">
                        <h2>Account details</h2>
                        <form method="POST" enctype="multipart/form-data">
                            <div>
                                <img src="/Travelime/src/IMG/PROFILEIMG/<?php echo $user['picture']; ?>" alt="Profile Picture"><br>
                                <label for="name">Image name: </label><br>
                                <input type="text" name="name" id="name" value="<?php echo $_SESSION["username"]; ?>" required><br>
                                <label for="image">Upload new profile picture: </label><br>
                                <input type="file" id="image" name="image" accept=".png, .jpg, .jpeg" required><br>

                                <!-- Hidden input to pass username -->
                                <input type="hidden" name="username" value="<?php echo $_SESSION['username']; ?>">
                            </div>
                            <div>
                                <button type="submit" name="submit">Upload</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        <?php
        } else {
        ?>
            <div class="accountBox">
                <h3>You're currently logged in as a guest. Create an account or login to have your bookmarked hotels saved!</h3>
            </div>
        <?php
        }
        ?>
        <div class="bookmarksBox">
            <h2>Your bookmarks</h2>
            <div id="bookmarks" class="bookmarks">
                <?php
                if (isset($hotels) && count($hotels) > 0) {
                    foreach ($hotels as $hotel) {
                ?>
                        <div class="bookmark col-md-3">
                            <h4><?php echo $hotel['hotelName']; ?></h4>
                            <img src="<?php echo $hotel['hotelImage']; ?>" alt="" width="300" height="200">
                            <p><?php echo !empty($hotel['hotelRating']) ? $hotel['hotelRating'] . "⭐" : "No ratings found"; ?></p>
                            <button class="remove-hotel-button" id="<?php echo $hotel['hotelId']; ?>">Remove bookmark</button>
                        </div>
                    <?php
                    }
                } else {
                    ?>
                    <h3>No hotels bookmarked yet. Time to search for some hotels!</h3>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php
includeFooter(["account"]);
