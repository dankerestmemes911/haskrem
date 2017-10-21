<!DOCTYPE html>
<html>
    <head>
        <title>Haskrem - See message</title>
        <link rel="stylesheet" type="text/css" href="css/seemessages.css">
    </head>
    <body>
        <a href="index.php">Go to main page</a>
        <?php
            $mysql_server = "";
            $mysql_user = "";
            $mysql_pass = "";
            $mysql_db = "";
                
            $nrofinput = $sortby = isset($_GET['nr']) ? (int)$_GET['nr'] : null;
        
            $conn = mysqli_connect($mysql_server, $mysql_user, $mysql_pass, $mysql_db);
            
            if (!$conn) {
                die("Connection to MySQL server failed - " . mysqli_connect_error());
            }

            $sql = "SELECT upvotes, subject, date, message FROM haskrem_posts WHERE date = '" . $nrofinput . "'";
            $sql3 = "SELECT link FROM haskrem_links WHERE postid = '" . $nrofinput . "'";
            $results3 = mysqli_query($conn, $sql3);
            $results = mysqli_query($conn, $sql);
            $result = $results->fetch_assoc();
        
            echo "<h1>" . $result["subject"] . "</h1>";
            echo "<p>Upvotes: " . $result["upvotes"] . "</p>";
            echo "<p>Created on: " . gmdate('Y-m-d \ H:i:s', $result['date']) . "</p>";
            if ($results3->num_rows > 0) {
                while($row = $results3->fetch_assoc()) {
                    echo "<a href=" . $row['link'] . ">Go to inserted link</a>";
                }
            }
            echo "<form method='post'><input type='submit' name='upvote' value='Upvote'><input type='submit' name='downvote' value='Downvote'></form>";
            echo "<p>" . $result["message"] . "</p>";
        
            $sql2 = "SELECT title, message, date FROM haskrem_comments WHERE postid = " . $nrofinput . " ORDER BY date DESC";
            $result2 = mysqli_query($conn, $sql2);
        
            echo "<form method='get' action='createcomment.php'>Post ID:<br><input type='text' name='postid' value='" . $nrofinput . "'><br>Comment title:<br><input type='text' name='titlecomment' value='(no subject)'><br>Message:<br><textarea name='comment' rows='10' cols='30'>Praise kek</textarea><br><input type='submit'></form>";
            if ($result2->num_rows > 0) {
                echo "<h2>Comments</h2>";
                while($row = $result2->fetch_assoc()) {
                    echo "<a href=seecomments.php?nr=" . $row['date'] . "><h3>" . $row['title'] . "</h3></a>";
                    echo "<p>" . $row['message'] . "</p>";
                }
            } else {
                echo "<h2>No comments found</h2>";
            }
        
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (isset($_POST['upvote'])) {
                    $upvotesql = "UPDATE haskrem_posts SET upvotes=upvotes + 1 WHERE date=" . $result["date"];   
                    if ($conn->query($upvotesql) === TRUE) {
                        echo "Successfully upvoted";
                    }
                } elseif (isset($_POST['downvote'])) {
                    $upvotesql = "UPDATE haskrem_posts SET upvotes=upvotes - 1 WHERE date=" . $result["date"];   
                    if ($conn->query($upvotesql) === TRUE) {
                        echo "Successfully downvoted";
                    }
                }
            }
            $conn->close();
        ?>
    </body>
</html>
