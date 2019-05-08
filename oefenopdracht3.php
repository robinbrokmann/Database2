<html>
<style>
    body {
        background-image: url("background.jpg");
        background-size: cover;
    }
    table , td {
        font-size: 27px;
        background: rgba(202, 248, 255, 0.5);
        opacity: 0.6;
        margin-left: auto;
        margin-right: auto;
        border: 1px black solid;
    }
    div {
        font-size: 30px;
        text-align: center;
        color: white;
    }
</style>
<body>
<?php
if(isset($_POST['submit'])) {
    header("Location: Oefenopdracht4.php");
}

$servername = "localhost";
$databasename = "db_level2_opdr1";
$username = "DC";
$password = "admin";

$conn = new mysqli($servername, $username, $password, $databasename);
if($conn->connect_error){
    die("connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM songs";

if (!$result = $conn->query($sql)) {
    die('There was an error running the query [' . $conn->error . ']');
}

echo '<table>';

echo '<tr>';
echo '<th>Artiest</th>';
echo '<th>Titel</th>';
echo '</tr>';

while ($row = $result->fetch_assoc()) {
    echo '<tr>';
    echo '<td>' . $row['artist'] . '</td>';
    echo '<td>' . $row['title'] . '</td>';
    echo '</tr>';
}

echo '</table>';

$result->free();
$conn->close();
?>

<div style="margin-top: 20px">
<form action="" method="post">
    <input type="submit" name="submit" value="nummer toevoegen">
</form>
</div>
</body>
</html>