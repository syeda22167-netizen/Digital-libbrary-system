<?php
    include "connection.php";
    include "student_navbar.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Panel</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>

<body>

<div class="dashboard">
    <div class="dashboard-container">
        <div class="dashboard-row">

            <!-- ✅ TOTAL BOOKS -->
            <?php
                $books = mysqli_query($db, "SELECT * FROM books");
                $total_books = mysqli_num_rows($books);
            ?>
            <div class="dashboard-col-3">
                <a href="student_books.php">
                    <h3><?php echo $total_books; ?></h3>
                    Total Books
                </a>
            </div>

            <!-- ✅ TOTAL REQUESTS -->
            <?php
                $requests = mysqli_query($db,"
                SELECT student.studentid, FullName, books.bookid, bookname, ISBN, price 
                FROM student 
                INNER JOIN issueinfo ON student.studentid = issueinfo.studentid 
                INNER JOIN books ON issueinfo.bookid = books.bookid 
                WHERE issueinfo.approve = '' 
                AND student.student_username = '$_SESSION[login_student_username]'
                ");

                $total_requests = mysqli_num_rows($requests);
            ?>
            <div class="dashboard-col-3">
                <a href="request_book.php">
                    <h3><?php echo $total_requests; ?></h3>
                    Total Book Requests
                </a>
            </div>

            <!-- ✅ TOTAL ISSUED (FIXED EXPIRED ISSUE) -->
            <?php
                $issue = mysqli_query($db,"
                SELECT student.studentid, FullName, books.bookid, bookname, ISBN, price 
                FROM student 
                INNER JOIN issueinfo ON student.studentid = issueinfo.studentid 
                INNER JOIN books ON issueinfo.bookid = books.bookid 
                WHERE student.student_username = '$_SESSION[login_student_username]' 
                AND (issueinfo.approve = 'Yes' OR issueinfo.approve = 'EXPIRED')
                ");

                $total_issue = mysqli_num_rows($issue);
            ?>
            <div class="dashboard-col-3">
                <a href="student_issue_info.php">
                    <h3><?php echo $total_issue; ?></h3>
                    Total Books Issued
                </a>
            </div>
s
        </div>
    </div>
</div>

<!-- ✅ AI CHATBOT BUTTON -->
<div style="text-align:center; margin:30px;">
    <a href="chatbot.php">
        <button style="padding:12px 20px; background:green; color:white; border:none; border-radius:6px; font-size:16px;">
            🤖 AI Library Chatbot
        </button>
    </a>
</div>

</body>
</html>
