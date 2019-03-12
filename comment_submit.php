<?php
    session_start();
    $conn=mysqli_connect('sophia.cs.hku.hk', 'byang', '235702', 'byang') or die ('Error! '.mysqli_connect_error($conn));
    if(isset($_POST['submit'])){
        $FilmName = $_POST['film'];
        $comment = $_POST['comment'];
        $user = $_SESSION['UserID'];
        if ($comment!=""){
            $query = "SELECT FilmId FROM Film WHERE Film.FilmName = '$FilmName'";
            $result = mysqli_query($conn, $query) or die ('Failed to query '.mysqli_error($conn));
            $row= mysqli_fetch_array($result);
            $film = $row['FilmId'];
            $query2 = "INSERT INTO Comment (FilmId, UserId, Comment) VAlUES ('$film', '$user', '$comment')";
            mysqli_query($conn, $query2);
            print "<h1> Your comment has been submitted. </h1>";
            header("Refresh:3; url=comment.php");
            mysqli_free_result($result);
            mysqli_close($conn);    
        }   
    }
?>
