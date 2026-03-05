<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Gladiator</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('css/theme.css') ?>">
    <style>
        .chat-input-actions {
            display: flex;
            gap: 5px;
            padding: 5px 10px;
            background: #1a1f3a;
            border-top: 1px solid #333;
        }
        .chat-input-actions button {
            background: transparent;
            border: none;
            color: #4a90e2;
            font-size: 20px;
            cursor: pointer;
            padding: 5px 10px;
            transition: all 0.3s;
        }
        .chat-input-actions button:hover {
            color: #fff;
        }
        #emojiPicker {
            position: absolute;
            bottom: 100%;
            right: 10px;
            background: #1a1f3a;
            border: 2px solid #4a90e2;
            border-radius: 8px;
            padding: 10px;
            display: none;
            max-height: 200px;
            overflow-y: auto;
            z-index: 1000;
        }
        .emoji-item {
            display: inline-block;
            font-size: 24px;
            cursor: pointer;
            padding: 5px;
            transition: transform 0.2s;
        }
        .emoji-item:hover {
            transform: scale(1.3);
        }
    </style>
</head>
<body class="chat-page">
    <!-- User Dropdown -->
    <div class="user-dropdown">
        <div class="dropdown">
            <button class="btn dropdown-toggle" type="button" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-user-circle" style="font-size: 18px;"></i>
                <span><?= session()->get('user_name') ?></span>
            </button>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="<?= base_url('profile') ?>">
                    <i class="fas fa-user"></i> Profile
                </a>
                <a class="dropdown-item" href="<?= base_url('change-password') ?>">
                    <i class="fas fa-key"></i> Change Password
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item text-danger" href="<?= base_url('auth/logout') ?>">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
    </div>

    <div class="chat-container">
        <div class="chat-sidebar">
            <div class="sidebar-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5><i class="fas fa-comments"></i> Chats</h5>
                    <a href="<?= base_url('/') ?>" class="btn btn-sm"><i class="fas fa-home"></i></a>
                </div>
            </div>
            <div class="users-list" id="usersList">
                <?php foreach ($users as $user): ?>
                    <div class="user-item" data-user-id="<?= $user['id'] ?>" data-user-name="<?= esc($user['name']) ?>">
                        <strong><i class="fas fa-user-circle" style="margin-right: 8px; color: #4a90e2;"></i><?= esc($user['name']) ?></strong>
                        <small><?= esc($user['email']) ?></small>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="chat-main">
            <div class="chat-header">
                <i class="fas fa-comment-dots"></i>
                <h5 id="chatUserName">Select a user to start chatting</h5>
            </div>
            <div class="chat-messages" id="chatMessages">
                <div class="empty-state">
                    <i class="fas fa-comments"></i>
                    <p>Select a user from the sidebar to start messaging</p>
                </div>
            </div>
            <div class="chat-input" style="position: relative;">
                <div id="mentionDropdown" style="display: none; position: absolute; bottom: 100%; left: 30px; background: #1a1f3a; border: 2px solid #4a90e2; border-radius: 8px; max-height: 200px; overflow-y: auto; z-index: 1000; min-width: 200px;"></div>
                <div id="emojiPicker"></div>
                <div class="chat-input-actions">
                    <button type="button" id="emojiBtn" title="Emoji"><i class="fas fa-smile"></i></button>
                </div>
                <form id="messageForm">
                    <div class="input-group">
                        <input type="text" class="form-control" id="messageInput" placeholder="Type your message...">
                        <div class="input-group-append">
                            <button class="btn" type="submit" id="sendBtn"><i class="fas fa-paper-plane"></i> Send</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        let currentReceiverId = null;
        let ws = null;

        $('#messageInput, #sendBtn').prop('disabled', true);

        const urlParams = new URLSearchParams(window.location.search);
        const selectedUserId = urlParams.get('user');
        const autoFocus = urlParams.get('focus');
        
        if (selectedUserId) {
            const userItem = $(`.user-item[data-user-id="${selectedUserId}"]`);
            if (userItem.length) {
                userItem.click();
                if (autoFocus === '1') {
                    setTimeout(() => $('#messageInput').focus(), 300);
                }
            }
        }

        $('.user-item').on('click', function() {
            $('.user-item').removeClass('active');
            $(this).addClass('active');
            
            currentReceiverId = $(this).data('user-id');
            const userName = $(this).data('user-name');
            
            $('#chatUserName').text(userName);
            $('#messageInput, #sendBtn').prop('disabled', false);
            $('#chatMessages').empty();
            
            loadMessages();
        });

        function loadMessages() {
            if (!currentReceiverId) return;
            
            $.ajax({
                url: '<?= base_url('chat/getMessages') ?>',
                type: 'GET',
                data: { receiver_id: currentReceiverId },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        displayMessages(response.messages);
                    }
                }
            });
        }

        function displayMessages(messages) {
            const chatMessages = $('#chatMessages');
            chatMessages.empty();
            
            if (messages.length === 0) {
                chatMessages.html('<div class="text-center text-muted mt-5"><p>No messages yet. Start the conversation!</p></div>');
                return;
            }
            
            messages.forEach(function(msg) {
                const isSent = msg.sender_id == <?= session()->get('user_id') ?>;
                const messageClass = isSent ? 'sent' : 'received';
                const messageHtml = `
                    <div class="message ${messageClass}">
                        <div class="message-bubble">
                            ${escapeHtml(msg.message)}
                            <br><small style="opacity: 0.7; font-size: 0.75em;">${formatTime(msg.created_at)}</small>
                        </div>
                    </div>
                `;
                chatMessages.append(messageHtml);
            });
            
            chatMessages.scrollTop(chatMessages[0].scrollHeight);
        }

        $('#messageForm').on('submit', function(e) {
            e.preventDefault();
            
            const message = $('#messageInput').val().trim();
            if (!message || !currentReceiverId) return;
            
            const tempId = 'temp-' + Date.now();
            const sendingHtml = `
                <div class="message sent" id="${tempId}">
                    <div class="message-bubble">
                        ${escapeHtml(message)}
                        <br><small style="opacity: 0.7; font-size: 0.75em;"><i class="fas fa-clock"></i> Sending...</small>
                    </div>
                </div>
            `;
            $('#chatMessages').append(sendingHtml);
            $('#chatMessages').scrollTop($('#chatMessages')[0].scrollHeight);
            $('#messageInput').val('');
            
            $.ajax({
                url: '<?= base_url('chat/sendMessage') ?>',
                type: 'POST',
                data: {
                    receiver_id: currentReceiverId,
                    message: message
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        const now = new Date();
                        const timeStr = now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
                        $('#' + tempId).find('small').html(timeStr);
                        $('#' + tempId).removeAttr('id');
                        
                        if (ws && ws.readyState === WebSocket.OPEN) {
                            ws.send(JSON.stringify({
                                type: 'message',
                                sender_id: <?= session()->get('user_id') ?>,
                                receiver_id: currentReceiverId,
                                message: message,
                                created_at: now.toISOString()
                            }));
                        }
                    } else {
                        $('#' + tempId).find('small').html('<i class="fas fa-exclamation-circle"></i> Failed');
                    }
                },
                error: function() {
                    $('#' + tempId).find('small').html('<i class="fas fa-exclamation-circle"></i> Failed');
                }
            });
        });

        let usePolling = false;
        let pollingInterval = null;

        function connectWebSocket() {
            try {
                ws = new WebSocket('ws://127.0.0.1:8080');
                
                ws.onopen = function() {
                    usePolling = false;
                    if (pollingInterval) clearInterval(pollingInterval);
                    ws.send(JSON.stringify({
                        type: 'auth',
                        user_id: <?= session()->get('user_id') ?>
                    }));
                };
                
                ws.onmessage = function(e) {
                    const data = JSON.parse(e.data);
                    if (data.type === 'message' && (data.sender_id == currentReceiverId || data.receiver_id == currentReceiverId)) {
                        const messageHtml = `
                            <div class="message received">
                                <div class="message-bubble">
                                    ${escapeHtml(data.message)}
                                    <br><small style="opacity: 0.7; font-size: 0.75em;">${formatTime(data.created_at)}</small>
                                </div>
                            </div>
                        `;
                        $('#chatMessages').append(messageHtml);
                        $('#chatMessages').scrollTop($('#chatMessages')[0].scrollHeight);
                    }
                };
                
                ws.onerror = function() {
                    usePolling = true;
                    startPolling();
                };
                
                ws.onclose = function() {
                    usePolling = true;
                    startPolling();
                };
            } catch(e) {
                usePolling = true;
                startPolling();
            }
        }
        
        function startPolling() {
            if (pollingInterval) return;
            pollingInterval = setInterval(() => {
                if (currentReceiverId) loadMessages();
            }, 3000);
        }
        
        connectWebSocket();

        function escapeHtml(text) {
            const map = {'&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;'};
            return text.replace(/[&<>"']/g, m => map[m]);
        }

        function formatTime(timestamp) {
            const date = new Date(timestamp);
            return date.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
        }

        const allUsers = <?= json_encode($users) ?>;
        let mentionStartPos = -1;

        $('#messageInput').on('input', function(e) {
            const text = $(this).val();
            const cursorPos = this.selectionStart;
            const textBeforeCursor = text.substring(0, cursorPos);
            const lastAtPos = textBeforeCursor.lastIndexOf('@');
            
            if (lastAtPos !== -1) {
                const textAfterAt = textBeforeCursor.substring(lastAtPos + 1);
                if (!textAfterAt.includes(' ')) {
                    mentionStartPos = lastAtPos;
                    showMentionDropdown(textAfterAt);
                    return;
                }
            }
            hideMentionDropdown();
        });

        function showMentionDropdown(query) {
            const filtered = allUsers.filter(u => u.name.toLowerCase().includes(query.toLowerCase()));
            if (filtered.length === 0) {
                hideMentionDropdown();
                return;
            }
            
            let html = '';
            filtered.forEach(user => {
                html += `<div class="mention-item" data-name="${user.name}" style="padding: 10px 15px; cursor: pointer; color: #fff; transition: all 0.3s;">
                    <i class="fas fa-user-circle" style="color: #4a90e2; margin-right: 8px;"></i>${user.name}
                </div>`;
            });
            
            $('#mentionDropdown').html(html).show();
            
            $('.mention-item').hover(
                function() { $(this).css('background', '#4a90e2'); },
                function() { $(this).css('background', 'transparent'); }
            );
            
            $('.mention-item').on('click', function() {
                insertMention($(this).data('name'));
            });
        }

        function hideMentionDropdown() {
            $('#mentionDropdown').hide().empty();
            mentionStartPos = -1;
        }

        function insertMention(name) {
            const input = $('#messageInput');
            const text = input.val();
            const beforeMention = text.substring(0, mentionStartPos);
            const afterCursor = text.substring(input[0].selectionStart);
            input.val(beforeMention + name + ' ' + afterCursor);
            hideMentionDropdown();
            input.focus();
        }

        $(document).on('click', function(e) {
            if (!$(e.target).closest('#messageInput, #mentionDropdown').length) {
                hideMentionDropdown();
            }
        });

        // Emoji Picker
        const emojis = ['😀','😃','😄','😁','😆','😅','😂','🤣','😊','😇','🙂','🙃','😉','😌','😍','🥰','😘','😗','😙','😚','😋','😛','😝','😜','🤪','🤨','🧐','🤓','😎','🤩','🥳','😏','😒','😞','😔','😟','😕','🙁','☹️','😣','😖','😫','😩','🥺','😢','😭','😤','😠','😡','🤬','🤯','😳','🥵','🥶','😱','😨','😰','😥','😓','🤗','🤔','🤭','🤫','🤥','😶','😐','😑','😬','🙄','😯','😦','😧','😮','😲','🥱','😴','🤤','😪','😵','🤐','🥴','🤢','🤮','🤧','😷','🤒','🤕','🤑','🤠','👍','👎','👌','✌️','🤞','🤟','🤘','🤙','👈','👉','👆','👇','☝️','✋','🤚','🖐️','🖖','👋','🤝','💪','🙏','❤️','🧡','💛','💚','💙','💜','🖤','🤍','🤎','💔','❣️','💕','💞','💓','💗','💖','💘','💝','🔥','✨','💫','⭐','🌟','💯','🎉','🎊','🎈','🎁','🏆','🥇','🥈','🥉'];
        
        emojis.forEach(emoji => {
            $('#emojiPicker').append(`<span class="emoji-item">${emoji}</span>`);
        });

        $('#emojiBtn').on('click', function(e) {
            e.stopPropagation();
            $('#emojiPicker').toggle();
        });

        $('.emoji-item').on('click', function() {
            const emoji = $(this).text();
            const input = $('#messageInput');
            input.val(input.val() + emoji);
            $('#emojiPicker').hide();
            input.focus();
        });

        $(document).on('click', function(e) {
            if (!$(e.target).closest('#emojiBtn, #emojiPicker').length) {
                $('#emojiPicker').hide();
            }
        });
    </script>
</body>
</html>
