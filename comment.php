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
                <link rel="stylesheet" href="css/commentstyle.css" type="text/css">
        </head>
        <div class = "nav">
            <ul>
                <li><a href = "buywelcome.php" class = "buy"> Buy A ticket </a></li>
                <li><a href = "comment.php" class = "buttontop"> Movie Review </a></li>
                <li><a href = "history.php" class = "buttontop"> Purchase History </a></li>
                <li><a href = "logout.php" class = "buttontop"> Logout </a></li>
            </ul>
        </div>
        <div class = "outer">
            <div class = "forms">
        <form action = "comment_submit.php" method = "post">
<?php
        
        print '<select name = "film" id = "film">';
        $query = "SELECT FilmName FROM Film";
        $result = mysqli_query($conn, $query) or die ('Failed to query '.mysqli_error($conn));
        while($row= mysqli_fetch_array($result)){
            $film = $row['FilmName'];
            $value = '"'.$film.'"';
            print "<option value = $value>".$film."</option>";
        }
?>
        </select>
        <br>
        <textarea id = "text" name = "comment" rows = "20" cols = "80"  placeholder = "Please input comment here..." > </textarea>
        <br>
        <input id = "view" type=button value = "View Comment">
        <input type=submit value = "Submit Comment" name = "submit">
        </form>
        <div id="comments"> </div>
        </div>
    </div>
        <script>
            document.getElementById("view").addEventListener('click', viewComment);
            function viewComment(){
                var xmlHttp;
                if (window.XMLHttpRequest) {
                    xmlhttp = new XMLHttpRequest();
                } else {
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function () {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        var mesgs = document.getElementById("comments");
                        mesgs.innerHTML = xmlhttp.responseText;
                    }
                }
                var e = document.getElementById("film");
                var value = e.options[e.selectedIndex].value;
                xmlhttp.open("POST", "comment_retrieve.php",true);
                xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xmlhttp.send("show=view&value="+value);
            }    
                    
        </script>
<?php
    mysqli_free_result($result);
    mysqli_close($conn); 
    }   
?>