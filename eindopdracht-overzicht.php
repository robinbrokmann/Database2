<?php
session_start();
session_unset()
?>

<html>
<style>
    body {
        background-image: url("verjaardag.jpg");
        background-size: cover;
    }
    table , td {
        font-size: 27px;
        background: rgba(202, 248, 255, 0.5);
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
    header("Location: eindopdracht-form.php");

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
$sql = "SELECT * FROM verjaardagen";

if (!$result = $conn->query($sql)) {
    die('There was an error running the query [' . $conn->error . ']');
}

echo '<table>';

echo '<tr>';
echo '<th>Naam</th>';
echo '<th>Achternaam</th>';
echo '<th>Geboortedatum</th>';
echo '<th>Leeftijd</th>';
echo '<th></th>';
echo '<th></th>';
echo '</tr>';

while ($row = $result->fetch_assoc()) {
    echo '<tr>';
    echo '<td>' . $row['naam'] . '</td>';
    echo '<td>' . $row['achternaam'] . '</td>';
    $birthdate = $row['geboortedatum'];
    $birthDateArray = explode("-", $birthdate);
    echo '<td>' . $birthDateArray[2] . "-" . $birthDateArray[1] . "-" . $birthDateArray[0] . "</td>";
    $date1 = new DateTime("now");
    $date2 = new DateTime($birthdate);
    $age = $date1 -> diff($date2);
    echo '<td>' . $age->y . " Jaar, " . $age->m . " Maanden, " . $age->d . " Dagen" ."</td>";
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

    $sql = "DELETE from verjaardagen where Id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    header("Location: eindopdracht-overzicht.php");
    exit();
}
function getDatabase(){
    $conn = new mysqli("localhost", "DC", "admin", "db_level2_opdr1");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}
?>


<div style="margin-top: 20px">
    <form action="" method="post">
        <input type="submit" name="submit" value="verjaardag toevoegen">
    </form>
</div>
</body>
</html>