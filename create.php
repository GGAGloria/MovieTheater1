<?php
    $conn=mysqli_connect('sophia.cs.hku.hk', 'byang', '235702', 'byang') or die ('Error! '.mysqli_connect_error($conn));
    $user = $_POST['username'];
    $pass = $_POST['password'];
    $query = "SELECT * FROM Login WHERE UserID='$user'";
    $result = mysqli_query($conn, $query) or die ('Failed to query '.mysqli_error($conn));
    $row = mysqli_fetch_array($result);
    if (!empty($row)){
        if ($user == $row['UserID']){
            print "<h1> Account already existed. </h1>";
            header("Refresh:3; url=createaccount.html");
        } 
    } else {
        $query2 = "INSERT INTO Login (UserID,PW) VALUES ('$user', '$pass')";
        mysqli_query($conn, $query2);
        print "<h1> Account created! Welcome </h1>";
        header("Refresh:3; url=index.html");
    }
    mysqli_free_result($result);
    mysqli_close($conn);    
?>