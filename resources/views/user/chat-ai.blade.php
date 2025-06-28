@extends('layouts.user')
@php $hideNavbar = true; @endphp


@php
    use Illuminate\Support\Str;
@endphp


@section('title', 'CITCHAT.AI')

@section('content')
    <style>
        .chat-layout {
            margin-left: 250px;
            margin-top: 0px;
            /* biar tidak tertimpa navbar */
            display: flex;
            min-height: calc(100vh - 60px);
            /* sisa tinggi di bawah navbar */
            background: linear-gradient(135deg, #f5f7fa, #e4ecf3);
            border-radius: 0;
            overflow-x: visible;

        }

        .chat-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 250px;
            background: linear-gradient(180deg, #ffffffcc 0%, #f7f9fcdd 100%);
            backdrop-filter: blur(8px);
            border-right: 1px solid #e0e0e0;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.03);
            padding: 2rem 1.25rem;
            overflow-y: auto;
            z-index: 10001 !important;
            transition: all 0.3s ease;
            overflow-x: visible;

        }

        .chat-sidebar {
            overflow-y: auto;
            overflow-x: hidden;
        }



        .chat-sidebar li {
            position: relative;
            overflow: visible !important;
            /* ✅ biar dropdown bisa keluar */
        }

        .chat-sidebar .dropdown-menu {
            z-index: 10002 !important;
            position: absolute !important;
        }

        .chat-sidebar .dropdown-menu {
            position: absolute !important;
            top: 100%;
            right: 0;
            z-index: 9999;
            transform: translateY(0.25rem);
            min-width: 140px;
            font-size: 0.85rem;
            white-space: nowrap;
        }

        .chat-sidebar::-webkit-scrollbar {
            width: 8px;
        }

        .chat-sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        .chat-sidebar::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.15);
            border-radius: 10px;
            transition: background 0.3s ease;
        }

        .chat-sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(0, 0, 0, 0.3);
        }

        /* Firefox */
        .chat-sidebar {
            scrollbar-width: thin;
            scrollbar-color: rgba(0, 0, 0, 0.2) transparent;
        }


        .chat-sidebar h6 {
            font-weight: 600;
            font-size: 0.9rem;
            color: #6c757d;
            margin-bottom: 1rem;
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 0.5rem;
        }


        .chat-sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .chat-sidebar li a {
            display: block;
            padding: 10px 14px;
            border-radius: 10px;
            text-decoration: none;
            color: #333;
            background-color: transparent;
            transition: background-color 0.25s ease, color 0.25s ease;
            font-size: 0.95rem;
        }

        .chat-sidebar li a:hover,
        .chat-sidebar li a.active {
            background-color: #edf2f7;
            color: #0d6efd;
            font-weight: 600;
        }

        .chat-sidebar .btn-group.btn-group-sm {
            margin-top: 0.3rem;
        }

        .chat-sidebar .btn-outline-secondary,
        .chat-sidebar .btn-outline-danger {
            padding: 3px 6px;
            font-size: 0.8rem;
            border-radius: 6px;
        }


        .chat-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: stretch;
            position: relative;
            padding: 0;
            z-index: 1;
        }

        .chat-wrapper.normal+#chat-box {
            display: block;
        }

        #chat-box {
            flex-grow: 1;
            overflow-y: auto;
            max-height: calc(100vh - 140px);
            padding: 0;
            padding-left: 7rem;
            /* ✅ Tambah jarak kiri */
            padding-right: 7rem;
            scrollbar-gutter: stable both-edges;
            z-index: 1;
            position: relative;
        }



        .chat-input-wrapper {
            position: fixed;
            bottom: 20px;
            left: 275px;
            right: 20px;
            z-index: 99;
            max-width: calc(100% - 295px);
        }

        .chat-wrapper.centered .chat-input-wrapper {
            position: static;
            margin-top: 2rem;
            margin-left: auto;
            margin-right: auto;
            max-width: 800px;
            width: 100%;
            transform: none;
        }

        .chat-wrapper.normal .chat-input-wrapper {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            max-width: 700px;
            padding: 0 1rem;
            z-index: 100;
        }

        .chat-input-group {
            display: flex;
            align-items: center;
            gap: 10px;
            background: linear-gradient(to right, #ffffff, #f8f9fa);
            border-radius: 25px;
            padding: 14px 28px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            border: 1px solid #dee2e6;
            width: 100%;
        }

        .chat-input-group textarea {
            flex: 1;
            border: none;
            outline: none;
            background: transparent;
            font-size: 1rem;
            color: #333;
            width: 100%;
            resize: none;
            line-height: 1.5;
            min-height: 42px;
            max-height: 200px;
            overflow-y: auto;
            padding: 0;
            font-family: inherit;
        }

        .chat-input-group textarea::placeholder {
            color: #999;
        }

        .chat-send-btn {
            background-color: #272727;
            border: none;
            padding: 10px 14px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
        }

        .chat-send-btn:hover {
            background-color: #999999;
        }

        .chat-send-btn svg {
            fill: #fff;
            width: 10px;
            height: 20px;
        }

        .chat-bubble {
            width: 100%;
            padding: 10px 0;
            margin-bottom: 10px;
            animation: fadeInUp 0.4s ease-in-out;
        }

        .chat-bubble.user {
            background: #f1f1f1;
            color: #000;

            border-radius: 1rem;
            border-bottom-right-radius: 0;
            padding: 10px 15px;

            display: inline-block;
            word-wrap: break-word;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            max-width: fit-content;
        }

        .chat-bubble.ai {
            background-color: transparent;
            color: #000;
            align-self: stretch;
            border: none;
            box-shadow: none;
            padding: 1rem 1.5rem;
        }

        .chat-bubble.ai * {
            line-height: 1.6;
        }

        .chat-bubble.ai code {
            background: #f7f7f8;
            padding: 2px 6px;
            border-radius: 5px;
            font-family: monospace;
            font-size: 0.95em;
        }

        .chat-bubble.ai pre {
            background: #f4f4f4;
            padding: 1em;
            border-radius: 10px;
            overflow-x: auto;
            margin-top: 0.5em;
            font-family: 'Courier New', Courier, monospace;
            font-size: 0.9em;
        }

        .chat-bubble.ai blockquote {
            border-left: 4px solid #ccc;
            margin: 1rem 0;
            padding-left: 1rem;
            color: #555;
            font-style: italic;
        }

        .chat-bubble.ai h1,
        .chat-bubble.ai h2,
        .chat-bubble.ai h3 {
            font-weight: bold;
            margin-top: 1rem;
            margin-bottom: 0.5rem;
        }

        .typing {
            font-style: italic;
            color: #6c757d;
        }

        .dropdown-menu.show {
            display: block !important;
            z-index: 99999 !important;
            background-color: white;
        }


        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(10px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .typewriter-title {
            display: inline-block;
            border-right: 3px solid rgba(0, 0, 0, 0.75);
            white-space: nowrap;
            overflow: hidden;
            animation: blinkCursor 0.8s steps(1) infinite;
            font-size: 2.2rem;
            letter-spacing: 1px;
            transition: all 0.5s ease;
            position: relative;
            text-align: center;

        }

        .chat-wrapper .chat-input-wrapper,
        .chat-wrapper #chat-box {
            z-index: 1;
        }

        .chat-sidebar .dropdown-menu {
            z-index: 99999 !important;
        }

        .chat-wrapper.centered .typewriter-title {
            position: absolute;
            top: 40%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 2.5rem;
            color: #000;
        }



        .chat-wrapper.normal .typewriter-title {
            position: static;
            transform: none;
            font-size: 1.5rem;
            text-align: left;
            margin-bottom: 1rem;
        }



        .chat-wrapper.normal .typewriter-title {
            position: absolute;
            top: 0px;
            left: 0px;
            /* sesuaikan dengan width .chat-sidebar */
            font-size: 1.2rem;
            font-weight: bold;
            margin: 0;
            transform: none;
            z-index: 10;


        }


        .chat-wrapper.centered .chat-input-wrapper {
            position: relative;
            bottom: auto;
            left: auto;
            right: auto;
            transform: none;
            max-width: 600px;
            width: 100%;
            padding: 0;
            margin-top: 1.5rem;
        }

        .chat-wrapper.normal .chat-input-wrapper {
            position: fixed;
            bottom: 20px;
            left: calc(50% + 125px);
            /* <- perbaikan */
            transform: translateX(-50%);
            width: 100%;
            max-width: 700px;
            padding: 0 1rem;
            z-index: 100;
        }



        .chat-wrapper.centered #chat-box {
            display: none;
        }

        .chat-wrapper.centered {
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 0;
            position: relative;
            text-align: center;
        }

        .chat-wrapper.centered #chat-box {
            display: none;
        }

        .chat-wrapper.normal #chat-box {
            display: block;
        }

        .chat-sidebar .dropdown-menu {
            min-width: 140px;
            font-size: 0.85rem;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            border-radius: 8px;
        }

        .chat-sidebar .dropdown-menu a {
            padding: 8px 16px;
            transition: background 0.2s;
        }

        .chat-sidebar .dropdown-menu a:hover {
            background-color: #f1f1f1;
        }

        .dropdown-toggle::after {
            display: none !important;
        }


        .chat-row {
            display: flex;
            width: 100%;
            margin-bottom: 0.5rem;
        }

        .chat-row.user {
            justify-content: flex-end;
        }

        .chat-row.ai {
            justify-content: flex-start;
        }

        /* Scrollbar khusus untuk #chat-box */
        #chat-box::-webkit-scrollbar {
            width: 8px;
        }

        #chat-box::-webkit-scrollbar-track {
            background: transparent;
        }

        #chat-box::-webkit-scrollbar-thumb {
            background-color: rgba(0, 0, 0, 0.15);
            border-radius: 6px;
            transition: background-color 0.3s ease;
        }

        #chat-box::-webkit-scrollbar-thumb:hover {
            background-color: rgba(0, 0, 0, 0.3);
        }

        /* Firefox support */
        #chat-box {
            scrollbar-width: thin;
            scrollbar-color: rgba(0, 0, 0, 0.15) transparent;
        }

        body.dark-mode {
            background: #1e1e1e;
            color: #f1f1f1;
        }

        body.dark-mode .chat-layout {
            background: #1e1e1e;
        }

        body.dark-mode .chat-sidebar {
            background: #161616;

            border-right: 1px solid #333;
            color: #eee;
        }


        body.dark-mode .chat-sidebar h6 {
            color: #ccc;
            border-bottom-color: #444;
        }

        body.dark-mode .chat-sidebar li a {
            color: #ddd;
        }

        body.dark-mode .chat-sidebar li a:hover,
        body.dark-mode .chat-sidebar li a.active {
            background-color: #333;
            color: #00bfff;
        }

        body.dark-mode .chat-input-group {
            background: #2b2b2b;
            color: white;
            border: 1px solid #444;
        }



        body.dark-mode .chat-send-btn {
            background-color: #636363;
        }

        body.dark-mode .chat-send-btn:hover {
            background-color: #505050;
        }

        body.dark-mode .chat-bubble.user {
            background: #2c2c2c;
            color: #fff;
        }

        body.dark-mode .chat-bubble.ai {
            color: #eee;
        }

        @keyframes blinkCursor {

            0%,
            49% {
                border-color: rgba(0, 0, 0, 0.75);
            }

            50%,
            100% {
                border-color: transparent;
            }
        }

        body {
            background: linear-gradient(135deg, #f5f7fa, #e4ecf3);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        @media (max-width: 576px) {
            .chat-bubble.user {
                max-width: 100%;
            }

            .chat-wrapper.normal+.chat-input-wrapper {
                padding: 0 0.5rem;
            }

            .chat-divider {
                height: 1px;
                background-color: rgba(0, 0, 0, 0.1);
                margin: 0 7rem 1rem 7rem;
            }



        }
    </style>

    <div class="container-fluid py-4">

        <div class="chat-layout">
            {{-- Sidebar Topik --}}

            <div class="chat-sidebar">




                <div class="d-flex justify-content-between align-items-center ">
                    <span><button class="btn btn-light btn-sm w-100 mb-3" onclick="createNewTopic()">
                            <i class="bi bi-pencil-square"></i> Obrolan baru</button></span>
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <span>
                        <a href="{{ route('user.dashboard') }}" class="btn btn-light btn-sm w-100 mb-3">
                            <i class="bi bi-house"></i>
                            Home
                        </a>
                    </span>

                </div>

                <div class="d-flex justify-content-between align-items-center ">
                    <span><button class="btn btn-light btn-sm w-100 mb-3" id="theme-toggle">
                            <i class="bi bi-moon-stars-fill me-2"></i></button></span>
                </div>


                <h6>Obrolan</h6>
                <ul>
                    @foreach($topics as $t)
                        <li class="mb-2" style="position: relative; overflow: visible;">
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('user.chat.by.topic', $t->id) }}"
                                    class="{{ ($topic->id ?? null) == $t->id ? 'active' : '' }}"
                                    style="flex-grow: 1; text-decoration: none;">
                                    {{ Str::limit($t->title, 30) }}
                                </a>
                                <div class="dropdown ms-2" style="position: relative;">
                                    <button class="btn btn-sm  border-0 dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="bi bi-three-dots"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end ">
                                        <li><a class="dropdown-item text-primary" href="#"
                                                onclick="renameTopic({{ $t->id }}, '{{ addslashes($t->title) }}')">✏️ Ganti
                                                nama</a></li>
                                        <li><a class="dropdown-item text-danger" href="#"
                                                onclick="deleteTopic({{ $t->id }})">🗑️ Hapus</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>

                    @endforeach
                </ul>
            </div>

            {{-- Chat Main --}}
            <div class="chat-wrapper centered" id="chat-wrapper">

                <h2 id="animated-title" class="text-center fw-bold typewriter-title">Ask Citchat AI</h2>
                <div class="chat-divider"></div>


                {{-- Input --}}
                <div class="chat-input-wrapper">
                    <div class="chat-input-group">
                        <input type="hidden" id="topic-id" value="{{ $topic->id ?? '' }}">
                        <textarea id="user-message" placeholder="Tanyakan apa saja..."
                            onkeydown="handleKeyPress(event)"></textarea>
                        <button class="chat-send-btn" onclick="sendMessage()" aria-label="Kirim">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div id="chat-box" class="mt-4">
                    @foreach ($messages as $msg)
                        <div class="chat-row {{ $msg->role === 'user' ? 'user' : 'ai' }}">
                            <div class="chat-bubble {{ $msg->role === 'user' ? 'user' : 'ai' }}">
                                {!! nl2br(e($msg->message)) !!}
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>


    <script>
        function handleKeyPress(event) {
            const textarea = event.target;

            // Shift + Enter = baris baru
            if (event.key === 'Enter' && event.shiftKey) {
                return; // biarkan default (newline)
            }

            // Enter tanpa shift = kirim pesan
            if (event.key === 'Enter') {
                event.preventDefault(); // cegah newline
                sendMessage();
            }
        }

        async function sendMessage() {
            const input = document.getElementById('user-message');
            const message = input.value.trim();
            if (!message) return;

            let topicId = document.getElementById('topic-id').value;

            const wrapper = document.getElementById('chat-wrapper');
            wrapper.classList.remove('centered');
            wrapper.classList.add('normal');

            const chatBox = document.getElementById('chat-box');
            chatBox.classList.remove('d-none');

            const chatRow = document.createElement('div');
            chatRow.className = 'chat-row user';

            const userBubble = document.createElement('div');
            userBubble.className = 'chat-bubble user';
            userBubble.innerText = message;

            chatRow.appendChild(userBubble);
            chatBox.appendChild(chatRow);

            input.value = '';
            input.style.height = 'auto';

            const typingDiv = document.createElement('div');
            typingDiv.className = 'chat-bubble ai typing';
            typingDiv.innerText = 'AI sedang mengetik...';
            chatBox.appendChild(typingDiv);
            chatBox.scrollTop = chatBox.scrollHeight;

            try {
                const response = await fetch(`/user/chat-ai/ask`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ message, topic_id: topicId })
                });

                const data = await response.json();
                typingDiv.remove();

                const chatRowAi = document.createElement('div');
                chatRowAi.className = 'chat-row ai';

                const aiBubble = document.createElement('div');
                aiBubble.className = 'chat-bubble ai';

                chatRowAi.appendChild(aiBubble);
                chatBox.appendChild(chatRowAi);

                typeWriterHtml(data.reply, aiBubble);

                // ✅ Update topicId jika baru dibuat
                if (data.topic_id) {
                    document.getElementById('topic-id').value = data.topic_id;
                    topicId = data.topic_id;
                }

            } catch (error) {
                typingDiv.remove();
                const errorBubble = document.createElement('div');
                errorBubble.className = 'chat-bubble ai';
                errorBubble.innerText = '❌ Gagal mendapatkan respon dari AI.';
                chatBox.appendChild(errorBubble);
            }

            chatBox.scrollTop = chatBox.scrollHeight;
        }

        function handleNewTopicSubmit(event) {
            const title = document.getElementById('new-topic-title').value.trim();
            const message = document.getElementById('first-message').value.trim();
            if (!title || !message) return false;

            // Form akan submit normal POST ke /user/chat-ai dan buat topik baru
            return true;
        }

        async function createNewTopic() {
            try {
                const res = await fetch('{{ route('user.chat-ai.new') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                });

                const data = await res.json();
                const topicId = data.topic_id;

                // Update topic id hidden input
                document.getElementById('topic-id').value = topicId;

                // Kosongkan chat box
                const chatBox = document.getElementById('chat-box');
                chatBox.innerHTML = '';

                // Reset ke tampilan awal
                const wrapper = document.getElementById('chat-wrapper');
                wrapper.classList.remove('normal');
                wrapper.classList.add('centered');

            } catch (error) {
                alert('❌ Gagal membuat topik baru.');
            }
        }


        function renameTopic(id, oldTitle) {
            const newTitle = prompt('Ganti judul topik:', oldTitle);
            if (!newTitle || newTitle === oldTitle) return;

            fetch(`/user/chat-ai/${id}/rename`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({ title: newTitle })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) location.reload();
                    else alert('❌ Gagal mengganti judul.');
                });
        }

        function deleteTopic(id) {
            if (!confirm('Yakin ingin menghapus topik ini?')) return;

            fetch(`/user/chat-ai/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) location.reload();
                    else alert('❌ Gagal menghapus topik.');
                });
        }

        function typeWriterHtml(html, container) {
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = html;
            const elements = Array.from(tempDiv.childNodes);
            let i = 0;

            function renderNext() {
                if (i >= elements.length) {
                    if (typeof MathJax !== 'undefined') MathJax.typesetPromise([container]);
                    return;
                }

                const node = elements[i++];
                if (node.nodeType === Node.TEXT_NODE) {
                    const span = document.createElement('span');
                    container.appendChild(span);
                    animateText(node.textContent, span, renderNext);
                } else if (node.nodeType === Node.ELEMENT_NODE) {
                    const el = node.cloneNode(false);
                    container.appendChild(el);
                    animateText(node.innerHTML, el, renderNext, true);
                } else {
                    renderNext();
                }
            }

            function animateText(text, element, callback, isHTML = false) {
                let j = 0;
                function type() {
                    if (j <= text.length) {
                        element.innerHTML = isHTML ? text.slice(0, j) : text.slice(0, j);
                        j++;
                        setTimeout(type, 8);
                    } else {
                        callback();
                    }
                }
                type();
            }

            renderNext();
        }

        document.addEventListener('DOMContentLoaded', () => {
            const title = document.getElementById('animated-title');
            const text = 'CITCHAT.AI';
            let index = 0;

            function type() {
                if (index <= text.length) {
                    title.textContent = text.slice(0, index++);
                    setTimeout(type, 120);
                }
            }
            type();

            // ✅ Tambahan: ubah layout kalau chat sudah ada
            const chatBox = document.getElementById('chat-box');
            const hasMessages = chatBox && chatBox.children.length > 0;

            if (hasMessages) {
                const wrapper = document.getElementById('chat-wrapper');
                wrapper.classList.remove('centered');
                wrapper.classList.add('normal');
            }
        });


    </script>


    <script>
        const toggleBtn = document.getElementById('theme-toggle');
        const body = document.body;

        // Load from localStorage
        const currentTheme = localStorage.getItem('theme');
        if (currentTheme === 'dark') {
            body.classList.add('dark-mode');
            toggleBtn.innerHTML = '<i class="bi bi-brightness-high-fill me-2"></i>';
        }

        toggleBtn.addEventListener('click', () => {
            body.classList.toggle('dark-mode');

            if (body.classList.contains('dark-mode')) {
                localStorage.setItem('theme', 'dark');
                toggleBtn.innerHTML = '<i class="bi bi-brightness-high-fill me-2"></i>';
            } else {
                localStorage.setItem('theme', 'light');
                toggleBtn.innerHTML = '<i class="bi bi-moon-stars-fill me-2"></i>';
            }
        });
    </script>

    <script>
        window.MathJax = {
            tex: {
                inlineMath: [['$', '$'], ['\\(', '\\)']],
                displayMath: [['$$', '$$'], ['\\[', '\\]']],
                processEscapes: true
            },
            svg: { fontCache: 'global' }
        };
    </script>
    <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-svg.js"></script>

    <!-- Tambahkan ke bagian bawah halaman sebelum </body> -->
    <style>
        .custom-toast {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #1d1d1d;
            color: #fff;
            padding: 16px 24px;
            border-radius: 10px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.25);
            font-size: 1rem;
            opacity: 0;
            pointer-events: none;
            transform: translateY(20px);
            transition: opacity 0.4s ease, transform 0.4s ease;
            z-index: 9999;
        }

        .custom-toast.show {
            opacity: 1;
            pointer-events: auto;
            transform: translateY(0);
        }
    </style>

    <div id="custom-toast" class="custom-toast"></div>

    <script>
        function showToast(message) {
            const toast = document.getElementById('custom-toast');
            toast.textContent = message;
            toast.classList.add('show');
            setTimeout(() => {
                toast.classList.remove('show');
            }, 3000);
        }

        async function renameTopic(id, oldTitle) {
            const { value: newTitle } = await Swal.fire({
                title: 'Edit Judul',
                input: 'text',
                inputValue: oldTitle,
                showCancelButton: true,
                confirmButtonText: 'Simpan',
                cancelButtonText: 'Batal',
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-secondary'
                },
                buttonsStyling: false
            });

            if (!newTitle || newTitle === oldTitle) return;

            fetch(`/user/chat-ai/${id}/rename`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ title: newTitle })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        showToast('✅ Judul berhasil diperbarui!');
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        showToast('❌ Gagal memperbarui judul.');
                    }
                });
        }

        function deleteTopic(id) {
            Swal.fire({
                title: 'Hapus Topik?',
                text: 'Topik akan dihapus permanen.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then(result => {
                if (result.isConfirmed) {
                    fetch(`/user/chat-ai/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                showToast('🗑️ Topik berhasil dihapus!');
                                setTimeout(() => location.reload(), 1500);
                            } else {
                                showToast('❌ Gagal menghapus topik.');
                            }
                        });
                }
            });
        }
    </script>



    <!-- Tambahkan ini ke dalam <head> untuk animasi popup modern -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



@endsection