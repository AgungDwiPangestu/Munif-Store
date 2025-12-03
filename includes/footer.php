<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-section">
                <h3><i class="fas fa-book"></i> Munif Store</h3>
                <p>Toko buku online terpercaya dengan koleksi buku terlengkap dan berkualitas.</p>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>

            <div class="footer-section">
                <h4>Navigasi</h4>
                <ul>
                    <li><a href="/Munif/index.php">Beranda</a></li>
                    <li><a href="/Munif/pages/books.php">Katalog Buku</a></li>
                    <li><a href="/Munif/pages/about.php">Tentang Kami</a></li>
                    <li><a href="/Munif/pages/contact.php">Kontak</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h4>Kategori</h4>
                <ul>
                    <li><a href="/Munif/pages/books.php?category=1">Fiksi</a></li>
                    <li><a href="/Munif/pages/books.php?category=3">Teknologi</a></li>
                    <li><a href="/Munif/pages/books.php?category=4">Bisnis</a></li>
                    <li><a href="/Munif/pages/books.php?category=5">Pendidikan</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h4>Hubungi Kami</h4>
                <ul>
                    <li><i class="fas fa-map-marker-alt"></i> Yogyakarta, Indonesia</li>
                    <li><i class="fas fa-phone"></i> +62 812-3456-7890</li>
                    <li><i class="fas fa-envelope"></i> info@munifstore.com</li>
                    <li><i class="fas fa-clock"></i> Senin - Sabtu: 09:00 - 17:00</li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> Munif Store. All Rights Reserved.</p>
        </div>
    </div>
</footer>

<script src="/Munif/assets/js/main.js"></script>

<!-- Chatbot Widget -->
<div class="chatbot-toggle" id="chatbotToggle" title="Tanya MunifBot">
    <i class="fas fa-comments"></i>
</div>

<div class="chatbot-panel" id="chatbotPanel">
    <div class="chatbot-header">
        <i class="fas fa-robot"></i>
        <strong>MunifBot</strong>
    </div>
    <div class="chatbot-messages" id="chatbotMessages"></div>
    <div class="chatbot-input">
        <input type="text" id="chatbotInput" placeholder="Tulis pertanyaan..." />
        <button id="chatbotSend">Kirim</button>
    </div>
</div>

<script>
    (function() {
        const toggle = document.getElementById('chatbotToggle');
        const panel = document.getElementById('chatbotPanel');
        const messagesEl = document.getElementById('chatbotMessages');
        const inputEl = document.getElementById('chatbotInput');
        const sendBtn = document.getElementById('chatbotSend');

        function addMessage(text, who = 'bot') {
            const row = document.createElement('div');
            row.className = 'chatbot-msg ' + who;
            const bubble = document.createElement('div');
            bubble.className = 'chatbot-bubble';
            bubble.textContent = text;
            row.appendChild(bubble);
            messagesEl.appendChild(row);
            messagesEl.scrollTop = messagesEl.scrollHeight;
        }

        async function sendMessage(text) {
            if (text === '') {
                // Request greeting/intro
                try {
                    const res = await fetch('/Munif/api/chatbot.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            message: ''
                        })
                    });
                    const data = await res.json();
                    if (data.success) addMessage(data.reply, 'bot');
                    return;
                } catch (e) {
                    addMessage('Tidak bisa terhubung ke server.', 'bot');
                    return;
                }
            }
            addMessage(text, 'user');
            try {
                const res = await fetch('/Munif/api/chatbot.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        message: text
                    })
                });
                const data = await res.json();
                if (data.success) {
                    addMessage(data.reply, 'bot');
                } else {
                    addMessage('Maaf, terjadi kesalahan.', 'bot');
                }
            } catch (e) {
                addMessage('Tidak bisa terhubung ke server.', 'bot');
            }
        }

        toggle.addEventListener('click', function() {
            const show = panel.style.display !== 'flex';
            panel.style.display = show ? 'flex' : 'none';
            if (show && messagesEl.childElementCount === 0) {
                sendMessage('');
            }
        });

        sendBtn.addEventListener('click', function() {
            const text = (inputEl.value || '').trim();
            if (!text) return;
            inputEl.value = '';
            sendMessage(text);
        });

        inputEl.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                sendBtn.click();
            }
        });
    })();
</script>
</body>

</html>