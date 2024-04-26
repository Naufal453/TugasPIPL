
                <?php
                // Establish database connection
                $conn = new mysqli("localhost", "root", "", "alternate_arc");

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Retrieve story data based on the ID passed in the URL
                if (isset($_GET['id'])) {
                    $story_id = $_GET['id'];
                    
                    // Prepare and execute SQL query
                    $stmt = $conn->prepare("SELECT description FROM stories WHERE id = ?");
                    $stmt->bind_param("i", $story_id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        // Fetch story details
                        $row = $result->fetch_assoc();
                        $description = $row["description"];

                        // Output story description
                        echo '<h1 style="text-align: center;padding-top:10px;">' .'Synopsis' .'</h1><br>';
                        echo '<p>' . $description . '</p>';
                        
                    } else {
                        echo "Story not found.";
                    }
                    // Close the result set
                    $result->close();
                    // Close the statement
                    $stmt->close();
                } else {
                    echo "No story ID provided.";
                }

                // Close database connection
                $conn->close();
                
                ?>
  