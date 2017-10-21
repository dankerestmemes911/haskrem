<?php
    $mysql_server = "";
    $mysql_user = "";
    $mysql_pass = "";
    $mysql_db = "";

    $postid = $_GET["postid"];
    $commentid = $_GET["commentid"];
                
    $conn = mysqli_connect($mysql_server, $mysql_user, $mysql_pass, $mysql_db);
            
    if (!$conn) {
        die("Connection to MySQL server failed - " . mysqli_connect_error());
    }

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $title = mysqli_real_escape_string($conn, test_input($_GET["titlecomment"]));
    $message = mysqli_real_escape_string($conn, test_input($_GET["comment"]));
    $timestamp = time();

    $sql = "INSERT INTO haskrem_replies (postid, commentid, title, message, date)
            VALUES ('" . $postid . "','" . $commentid . "', '" . $title ."', '" . $message ."', '" . $timestamp . "')";

    if ($conn->query($sql) === TRUE) {
        header("Location: seemessages.php?nr=$postid");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
?>
