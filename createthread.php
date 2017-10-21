<!DOCTYPE html>
<html>
    <head>
        <title>HASKREM - Create thread</title>
        <link rel="stylesheet" type="text/css" href="css/seemessages.css">
    </head>
    <body>
        <h1>Create thread</h1>
        <p><a href="index.php">Back to main page</a></p>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            Thread subject:<br>
            <input type="text" name="namethread" value="(no subject)">
            <br>
            Message:<br>
            <textarea name="message" rows="10" cols="30">Praise kek</textarea>
            <br>
            Link:<br>
            <input type="text" name="link" value="(no link)">
            <input type="submit">
        </form>
        <br>
        <?php
            $mysql_server = "";
            $mysql_user = "";
            $mysql_pass = "";
            $mysql_db = "";
        
            $conn = mysqli_connect($mysql_server, $mysql_user, $mysql_pass, $mysql_db);
            if (!$conn) {
                die("Connection to MySQL server failed - " . mysqli_connect_error());
            }
            
            function sendresults($subject, $msg, $link, $conn) {
                $timestamp = time();
                
                $sql = "INSERT INTO haskrem_posts (upvotes, subject, date, message)
                VALUES ('1','" . $subject ."', '" . $timestamp ."', '" . $msg . "')";
        
                if ($conn->query($sql) === TRUE) {
                    echo "New record created successfully";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
                
                if (preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$link)) {
                    $sql2 = "INSERT INTO haskrem_links (postid, link)
                    VALUES ('" . $timestamp . "','" . $link ."')";
                    if ($conn->query($sql2) === TRUE) {
                        $conn->close();
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                        $conn->close();
                    }
                } else {
                    $conn->close();   
                }
            }
        
            function test_input($data) {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }    
        
            $threadname = $message = "";
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $threadname = test_input($_POST["namethread"]);
                $message = test_input($_POST["message"]);
                $link = test_input($_POST["link"]);
            }
        
            if ($threadname) {
                if ($message) {
                    sendresults(mysqli_real_escape_string($conn, $threadname), mysqli_real_escape_string($conn, $message), mysqli_real_escape_string($conn, $link), $conn);
                }
            }
        ?>
    </body>
</html>
