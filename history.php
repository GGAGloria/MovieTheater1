<?php
    session_start();
    $conn=mysqli_connect('sophia.cs.hku.hk', 'byang', '235702', 'byang') or die ('Error! '.mysqli_connect_error($conn));
    if (!isset($_SESSION['UserID'])){
        print "<h1> You have not logged in. </h1>";
        header("Refresh:3; url=index.html");
    } else {
?>
        <head>
                <meta charset="UTF-8">
                <title>Elvia's Cinema</title>
                <link rel="stylesheet" href="css/historystyle.css" type="text/css">
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
        print "<h1> Purchase History </h1>";
        $user = $_SESSION['UserID'];
        print "<h3> Username: ".$user.'</h3>';
        $query = "SELECT * FROM Film,Ticket,BroadCast WHERE Ticket.UserId = '$user' AND BroadCast.BroadCastId = Ticket.BroadCastId AND Film.FilmId = BroadCast.FilmId";
        $result = mysqli_query($conn, $query) or die ('Failed to query '.mysqli_error($conn));
        while($row= mysqli_fetch_array($result)){
            $TicketId = $row['TicketId'];
            $TicketFee = $row['TicketFee'];
            $TicketType = $row['TicketType'];
            $HouseId = $row['HouseId'];
            $SeatNo = $row['SeatNo'];
            $FilmName = $row['FilmName'];
            $Category = $row['Category'];
            $Duration = $row['Duration'];
            $Language = $row['Language'];
            $Dates = $row['Dates'];
            $day = $row['day'];
            $Time = $row['Time'];
            print "<p>Ticket: ".$TicketId." ".$TicketFee." (".$TicketType.")</p>";
            print "<p>House: ".$HouseId."</p>";
            print "<p>Seat: ".$SeatNo."</p>";
            print "<p>FilmName: ".$FilmName."</p>";
            print "<p>Language: ".$Language."</p>";
            print "<p>Dates: ".$Dates."(".$day.") ".$Time."</p>";
            print "<hr>";
        }
        print "</body>";
    }
    mysqli_free_result($result);
    mysqli_close($conn);  
?>