 

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
                <link rel="stylesheet" media="screen and (max-width: 500px)" href="css/confirm_mobile.css" type="text/css">
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
        print "<h1> Order Information </h1>";
        $temp = $_SESSION['broadcast'];
        $broadcast = str_replace('"', '', $temp);
        $separate = explode(" ", $broadcast);
        $Dates = $separate[0];
        $Time = $separate[1];
        $day = $separate[2];
        $HouseId = $separate[3].' '.$separate[4];
        // print $HouseId;
        $showtime = $Dates.$day.$Time;
        $query = "SELECT * FROM Film, BroadCast, House WHERE Film.FilmId = BroadCast.FilmId AND BroadCast.HouseId = House.HouseId AND House.HouseId = '$HouseId' AND BroadCast.Time = '$Time'";
        $result = mysqli_query($conn, $query) or die ('Failed to query '.mysqli_error($conn));
        $row = mysqli_fetch_array($result); 
        $Film = $row['FilmName'];
        $Category = $row['Category'];
        $query = "SELECT BroadCastId FROM BroadCast WHERE BroadCast.Time = '$Time' AND BroadCast.HouseId = '$HouseId'";
        $result = mysqli_query($conn, $query) or die ('Failed to query '.mysqli_error($conn));
        $row = mysqli_fetch_array($result); 
        $broadcastId = $row[0];
        $user = $_SESSION['UserID'];
        $querys = array();
        $total = 0;
        foreach ($_POST as $ticket){
            $str = explode(" ", $ticket);
            $SeatNo = $str[0];
            $TicketType = $str[1];
            $TicketFee = $str[2];
            $temp1 = substr($TicketFee, 1);
            $total = $total+intval($temp1);
            $fee = $TicketFee.'('.$TicketType.')';
            print '<div class = "ticketinformation">';
            print "<p> Cinema:  Elvia's Cinema </p>";
            print "<p> House:  $HouseId </p>";
            print "<p> SeatNo:  $SeatNo </p>";
            print "<p> Film:  $Film </p>";
            print "<p> Category:  $Category </p>";
            print "<p> Show Time:  $showtime </p>";
            print "<p> Ticket Fee:  $fee </p>";
            print "</div>";
            array_push($querys, "INSERT INTO Ticket (SeatNo, BroadCastId, Valid, UserId, TicketType, TicketFee) VALUES ('$SeatNo', '$broadcastId', 'Sold', '$user', '$TicketType', '$TicketFee')");
        }
        print '<p> Total fee: $';
        print "$total </p>";
        print '<hr>';
        print '<p> Please present valid proof of age/status when purchasing Student or Senior tickets before entering the cinema house. </p>';
        print '<button type = "button" onclick = "window.location=\'buywelcome.php\'"> OK </button>';
        foreach($querys as $q){
                mysqli_query($conn, $q) or die ('Failed to query '.mysqli_error($conn));
        }
        print "</body>";
    }
    mysqli_free_result($result);
    mysqli_close($conn); 
?>
