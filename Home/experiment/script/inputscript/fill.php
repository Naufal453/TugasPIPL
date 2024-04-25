            <!-- Story Listing -->
            <?php
                // Start session if not already started
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }

                // Check if user is logged in
                if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
                    // Redirect to login page
                    header("Location: .../Login/login.php");
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

                // Fetch the latest added story for the logged-in user
                $user_id = $_SESSION['user_id']; // Assuming you have stored the user ID in the session variable
                $sql = "SELECT title, author, description FROM stories WHERE user_id = ? ORDER BY id DESC LIMIT 1"; // Assuming 'id' is the primary key column
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    // Output the latest story
                    $row = $result->fetch_assoc();
                    echo '<div class="col">';
                    echo '<div class="card">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . $row["title"] . '</h5>';
                    echo '<h6 class="card-subtitle mb-2 text-muted">Author: ' . $row["author"] . '</h6>';
                    echo '<p class="card-text">' . $row["description"] . '</p>';
                    echo '</div>'; // close card-body
                    echo '</div>'; // close card
                    echo '</div>'; // close col
                } else {
                    echo "<div class='col'><p>No stories available.</p></div>";
                }

                // Close statement and connection
                $stmt->close();
                $conn->close();
                ?>
