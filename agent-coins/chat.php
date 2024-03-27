<!-- chat.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Group Chat</title>
    <style>
        #chat-box {
            height: 300px;
            overflow-y: scroll;
        }
    </style>
</head>
<body>
    <div id="chat-box"></div>
    <input type="text" id="message" placeholder="Type your message">
    <button onclick="sendMessage()">Send</button>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        function sendMessage() {
            var message = $("#message").val();
            
            $.post("send_message.php", { message: message }, function(data) {
                // عملية إرسال الرسالة
                $("#message").val(""); // إفراغ حقل الرسالة بعد الإرسال
            });
        }

        function getMessages() {
            $.get("get_messages.php", function(data) {
                $("#chat-box").html(data);
                var chatBox = document.getElementById("chat-box");
                chatBox.scrollTop = chatBox.scrollHeight; // تمرير إلى أسفل لرؤية آخر الرسائل
            });
        }

        // استرجاع الرسائل كل فترة زمنية
        setInterval(getMessages, 2000); // كل 2 ثانية، يمكنك تغيير هذا حسب الحاجة
    </script>
</body>
</html>
