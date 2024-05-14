<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Redirect to login page
    header("Location: ../Login/login.php");
    exit;
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "alternate_arc";

// Establish connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch story based on ID
if(isset($_GET['id']) && !empty(trim($_GET['id']))){
    $story_id = $_GET['id'];
    
    $sql = "SELECT title, Fandom, Language, Status, Series, Characters, Relationship, Addtags FROM stories WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $story_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows === 1){
        $row = $result->fetch_assoc();
        
        // Now you can access the $row variable
        $title = $row["title"];
        $Fandom = $row["Fandom"];
        $Language = $row["Language"];
        $Status = $row["Status"];
        $Series = $row["Series"];
        $Characters = $row["Characters"];
        $Relationship = $row["Relationship"];
        $Addtags = $row["Addtags"];
        echo '<p>' . 'Title:' . ' ' . $title. '</p>';
        echo '<p>'. 'Fandom:' . ' '. $Fandom . '</p>';
        echo '<p>' .'Language:' .' '. $Language . '</p>';
        echo '<p>' . 'Status:' .' '.$Status. '</p>';
        echo '<p>' . 'Series:' .' '.$Series.'</p>';
        echo '<p>' . 'Characters:' .' '.$Characters . '</p>';
        echo '<p>' . 'Relationship:' .' '.$Relationship . '</p>';
        echo '<p>' . 'Tags:' .' '. $Addtags . '</p>';

    } else {
        echo "<p>Story not found.</p>";
    }
} else {
    echo "<p>Invalid story ID.</p>";
}

// Close connection
$stmt->close();
$conn->close();
?>
