document.addEventListener('DOMContentLoaded', function () {
    const aiDrawer = document.getElementById('aiAssistantDrawer');
    const aiToggleBtn = document.getElementById('btnAiToggle');
    const aiCloseBtn = document.getElementById('btnAiClose');
    const aiInput = document.getElementById('aiInput');
    const aiSendBtn = document.getElementById('btnAiSend');
    const aiChatContainer = document.getElementById('aiChatContainer');

    let isTyping = false;

    // Toggle Drawer
    if (aiToggleBtn) {
        aiToggleBtn.addEventListener('click', function () {
            aiDrawer.classList.add('active');
            aiInput.focus();
        });
    }

    if (aiCloseBtn) {
        aiCloseBtn.addEventListener('click', function () {
            aiDrawer.classList.remove('active');
        });
    }

    // Send Message
    function sendMessage() {
        const message = aiInput.value.trim();
        if (!message || isTyping) return;

        // Add User Message
        addMessage(message, 'user');
        aiInput.value = '';
        aiInput.style.height = 'auto'; // Reset height

        // Show Typing Indicator
        isTyping = true;
        showTypingIndicator();

        // Simulate AJAX request to backend
        fetch('index.php?controller=AIAssistant&action=processQuery', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'query=' + encodeURIComponent(message)
        })
            .then(response => response.json())
            .then(data => {
                removeTypingIndicator();
                isTyping = false;
                if (data.success) {
                    addMessage(data.response, 'bot');
                } else {
                    addMessage('Lo siento, hubo un error al procesar tu solicitud.', 'bot');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                removeTypingIndicator();
                isTyping = false;
                addMessage('Error de conexión. Por favor intenta de nuevo.', 'bot');
            });
    }

    // Helper: Add Message to UI
    function addMessage(content, type) {
        const msgDiv = document.createElement('div');
        msgDiv.className = `ai-message ${type}`;

        let avatarHtml = '';
        if (type === 'bot') {
            avatarHtml = `<div class="ai-avatar-small"><i class="fas fa-robot"></i></div>`;
        }

        // Parse Markdown for bot messages
        const parsedContent = (type === 'bot') ? parseMarkdown(content) : content.replace(/\n/g, '<br>');

        msgDiv.innerHTML = `
            <div class="ai-message-content">
                ${parsedContent}
            </div>
        `;

        aiChatContainer.appendChild(msgDiv);
        scrollToBottom();
    }

    function parseMarkdown(text) {
        if (!text) return '';

        let html = text;

        // Bold
        html = html.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');

        // Links: [text](url)
        html = html.replace(/\[(.*?)\]\((.*?)\)/g, '<a href="$2" class="ai-link" target="_blank">$1</a>');

        // Unordered lists
        html = html.replace(/^\*\s(.*)$/gm, '<li>$1</li>');
        html = html.replace(/(<li>.*<\/li>)/s, '<ul>$1</ul>');

        // New lines
        html = html.replace(/\n/g, '<br>');

        return html;
    }

    // Helper: Typind Indicator
    function showTypingIndicator() {
        const indicatorDiv = document.createElement('div');
        indicatorDiv.id = 'aiTypingIndicator';
        indicatorDiv.className = 'ai-message bot';
        indicatorDiv.innerHTML = `
            <div class="ai-message-content" style="padding: 10px 15px;">
                <div class="typing-indicator">
                    <span></span><span></span><span></span>
                </div>
            </div>
        `;
        aiChatContainer.appendChild(indicatorDiv);
        scrollToBottom();
    }

    function removeTypingIndicator() {
        const indicator = document.getElementById('aiTypingIndicator');
        if (indicator) indicator.remove();
    }

    function scrollToBottom() {
        aiChatContainer.scrollTop = aiChatContainer.scrollHeight;
    }

    // Event Listeners
    if (aiInput) {
        aiInput.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                sendMessage();
            }
        });

        // Auto-resize textarea
        aiInput.addEventListener('input', function () {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
    }

    if (aiSendBtn) {
        aiSendBtn.addEventListener('click', sendMessage);
    }
});
