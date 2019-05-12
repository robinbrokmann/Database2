<?php session_start(); ?>
<html>
<style>
    body {
        background-image: url("verjaardag.jpg");
        background-size: cover;
    }
    form {
        font-size: 27px;
        text-align: center;
        background: rgba(202, 248, 255, 0.5);
        width: 30%;
        margin: 0 auto;
        border: 1px black solid;
    }
    label {
        display: inline-block;
        width: 100px;
        margin-bottom: 10px;
    }
</style>
<body>
<?php
$conn = new mysqli("localhost", "DC", "admin", "db_level2_opdr1");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$naam = "";
$omschrijving = "";
$prijs = "";
$winkel = "";
$link = "";
$id = "";

if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
    $sql = "SELECT * FROM verlanglijstje where Id = $id;";

    if (!$result = $conn->query($sql)) {
        die('There was an error running the query [' . $conn->error . ']');
    }

    if ($row = $result->fetch_assoc()) {
        $naam = $row['naam'];
        $omschrijving = $row['omschrijving'];
        $prijs = $row['prijs'];
        $winkel = $row['winkel'];
        $link = $row['link'];
    }
}

echo

$message = "";
if ($id) {
    $message = "Item Aanpassen";
} else {
    $message = "Item Toevoegen";
}
echo "</u><br>";

if (isset($_POST['back'])) {
    header("Location: oefenopdracht8-overzicht.php");
    exit();
} else if (isset($_POST['submit'])) {
    $naam = mysqli_real_escape_string($conn, $_POST["naam"]);
    $omschrijving = mysqli_real_escape_string($conn, $_POST["omschrijving"]);
    $prijs = mysqli_real_escape_string($conn, $_POST["prijs"]);
    $winkel = mysqli_real_escape_string($conn, $_POST["winkel"]);
    $link = mysqli_real_escape_string($conn, $_POST["link"]);

    if ($id) {
        $sql = "UPDATE verlanglijstje SET naam = '$naam', omschrijving = '$omschrijving', prijs = '$prijs', winkel = '$winkel', link = '$link' WHERE Id = '$id'";

        if ($conn->query($sql) === TRUE) {
            echo "Record updated successfully";
            header("Location: oefenopdracht8-overzicht.php");
            $conn->close();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
            $conn->close();
        }
    } else {
        $sql = "INSERT into verlanglijstje (Naam, Prijs, Omschrijving, Winkel, link) values ('$naam', '$prijs', '$omschrijving', '$winkel', '$link')";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
            header("Location: oefenopdracht8-overzicht.php");
            $conn->close();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
            $conn->close();
        }
    }
}

?>


<form action="" method="post">
    <label>Naam: </label><br>
    <input style="margin-top: 10px;" type="text" name="naam" value="<?php echo $naam ?>"><br>
    <label>Omschrijving: </label><br>
    <input type="text" name="omschrijving" value="<?php echo $omschrijving ?>"><br>
    <label>Prijs: </label><br>
    <input type="text" name="prijs" value="<?php echo $prijs ?>"><br>
    <label>Winkel: </label><br>
    <input type="text" name="winkel" value="<?php echo $winkel ?>"><br>
    <label>Link: </label><br>
    <input type="text" name="link" value="<?php echo $link ?>"><br>
    <input style="margin-bottom: 10px" name="submit" type="submit" value="<?php echo $message?>">
    <input type="submit" name="back" value="Naar overzicht">
</form>
</body>

