<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatTopic;
use App\Models\ChatMessage;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        // Redirect ke topik pertama user, atau buat topik baru jika belum ada
        $topic = ChatTopic::where('user_id', auth()->id())->latest()->first();

        if (!$topic) {
            $topic = ChatTopic::create([
                'user_id' => auth()->id(),
                'title' => 'Topik Baru',
            ]);
        }

        return redirect()->route('chat.by.topic', $topic->id);
    }

    public function chatByTopic($topicId)
    {
        if ($topicId === 'new') {
            $topic = ChatTopic::create([
                'user_id' => auth()->id(),
                'title' => 'Topik Baru',
            ]);

            return redirect()->route('chat.by.topic', $topic->id);
        }

        $topic = ChatTopic::where('id', $topicId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $topics = ChatTopic::where('user_id', auth()->id())->latest()->get();
        $messages = ChatMessage::where('chat_topic_id', $topic->id)->get();

        return view('user.chat-ai', compact('topic', 'topics', 'messages'));
    }

    public function sendMessage(Request $request, $topicId)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $topic = ChatTopic::where('id', $topicId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // Simpan pesan user
        ChatMessage::create([
            'chat_topic_id' => $topic->id,
            'role' => 'user',
            'message' => $request->message,
        ]);

        // 🔁 Simulasi respons dari AI
        $aiResponse = "Ini adalah respons dari AI untuk pesan: " . $request->message;

        // Simpan respons AI
        ChatMessage::create([
            'chat_topic_id' => $topic->id,
            'role' => 'assistant',
            'message' => $aiResponse,
        ]);

        // 🔙 Kembalikan JSON agar fetch bisa baca
        return response()->json([
            'reply' => $aiResponse,
            'topic_id' => $topic->id,
        ]);
    }



}