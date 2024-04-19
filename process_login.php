<?php
// Adatbázis kapcsolat létrehozása
$servername = "localhost";
$username = "root";
$password = "";
$database = "MHEI";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Űrlapból érkező adatok feldolgozása
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Példa SQL lekérdezés a felhasználó ellenőrzésére
    // Fontos: Használj készített utasításokat (prepared statements) az SQL Injection támadások elkerülése érdekében!
    $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    // Ellenőrizd, hogy van-e találat
    if ($result->num_rows > 0) {
        // Sikeres bejelentkezés esetén átirányítás
        header("Location: Profil.html");
        exit();
    } else {
        // Sikertelen bejelentkezés esetén kezelés (pl. hibaüzenet megjelenítése)
        echo "Hibás felhasználónév vagy jelszó!";
    }
}

$conn->close();
?>