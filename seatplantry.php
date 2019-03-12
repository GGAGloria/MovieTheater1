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
                <link rel="stylesheet" media="screen and (max-width: 500px)" href="css/seat_mobile.css" type="text/css">
                <link rel="stylesheet" media="screen and (min-width: 500px) and (max-width: 1000px)" href="css/seat_tablet.css" type="text/css">
                <link rel="stylesheet" media="screen and (min-width: 1000px)" href="css/seat_desktop.css" type="text/css">
        </head>
<?php
        print "<h1> Ticketing </h1>";
        $broadcast = $_POST['broadcast'];
        $_SESSION['broadcast'] = '"'.$broadcast.'"';
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
        print "<div class = 'outer'>";
        print "<div class = 'button'>";
        print '<form method = "post" action = "buyticket.php" name = "seats">';
        echo "<table border = '4' class = 'seats'>";
        foreach (array_reverse(range("A", $rownum)) as $rown){
            echo "<tr>";
            for ($coln = 1; $coln <= $colnum; $coln++){
                $seat = $rown.$coln;
                $query2 = "SELECT * FROM Ticket WHERE Ticket.SeatNo = '$seat'";
                $result2 = mysqli_query($conn, $query2) or die ('Failed to query '.mysqli_error($conn));
                $row2 = mysqli_fetch_array($result2);
                if (empty($row2)){
                    $s = '"'.$seat.'"';
                    echo "<td> <input type = 'checkbox' name = \"seat[]\" value = $s> <br>".$seat."</td>";
                } else {
                    echo "<td> Sold <br>".$seat."</td>";
                }
            }
            echo "</tr>";
        }
        echo "<tr>
              <td class = 'screen' colspan = $colnum> Screen </td>
              </tr>
              </table>";
        
        print "<button type = 'submit'> Submit </button>";
        print '<button type = "button" onclick = "window.location=\'buywelcome.php\';return false;"> Cancel </button>';
        print "</div>";
        print "</div>";
        print '</form>';
    }
    mysqli_free_result($result);
    mysqli_close($conn); 
    mysqli_free_result($result2);      
?>


        


