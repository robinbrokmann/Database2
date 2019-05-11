<?php session_start(); ?>
<html>
<style>
    body {
        background-image: url("background.jpg");
        background-size: cover;
    }
    form {
        font-size: 27px;
        background: rgba(202, 248, 255, 0.5);
        opacity: 0.6;
        text-align: center;
        width: 30%;
        margin: 0 auto;
        border: 1px black solid;
    }
    label{
        display: inline-block;
        width: 100px;
        margin-bottom: 10px;
</style>
<body>
<?php
$conn = new mysqli("localhost", "DC", "admin", "db_level2_opdr1");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$artist = "";
$title = "";
$id = "";

if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
    $sql = "SELECT * FROM songs where Id = $id;";

    if (!$result = $conn->query($sql)) {
        die('There was an error running the query [' . $conn->error . ']');
    }

    if ($row = $result->fetch_assoc()) {
        $artist = $row['artist'];
        $title = $row['title'];
    }
}

echo "<div><u>";

$message = "";
if ($id) {
    $message = "Nummer Aanpassen";
} else {
    $message = "Nummer Toevoegen";
}
echo "</u><br>";

if (isset($_POST['back'])) {
    header("Location: opdracht5-overzicht.php");
    exit();
} else if (isset($_POST['submit'])) {
    $artist = mysqli_real_escape_string($conn, $_POST["artist"]);
    $title = mysqli_real_escape_string($conn, $_POST["title"]);

    if ($id) {
        $sql = "UPDATE songs SET artist = '$artist', title = '$title' WHERE Id = '$id'";

        if ($conn->query($sql) === TRUE) {
            echo "Record updated successfully";
            header("Location: opdracht5-overzicht.php");
            $conn->close();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
            $conn->close();
        }
    } else {
        $sql = "INSERT into songs (artist, title) values ('$artist', '$title')";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
            header("Location: opdracht5-overzicht.php");
            $conn->close();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
            $conn->close();
        }
    }
}

?>


<form action="" method="post">
    <label>Artiest: </label><input style="margin-top: 10px;" type="text" name="artist" value="<?php echo $artist ?>"><br>
    <label>Titel van lied: </label><input type="text" name="title" value="<?php echo $title ?>"><br>
    <input style="margin-bottom: 10px" name="submit" type="submit" value="<?php echo $message?>">
    <input type="submit" name="back" value="Naar overzicht">
</form>
</body>
</html>