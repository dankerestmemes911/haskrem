<!DOCTYPE html>
<html>
    <head>
        <title>Haskrem - See comment</title>
        <link rel="stylesheet" type="text/css" href="css/seemessages.css">
    </head>
    <body>
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

            $sql = "SELECT postid, title, message, date FROM haskrem_comments WHERE date = '" . $nrofinput . "'";
            $results = mysqli_query($conn, $sql);
            $result = $results->fetch_assoc();
        
            echo "<a href=seemessages.php?nr=" . $result['postid'] . ">Go to message</a>";
            echo "<h1>" . $result["title"] . "</h1>";
            echo "<p>Created on: " . gmdate('Y-m-d \ H:i:s', $result['date']) . "</p>";
            echo "<p>" . $result["message"] . "</p>";
        
            $sql2 = "SELECT title, message FROM haskrem_replies WHERE commentid = " . $result['date'] . " ORDER BY date DESC";
            $result2 = mysqli_query($conn, $sql2);
        
            echo "<form method='get' action='createreply.php'>Post ID:<br><input type='text' name='postid' value='" . $result['postid'] . "'><br>Comment ID:<br><input type='text' name='commentid' value='" . $nrofinput . "'><br>Title:<br><input type='text' name='titlecomment' value='(no subject)'><br>Message:<br><textarea name='comment' rows='10' cols='30'>Praise kek</textarea><br><input type='submit'></form>";
            if ($result2->num_rows > 0) {
                echo "<h2>Comments</h2>";
                while($row = $result2->fetch_assoc()) {
                    echo "<h3>" . $row['title'] . "</h3>";
                    echo "<p>" . $row['message'] . "</p>";
                }
            } else {
                echo "<h2>No replies found</h2>";
            }
            $conn->close();
        ?>
    </body>
</html>
