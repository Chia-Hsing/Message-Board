<?php session_start(); ?>

<!-- message board START -->

<!DOCTYPE html>
<html lang="zh-Hant-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Chia's Ｍessage Board</title>

    <!-- css -->
    <link href="../css/main_page1.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet"></link>

    <!-- Jquery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</head>
<body> 
    
    <?php

    require_once("../api/conn.php");

    $session_id = session_id();

        echo "<div class='wrap'>";
        echo "<div class='title'>";
        echo "<h1>Message Board</h1>";
        echo "</div>";


            /* main message submit START */

            echo "<div class='submit_message_wrap'>";
            
            if ($_SESSION['user_id']) {

                $user_stmt = $conn ->prepare("SELECT * FROM toast WHERE `user_id` = :user_id");
                $user_stmt -> bindParam(":user_id", $_SESSION['user_id']);
                $user_stmt -> execute();
                $user_stmt ->setFetchMode(PDO::FETCH_ASSOC);
                $user_row = $user_stmt -> fetch();
    
                echo "<div class='container'>";
                echo "<div class='name'>";
                echo "<div class='username'>$user_row[username]</div>";
                echo "<a class='log_out'>[log out]</a>";
                echo "</div>";
                echo "<div class='body'>";
                echo "<textarea class='commentArea' name='message' rows='5' placeholder='say something...'></textarea>";
                echo "<input name='username' type='hidden' value='$user_row[username]'>";
                echo "<input name='parent_id' type='hidden' value=0>";
                echo "<input class='submit btn btn btn-dark btn-sm' type='submit' value='submit'>";
                echo "</div>";
                echo "</div>";
                
            } else {
                echo "<a class='plz_sign_in' onclick=location.href='../sign-in/sign_in.php'>it won't take you more than 3 seconds, please sign in.";
                echo "<span></span>";
                echo "<span></span>";
                echo "<span></span>";
                echo "<span></span>";
                echo "</a>";
            } 
            
            echo "</div>";

            /* main message submit END */


            /* count the number of page START */

            $pages_stmt = $conn -> prepare("SELECT COUNT(`parent_id`) AS id_numbers FROM `black_coffee` WHERE `parent_id` = 0"); 
            $pages_stmt -> execute();
            $pages_stmt -> setFetchMode(PDO::FETCH_ASSOC);
            $pages_row = $pages_stmt -> fetch();

            $messageNum = 10;
            $pages = ceil($pages_row['id_numbers'] / $messageNum);    

            if (!isset($_GET['page']) OR !intval($_GET['page'])) {
                $page = 1;
            } else {
                $page = intval($_GET['page']);
            }

            $start = ($page-1) * $messageNum + 0;  
            $end = ($page-1) * $messageNum + $messageNum; 
            
            $mes_stmt = $conn -> prepare("SELECT * FROM `black_coffee` WHERE `parent_id` = 0 ORDER BY `time` DESC LIMIT $start, $end");
            $mes_stmt -> execute();
            $mes_stmt -> setFetchMode(PDO::FETCH_ASSOC);
            
            /* count the number of page END */


            /* show main message START */

            while ($mes_row = $mes_stmt -> fetch()) {

                $username = htmlspecialchars($mes_row['username'], ENT_QUOTES, 'UTF-8');
                $message = htmlspecialchars($mes_row['message'], ENT_QUOTES, 'UTF-8');
                
                echo "<div class='message_wrap for_delete'>";
                echo "<div class='container1'>";
                echo "<div class='name1'>";
                echo "<div class='username'>$username</div>";
                echo "</div>";
                echo "<div class='body'>";
                echo "<div class='content for_edit'>$message</div>";
                echo "<div class='time'>$mes_row[time]</div>";
                echo "</div>";
                if ($mes_row['user_id'] == $_SESSION['user_id']) {
                    echo "<div class='interface'>";
                    echo "<input name='id' type='hidden' value='$mes_row[id]'>"; 
                    echo "<a class='delete'>delete / </a>";
                    echo "<a class='edit'>edit</a>";
                    echo "</div>";
                    
                }
                if ($_SESSION['user_id']) {
                    echo "<span class='toggle_message'>[ + ]</span>";
                }
                echo "</div>";
               
                /* show main message END */
                
                

            /* show sub message START */

                $sub_stmt = $conn -> prepare("SELECT A.id, A.username, A.message, A.time, A.parent_id, B.user_id FROM `black_coffee` AS A LEFT JOIN `toast` AS B ON A.user_id = B.user_id WHERE A.parent_id = :id ORDER BY A.time ASC");
                $sub_stmt -> bindParam (":id", $mes_row['id']);
                $sub_stmt -> execute();
                $sub_stmt->setFetchMode(PDO::FETCH_ASSOC);
                while ($sub_row = $sub_stmt -> fetch()) {

                    $username = htmlspecialchars($sub_row['username'], ENT_QUOTES, 'UTF-8');
                    $message = htmlspecialchars($sub_row['message'], ENT_QUOTES, 'UTF-8');
                    $login_user = $sub_row['user_id'] == $_SESSION['user_id'] ? "style='background: hsl(180, 15%, 90%)'" : "" ;
                    
                    echo "<div class='sub_container1 for_delete' $login_user>";
                    echo "<div class='sub_name'>";
                    echo "<div class='sub_username'>$username</div>";
                    echo "</div>";
                    echo "<div class='sub_body'>";
                    echo "<div class='content for_edit'>$message</div>";
                    echo "<div class='time'>$sub_row[time]</div>"; 
                    echo "</div>";
                    if ($sub_row['user_id'] == $_SESSION['user_id']) {
                        echo "<div class='interface1'>";
                        echo "<input name='id' type='hidden' value='$sub_row[id]'>";
                        echo "<a class='delete'>delete / </a>";
                        echo "<a class='edit'>edit</a>";
                        echo "</div>";
                    }
                    echo "</div>";
                    }
                  

            /* show sub message END */


            /* sub message submit START */

            if (isset($_SESSION['user_id'])) {

                $username = htmlspecialchars ($user_row['username'], ENT_QUOTES, 'UTF-8');

                echo "<div class='sub_container'>";
                echo "<div class='sub_name'>";
                echo "<div class='sub_username'>$username</div>";
                echo "</div>";
                echo "<div class='sub_body'>";
                echo "<textarea class='commentArea' name='sub_message' cols='5' rows='5' placeholder='say something...'></textarea>";
                echo "<input name='username' type='hidden' value='$username'>";
                echo "<input name='parent_id' type='hidden' value='$mes_row[id]'>"; 
                echo "<input class='submit btn btn-dark btn-sm' type='submit' value='submit'>";
                echo "</div>";
                echo "</div>";
                echo "</div>"; // message_wrap END

            } else {

                echo "</div>"; // message_wrap END

            }
        
        }    

            /* sub message submit END */
                
            echo "<nav aria-label='Page navigation example'>";
            echo "<ul class='pagination'>";

            echo "<li class='page-item'>";
            for ($i = 1 ; $i <= $pages ; $i++) {
            if ($page - 5 < $i AND $page + 5 > $i) {
                echo "<a class='page-link' href='./main_page.php?page=$i'>$i</a>";
            }
            echo "</li>";
        }

            echo "</ul>";
            echo "</nav>";

        
        echo "</div>"; //wrap END
        
        ?>






        
<script src="./main_page1.js"></script>

</body>
</html>

