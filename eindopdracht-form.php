<?php session_start(); ?>
<html>
<style>
    body {
        background-image: url("verjaardag.jpg");
        background-size: cover;
    }
    form {
        font-size: 27px;
        background: rgba(202, 248, 255, 0.5);
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

$naam = "";
$achternaam = "";
$geboortedatum = "";
$id = "";

if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
    $sql = "SELECT * FROM verjaardagen where Id = $id;";

    if (!$result = $conn->query($sql)) {
        die('There was an error running the query [' . $conn->error . ']');
    }

    if ($row = $result->fetch_assoc()) {
        $naam = $row['naam'];
        $achternaam = $row['achternaam'];
        $geboortedatum = $row['geboortedatum'];
    }
}

echo

$message = "";
if ($id) {
    $message = "Aanpassen";
} else {
    $message = "Toevoegen";
}

if (isset($_POST['back'])) {
    header("Location: eindopdracht-overzicht.php");
    exit();
} else if (isset($_POST['submit'])) {
    $naam = mysqli_real_escape_string($conn, $_POST["naam"]);
    $achternaam = mysqli_real_escape_string($conn, $_POST["achternaam"]);
    $geboortedatum = strtotime(mysqli_real_escape_string($conn, $_POST["geboortedatum"]));
    $geboortedatum = date("Y-m-d", $geboortedatum);
    if ($id) {
        $sql = "UPDATE verjaardagen SET naam = '$naam', achternaam = '$achternaam', geboortedatum = '$geboortedatum' WHERE Id = '$id'";

        if ($conn->query($sql) === TRUE) {
            echo "Record updated successfully";
            header("Location: eindopdracht-overzicht.php");
            $conn->close();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
            $conn->close();
        }
    } else {
        $sql = "INSERT into verjaardagen (naam, achternaam, geboortedatum) values ('$naam', '$achternaam', '$geboortedatum')";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
            header("Location: eindopdracht-overzicht.php");
            $conn->close();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
            $conn->close();
        }
    }
}

?>


<form action="" method="post">
    <label>Naam: </label><br><input style="margin-top: 10px;" type="text" name="naam" value="<?php echo $naam ?>"><br>
    <label>Achternaam: </label><br><input type="text" name="achternaam" value="<?php echo $achternaam ?>"><br>
    <label>Geboortedatum: </label><br><input type="text" name="geboortedatum" value="<?php echo $geboortedatum ?>"><br>
    <input style="margin-bottom: 10px" name="submit" type="submit" value="<?php echo $message?>">
    <input type="submit" name="back" value="Naar overzicht">
</form>
</body>
