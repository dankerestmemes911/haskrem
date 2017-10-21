<!DOCTYPE html>
<html>
    <head>
        <title>HASKREM - Main Page</title>
        <link rel="stylesheet" type="text/css" href="css/index.css">
    </head>
    <body>
        <h1>HASKREM</h1>
        <h2>No name, no delete button, no regrets.</h2>
        <a href="index.php?sortby=datedesc">Sort by date</a>
        <a href="index.php">Sort by upvotes</a>
        <a href="encrypted/index.php">Go to HASKREM Hashed</a>
        <table>
            <tr>
                <td>Upvotes: Over 9000</td>
                <td><a href="createthread.php">Create thread</a></td>
                <td>Created on: n/a</td>
            </tr>
            <?php
                // Beginning of settings
                $mysql_server = "";
                $mysql_user = "";
                $mysql_pass = "";
                $mysql_db = "";
                // Ending of settings
                
                $conn = mysqli_connect($mysql_server, $mysql_user, $mysql_pass, $mysql_db);
            
                if (!$conn) {
                    die("Connection to MySQL server failed - " . mysqli_connect_error());
                }
                
                $sql = "";
            
                $sortby = isset($_GET['sortby']) ? (int)$_GET['sortby'] : null;
                if ($sortby !== null) {
                    if ($_GET['sortby'] = "datedesc") {
                        $sql = "SELECT upvotes, subject, date FROM haskrem_posts ORDER BY date DESC";
                    } else {
                        $sql = "SELECT upvotes, subject, date FROM haskrem_posts ORDER BY upvotes DESC";
                    }
                } else {
                    $sql = "SELECT upvotes, subject, date FROM haskrem_posts ORDER BY upvotes DESC";
                }
            
                $result = mysqli_query($conn, $sql);
            
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr><td>Upvotes: " . $row['upvotes'] . "</td><td><a href='seemessages.php?nr=" . $row['date'] . "'>" . $row["subject"] . "</a></td><td> Created on: " . gmdate('Y-m-d \ H:i:s', $row['date']) . "</td></tr>";
                    }
                } else {
                    echo "<tr><td>No threads founds</td><td>No threads founds</td><td>No threads founds</td></tr>";
                }
                $conn->close();
            ?>
        </table>
    </body>
</html>
