<html>
<style>

</style>
<body>
<?php

if(isset($_POST['back'])) {
    header("Location:Oefenopdracht3.php");
    exit();
} else if(isset($_POST['submit'])) {
    $db = new mysqli("localhost", "DC", "admin", "db_level2_opdr1");

    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    $artist = mysqli_real_escape_string($db, $_POST["artist"]);
    $title = mysqli_real_escape_string($db, $_POST["title"]);

    $sql = "INSERT into songs (artist, title) values ('$artist', '$title')";

    if ($db->query($sql) === TRUE) {
        echo "New record successfully created";
    } else {
        echo "Error: " . $sql . "<br>" . $db->error;
    }

    $db->close();
    header("Location: Oefenopdracht3.php");
}

?>
<form action="" method="post">
    <label>Artiest: </label><input style="margin-top: 10px;" type="text" name="artist"><br>
    <label>Titel van nummer: </label><input type="text" name="title"><br>
    <input style="margin-bottom: 10px" name="submit" type="submit" value="Nummer toevoegen">
    <input type="submit" name="back" value="Naar overzicht">
</form>
</body>
</html>
