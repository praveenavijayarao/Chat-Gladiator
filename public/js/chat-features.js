// Chat Features - Polling and Read Status

let currentReceiverId = null;
let lastMessageId = 0;

// Poll for new messages every 3 seconds
function startPolling(receiverId) {
    currentReceiverId = receiverId;
    
    setInterval(() => {
        if (currentReceiverId) {
            fetchNewMessages();
        }
    }, 3000);
}

// Fetch new messages
function fetchNewMessages() {
    $.get('/chat/getNewMessages', {
        receiver_id: currentReceiverId,
        last_id: lastMessageId
    }, function(messages) {
        if (messages.length > 0) {
            messages.forEach(msg => {
                appendMessage(msg);
                lastMessageId = Math.max(lastMessageId, msg.id);
            });
            
            // Mark messages as read
            markMessagesAsRead(currentReceiverId);
        }
    });
}

// Mark messages as read
function markMessagesAsRead(senderId) {
    $.post('/chat/markAsRead', {
        sender_id: senderId
    });
}

// Get unread count
function updateUnreadCount() {
    $.get('/chat/getUnreadCount', function(response) {
        if (response.count > 0) {
            $('#unread-badge').text(response.count).show();
        } else {
            $('#unread-badge').hide();
        }
    });
}

// Update unread count every 5 seconds
setInterval(updateUnreadCount, 5000);

// Append message to chat (implement based on your UI)
function appendMessage(msg) {
    // Your code to display the message in the chat UI
    console.log('New message:', msg);
}
