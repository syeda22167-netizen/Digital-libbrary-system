<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Library AI Chatbot</title>
    <style>
        body { font-family: Arial; background: #eef2f3; }
        .box {
            width: 400px;
            margin: 40px auto;
            background: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 0 10px gray;
        }
        .chat {
            height: 300px;
            overflow-y: scroll;
            border: 1px solid #aaa;
            padding: 10px;
            margin-bottom: 10px;
        }
        input { width: 75%; padding: 8px; }
        button { padding: 8px 12px; }
    </style>
</head>
<body>

<div class="box">
    <h2 align="center">📚 Library AI Chatbot</h2>
    <div class="chat" id="chatBox"></div>

    <input type="text" id="msg" placeholder="Ask about books..." />
    <button onclick="sendMsg()">Send</button>
</div>

<script>
function sendMsg() {
    var msg = document.getElementById("msg").value;

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "chatbot_process.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var chat = document.getElementById("chatBox");
            chat.innerHTML += "<b>You:</b> " + msg + "<br>";
            chat.innerHTML += "<b>Bot:</b> " + this.responseText + "<br><br>";
            chat.scrollTop = chat.scrollHeight;
        }
    };

    xhr.send("message=" + msg);
    document.getElementById("msg").value = "";
}
</script>

</body>
</html>

