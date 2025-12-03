<?php
session_start();
include "connection.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>

<body>

<?php
if(isset($_SESSION['login_student_username']))
{
    // ✅ MESSAGE COUNT
    $r = mysqli_query($db,"SELECT COUNT(status) as total FROM message 
    WHERE status='no' 
    AND username='$_SESSION[login_student_username]' 
    AND sender='admin'");
    $c = mysqli_fetch_assoc($r);

    // ✅ ACTIVE ISSUED BOOK (FOR TIMER)
    $b = mysqli_query($db,"SELECT * FROM issueinfo 
    WHERE studentid='$_SESSION[studentid]' 
    AND approve='yes' 
    ORDER BY returndate ASC LIMIT 1");
    $var1 = mysqli_num_rows($b);
    $bi = mysqli_fetch_assoc($b);
?>
<div class="header">
<div class="container">
<div class="navbar">

    <div class="logo">
        <a href="index.php"><img src="images/logo2.jpg" style="border-radius:50%;"></a> 
    </div>

    <div class="title student-title">
        <a href="index.php"><h3 style="font-size:15px;">Online Library Management System</h3></a>
    </div>

    <div class="student-navbar">
    <ul id="menuitems">

    <?php if($var1==1){ 
        $t = mysqli_query($db,"SELECT * FROM timer 
        WHERE stdid='$_SESSION[studentid]' 
        AND bid='$bi[bookid]'");
        $res = mysqli_fetch_assoc($t);
    ?>
    <script>
        var countDownDate = new Date("<?php echo $res['date']; ?>").getTime();
        var x = setInterval(function() {
            var now = new Date().getTime();
            var distance = countDownDate - now;

            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            if (distance < 0) {
                clearInterval(x);
                document.getElementById("demo").innerHTML = "";
            } else {
                document.getElementById("demo").innerHTML = days+"d "+hours+"h "+minutes+"m "+seconds+"s";
            }
        }, 1000);
    </script>
    <?php } ?>

    <li><p style="color:red; font-size:18px;" id="demo"></p></li>

    <li><a href="student_dashboard.php">Dashboard</a></li>
    <li><a href="student_books.php">Books</a></li>
    <li><a href="request_book.php">Requested Books</a></li>
    <li><a href="student_issue_info.php">Issue Info</a></li>
    <li><a href="feedback.php">Feedback</a></li>

    <!-- ✅ ✅ ✅ AI CHATBOT BUTTON ADDED HERE -->
    <li><a href="chatbot.php">🤖 AI Chatbot</a></li>

    <li>
        <a href="message.php"><i class="fas fa-envelope"></i>
        <?php if($c['total']>0){ ?>
            <sup style="background:red; padding:3px 7px; border-radius:20px;">
                <?php echo ($c['total']>9)?"9+":$c['total']; ?>
            </sup>
        <?php } ?>
        </a>
    </li>

    <li class="dropdown">
        <button onclick="myFunction()" class="dropbtn">
        <img class="user-img" src="images/<?php echo $_SESSION['pic']; ?>">
        <?php echo $_SESSION['login_student_username']; ?>
        &nbsp;<i class="fas fa-caret-down"></i>
        </button>
        <ul class="dropdown-content" id="myDropdown">
            <li><a href="profile.php">My Profile</a></li>
            <li><a href="student_update_password.php">Change Password</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </li>

    </ul>
    </div>
</div>
</div>
</div>

<?php } ?>

</body>
</html>
