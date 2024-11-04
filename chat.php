<?php


// Initialize chat history
if (!isset($_SESSION['chat_history'])) {
    $_SESSION['chat_history'] = [];
}

// Handle chat messages
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_message = trim($_POST['message']);
    if ($user_message !== '') {
        $_SESSION['chat_history'][] = ['user' => $user_message];

        // Call ChatGPT API
        $api_key = ''; 
        $api_url = 'https://api.openai.com/v1/chat/completions';

        $data = [
            'model' => 'gpt-3.5-turbo',
            'messages' => array_map(function ($msg) {
                return ['role' => 'user', 'content' => $msg['user']];
            }, $_SESSION['chat_history']),
        ];

        $options = [
            'http' => [
                'header' => [
                    "Content-Type: application/json",
                    "Authorization: Bearer $api_key"
                ],
                'method' => 'POST',
                'content' => json_encode($data),
            ],
        ];

        $context = stream_context_create($options);
        $response = file_get_contents($api_url, false, $context);
        $response_data = json_decode($response, true);

        // Store ChatGPT's response
        $bot_message = $response_data['choices'][0]['message']['content'] ?? 'Error: Unable to get a response';
        $_SESSION['chat_history'][] = ['bot' => $bot_message];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link rel="stylesheet" href="css/chats.css">
</head>
<body>

<div id="chat-container" class="chat-container">
    <div class="chat-header">
        <span>Chat with us!</span>
        <button id="close-chat">X</button>
    </div>
    <div id="chat-body" class="chat-body">
        <div id="messages"></div>
    </div>
    <input type="text" id="user-input" placeholder="Type your message...">
    <button id="send-button">Send</button>
</div>

<div id="chat-icon" class="chat-icon">
    💬
</div>

<script>
    const chatContainer = document.getElementById('chat-container');
    const chatIcon = document.getElementById('chat-icon');
    const closeChatButton = document.getElementById('close-chat');
    const sendButton = document.getElementById('send-button');
    const userInput = document.getElementById('user-input');
    const messages = document.getElementById('messages');

    chatIcon.onclick = function() {
        chatContainer.style.display = 'block';
        chatIcon.style.display = 'none'; // Hide chat icon when chat is open
    };

    closeChatButton.onclick = function() {
        chatContainer.style.display = 'none';
        chatIcon.style.display = 'block'; // Show chat icon when chat is closed
    };

    sendButton.onclick = async function() {
        const userMessage = userInput.value;
        if (userMessage) {
            // Display user's message
            messages.innerHTML += `<div class="user-message">${userMessage}</div>`;
            userInput.value = '';

            // Send the message to the ChatGPT API
            const response = await fetch('https://api.openai.com/v1/chat/completions', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' 
                },
                body: JSON.stringify({
                    model: 'gpt-3.5-turbo',
                    messages: [{ role: 'user', content: userMessage }]
                })
            });

            const data = await response.json();
            const botMessage = data.choices[0].message.content;

            // Display bot's message
            messages.innerHTML += `<div class="bot-message">${botMessage}</div>`;
            messages.scrollTop = messages.scrollHeight; // Scroll to the bottom
        }
    };
</script>

</body>
</html>
