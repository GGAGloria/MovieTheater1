<?php
    session_start();
    $conn=mysqli_connect('sophia.cs.hku.hk', 'byang', '235702', 'byang') or die ('Error! '.mysqli_connect_error($conn));
    $user = $_POST['Username'];
    $pass = $_POST['Password'];
    $query = "SELECT * FROM Login WHERE UserID='$user'";
    $result = mysqli_query($conn, $query) or die ('Failed to query '.mysqli_error($conn));
    $row = mysqli_fetch_array($result);
    if (!empty($row)){
        if ($user == $row['UserID'] && $pass == $row['PW']){
            $_SESSION['UserID'] = $user;
            session_write_close();
            header('Location: main.php');
        } else {
            print "<h1> Invalid login, please login again. </h1>";
            header("Refresh:3; url=index.html");
        }
    } else {
        print "<h1> Invalid login, please login again. </h1>";
        header("Refresh:3; url=index.html");
    }
    mysqli_free_result($result);
    mysqli_close($conn);    
?>
