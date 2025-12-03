<?php
$conn = mysqli_connect("localhost", "root", "", "lms2");

$userMsg = strtolower(trim($_POST['message']));
$reply = "Sorry, I couldn’t understand your question.";


// ✅ 1️⃣ TYPES OF BOOKS (SAFE VERSION)
if (
    strpos($userMsg, "types of books") !== false || 
    strpos($userMsg, "type of books") !== false || 
    strpos($userMsg, "categories") !== false
) {
    $q = mysqli_query($conn, "SELECT DISTINCT bookname FROM books");

    if (mysqli_num_rows($q) > 0) {
        $reply = "We have books like: ";
        while ($row = mysqli_fetch_assoc($q)) {
            $reply .= $row['bookname'] . ", ";
        }
    } else {
        $reply = "No books found.";
    }
}


// ✅ 2️⃣ JAVA BOOKS
else if (strpos($userMsg, "java") !== false) {
    $q = mysqli_query($conn, "SELECT * FROM books WHERE bookname LIKE '%java%' AND quantity > 0");
    $count = mysqli_num_rows($q);
    $reply = "We have $count Java books available.";
}


// ✅ 3️⃣ DBMS BOOKS
else if (strpos($userMsg, "dbms") !== false) {
    $q = mysqli_query($conn, "SELECT * FROM books WHERE bookname LIKE '%dbms%' AND quantity > 0");
    $count = mysqli_num_rows($q);
    $reply = "We have $count DBMS books available.";
}


// ✅ 4️⃣ PYTHON BOOKS
else if (strpos($userMsg, "python") !== false) {
    $q = mysqli_query($conn, "SELECT * FROM books WHERE bookname LIKE '%python%' AND quantity > 0");
    $count = mysqli_num_rows($q);
    $reply = "We have $count Python books available.";
}


// ✅ 5️⃣ PRICE OF ANY BOOK
else if (strpos($userMsg, "price") !== false) {
    $words = explode(" ", $userMsg);
    $book = end($words);

    $q = mysqli_query($conn, "SELECT price FROM books WHERE bookname LIKE '%$book%'");
    if (mysqli_num_rows($q) > 0) {
        $row = mysqli_fetch_assoc($q);
        $reply = "The price of $book book is Rs. " . $row['price'];
    } else {
        $reply = "Sorry, I couldn't find the price of that book.";
    }
}


// ✅ 6️⃣ CHEAPEST BOOK
else if (strpos($userMsg, "cheapest") !== false) {
    $q = mysqli_query($conn, "SELECT bookname, price FROM books ORDER BY price ASC LIMIT 1");
    $row = mysqli_fetch_assoc($q);
    $reply = "The cheapest book is " . $row['bookname'] . " with price Rs. " . $row['price'];
}


// ✅ 7️⃣ MOST EXPENSIVE BOOK
else if (strpos($userMsg, "expensive") !== false) {
    $q = mysqli_query($conn, "SELECT bookname, price FROM books ORDER BY price DESC LIMIT 1");
    $row = mysqli_fetch_assoc($q);
    $reply = "The most expensive book is " . $row['bookname'] . " priced at Rs. " . $row['price'];
}


// ✅ 8️⃣ AUTHOR OF BOOK (SAFE)
else if (strpos($userMsg, "author") !== false) {
    $words = explode(" ", $userMsg);
    $book = end($words);

    $q = mysqli_query($conn, "
        SELECT author.author_name 
        FROM author 
        JOIN books ON author.authorid = books.authorid 
        WHERE books.bookname LIKE '%$book%'
    ");

    if (mysqli_num_rows($q) > 0) {
        $row = mysqli_fetch_assoc($q);
        $reply = "The author of $book book is " . $row['author_name'];
    } else {
        $reply = "Author information not found.";
    }
}


// ✅ 9️⃣ TOTAL AVAILABLE BOOKS
else if (strpos($userMsg, "available") !== false) {
    $q = mysqli_query($conn, "SELECT COUNT(*) AS total FROM books WHERE quantity > 0");
    $data = mysqli_fetch_assoc($q);
    $reply = "Total available books: " . $data['total'];
}


// ✅ 🔟 TOTAL BOOKS
else if (strpos($userMsg, "how many books") !== false) {
    $q = mysqli_query($conn, "SELECT COUNT(*) AS total FROM books");
    $data = mysqli_fetch_assoc($q);
    $reply = "Total books in library: " . $data['total'];
}


// ✅ 1️⃣1️⃣ ISSUE INFO
else if (strpos($userMsg, "issue") !== false) {
    $reply = "You can issue books from your student dashboard.";
}


// ✅ 1️⃣2️⃣ FINE INFO
else if (strpos($userMsg, "fine") !== false) {
    $reply = "Fine is applied if the book is returned late.";
}


// ✅ 1️⃣3️⃣ HELLO / HI
else if (
    $userMsg == "hi" || 
    $userMsg == "hello" || 
    $userMsg == "hey"
) {
    $reply = "Hello! I am your AI Library Assistant. You can ask about books, price, author, and availability.";
}

echo $reply;
?>

