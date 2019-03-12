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
                <link rel="stylesheet" media="screen and (max-width: 500px)" href="css/buy_mobile.css" type="text/css">
                <link rel="stylesheet" media="screen and (min-width: 500px) and (max-width: 1000px)" href="css/buy_tablet.css" type="text/css">
                <link rel="stylesheet" media="screen and (min-width: 1000px)" href="css/buy_desktop.css" type="text/css">
        </head>
<?php
        print "<h1> Cart </h1>";
        $temp = $_SESSION['broadcast'];
        $broadcast = str_replace('"', '', $temp);
        $separate = explode(" ", $broadcast);
        $Dates = $separate[0];
        $Time = $separate[1];
        $day = $separate[2];
        $HouseId = $separate[3].' '.$separate[4];
        $showtime = $Dates.$day.$Time;
        $query = "SELECT * FROM Film, BroadCast, House WHERE Film.FilmId = BroadCast.FilmId AND BroadCast.HouseId = House.HouseId AND House.HouseId = '$HouseId' AND BroadCast.Time = '$Time'";
        $result = mysqli_query($conn, $query) or die ('Failed to query '.mysqli_error($conn));
        $row = mysqli_fetch_array($result); 
        $Film = $row['FilmName'];
        $Category = $row['Category'];
        $rownum = $row['HouseRow'];
        $colnum = $row['HouseCol'];
        print '<div class = "information">';
        print "<p> Cinema:  Elvia's Cinema </p>";
        print "<p> House:  $HouseId </p>";
        print "<p> Film:  $Film </p>";
        print "<p> Category:  $Category </p>";
        print "<p> Show Time:  $showtime </p>";
        print "</div>";
        print "<form action = \"confirm.php\" method = 'post'>";
        $seat = $_POST['seat'];
        foreach ($seat as $seatno) {
            print $seatno;
            print ": ";
            print "<select name = '$seatno'>";
            print "<option value = '$seatno Adult $75'> Adult($75) </option>";
            print "<option value = '$seatno Student/Senior $50'> Student/Senior($50) </option>";
            print "</select>";
            print "<br>";
        }
        print "<div class = 'outer'>";
        print "<div class = 'button'>";
        print "<button type = 'submit'> Confirm </button>";
        print '<button type = "button" onclick = "window.location=\'buywelcome.php\';return false;"> Cancel </button>';
        print "</div>";
        print "</div>";
        print '</form>';
    }
    mysqli_free_result($result);
    mysqli_close($conn); 
?>