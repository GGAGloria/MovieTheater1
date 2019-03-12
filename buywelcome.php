<?php
    session_start();
    if (!isset($_SESSION['UserID'])){
        print "<h1> You have not logged in. </h1>";
        header("Refresh:3; url=index.html");
    } else {
        $conn=mysqli_connect('sophia.cs.hku.hk', 'byang', '235702', 'byang') or die ('Error! '.mysqli_connect_error($conn));
?>
       <head>
                <meta charset="UTF-8">
                <title>Elvia's Cinema</title>
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" media="screen and (max-width: 500px)" href="css/buywelcome_mobile.css" type="text/css">
                <link rel="stylesheet" media="screen and (min-width: 500px) and (max-width: 1000px)" href="css/buywelcome_tablet.css" type="text/css">
                <link rel="stylesheet" media="screen and (min-width: 1000px)" href="css/buywelcome_desktop.css" type="text/css">
        </head>
        <div class = "nav">
            <ul>
                <li><a href = "buywelcome.php" class = "buy"> Buy A ticket </a></li>
                <li><a href = "comment.php" class = "buttontop"> Movie Review </a></li>
                <li><a href = "history.php" class = "buttontop"> Purchase History </a></li>
                <li><a href = "logout.php" class = "buttontop"> Logout </a></li>
            </ul>
        </div>
<?php
        print "<body>";
        $query = "SELECT * FROM Film";
        $result = mysqli_query($conn, $query) or die ('Failed to query '.mysqli_error($conn));
        while($row = mysqli_fetch_array($result)) {
            $id = $row['FilmId'];
            $name = $row['FilmName'];
            $Description = $row['Description'];
            $Director = $row['Director'];
            $Duration = $row['Duration'];
            $Category = $row['Category'];
            $Language = $row['Language'];
            print "<h1> $name </h1>";
            $image = '"'."movie".$id.".jpg".'"';
            // print "<h2> $image </h2>";
            print "<img src= $image>";
            print "<h3> $Description </h3>";
            print "<h4> $Director </h4>";
            print "<h4> $Duration </h4>";
            print "<h4> $Category </h4>";
            print "<h4> $Language </h4>";
            $query2 = "SELECT * FROM BroadCast WHERE FilmId = $id";
            $result2 = mysqli_query($conn, $query2) or die ('Failed to query '.mysqli_error($conn));
            print '<form action = "seatplantry.php" method = "post">';
            print '<select name = "broadcast">';
            while($row2= mysqli_fetch_array($result2)){
                $broadcast = $row2['Dates'].' '.$row2['Time'].' ('.$row2['day'].') '.$row2['HouseId'];
                $value = '"'.$broadcast.'"';
                print "<option value = $value>".$broadcast."</option>";
            }
            print '</select>';
            print '<input type = "submit" value = "Submit">';
            print '</form>';
            print "<hr>";
        }
        print "</body>";
        mysqli_free_result($result);
        mysqli_close($conn); 
        mysqli_free_result($result2);
    }
?>