<?php
session_start();
session_unset()
?>

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
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['submit'])) {
        $key = explode("-", key($_POST));

        if ($key[0] == "delete") {
            deleteRecord($key[1]);
        } elseif ($key[0] == "edit") {
            $_SESSION["id"] = $key[1];
        }
    }
    header("Location: opdracht5-form.php");

    exit();
}
$servername = "localhost";
$databasename = "db_level2_opdr1";
$username = "DC";
$password = "admin";

$conn = new mysqli($servername, $username, $password, $databasename);
if($conn->connect_error){
    die("connection failed: " . $conn->connect_error);
}
$db = getDatabase();
$sql = "SELECT * FROM songs";

if (!$result = $conn->query($sql)) {
    die('There was an error running the query [' . $conn->error . ']');
}

echo '<table>';

echo '<tr>';
echo '<th>Artiest</th>';
echo '<th>Titel</th>';
echo '<th></th>';
echo '<th></th>';
echo '</tr>';

while ($row = $result->fetch_assoc()) {
    echo '<tr>';
    echo '<td>' . $row['artist'] . '</td>';
    echo '<td>' . $row['title'] . '</td>';
    $id = $row['id'];
    echo "<form action='' method='post'>";
    echo "<td><input type='submit' name='edit-$id' value='wijzigen'>";
    echo "<td><input type='submit' name='delete-$id' value='Verwijderen'>";
    echo '</tr>';
}

echo '</table>';

$result->free();
$conn->close();

function deleteRecord($id)
{
    $conn = getDatabase();

    $sql = "DELETE from songs where Id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    header("Location: opdracht5-overzicht.php");
    exit();
}
function getDatabase(){
    $db = new mysqli("localhost", "DC", "admin", "db_level2_opdr1");

    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }
    return $db;
}
?>
?>

<div style="margin-top: 20px">
    <form action="" method="post">
        <input type="submit" name="submit" value="nummer toevoegen">
    </form>
</div>
</body>
</html>