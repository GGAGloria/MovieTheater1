<?php
    $conn=mysqli_connect('sophia.cs.hku.hk', 'byang', '235702', 'byang') or die ('Error! '.mysqli_connect_error($conn));
    if ($_POST['show']=='view'){
        $FilmName = $_POST['value'];
        $query = "SELECT UserId, Comment FROM Film, Comment WHERE Film.FilmName = '$FilmName' AND Film.FilmId = Comment.FilmId";
        $result = mysqli_query($conn, $query) or die ('Failed to query '.mysqli_error($conn));
        while($row= mysqli_fetch_array($result)){
            print "<h2> Viewer: ".$row['UserId']."</h2>";
            print "<h3> Comment: ".$row['Comment']."</h2>";
            print "<hr>";
        }
        mysqli_free_result($result);
        mysqli_close($conn);    
    }
    
?>
