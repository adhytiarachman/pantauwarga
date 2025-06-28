<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\ChatTopic;
use App\Models\ChatMessage;
use League\CommonMark\CommonMarkConverter;

class ChatAIController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $topics = ChatTopic::where('user_id', $user->id)->latest()->get();

        return view('user.chat-ai', [
            'topics' => $topics,
            'activeTopic' => null,
            'messages' => [],
        ]);
    }

    public function ask(Request $request)
    {
        $user = Auth::user();
        $prompt = $request->input('message');
        $topicId = $request->input('topic_id');
        $title = $request->input('title');
        $fromModal = $request->has('from_modal');

        if (!$prompt) {
            if ($fromModal) {
                return back()->with('error', 'Pesan tidak boleh kosong.');
            }
            return response()->json(['reply' => '❌ Prompt tidak boleh kosong.'], 422);
        }

        // 🔍 Tentukan topik
        if ($title) {
            // Topik baru dari modal
            $topic = ChatTopic::create([
                'user_id' => $user->id,
                'title' => $title,
            ]);
        } elseif ($topicId) {
            // Topik lama
            $topic = ChatTopic::where('id', $topicId)
                ->where('user_id', $user->id)
                ->firstOrFail();
        } else {
            // Topik baru default
            $topic = ChatTopic::create([
                'user_id' => $user->id,
                'title' => 'Topik Chat ' . now()->format('Y-m-d H:i:s'),
            ]);
        }

        // 📚 Ambil histori pesan sebelumnya
        $history = $topic->messages()->orderBy('created_at')->take(15)->get();

        $messages = [
            ['role' => 'system', 'content' => 'Kamu adalah asisten AI yang membahas topik: ' . $topic->title],
        ];

        foreach ($history as $msg) {
            $messages[] = [
                'role' => $msg->role,
                'content' => $msg->message,
            ];
        }

        $messages[] = ['role' => 'user', 'content' => $prompt];

        // 💾 Simpan pesan user
        ChatMessage::create([
            'chat_topic_id' => $topic->id,
            'role' => 'user',
            'message' => $prompt,
        ]);

        // 🤖 Kirim ke OpenRouter
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('OPENROUTER_API_KEY'),
            'HTTP-Referer' => 'http://localhost:8000',
            'Content-Type' => 'application/json',
        ])->post('https://openrouter.ai/api/v1/chat/completions', [
                    'model' => 'google/gemini-2.0-flash-001',
                    'messages' => $messages,
                    'max_tokens' => 10000,
                    'temperature' => 0.7
                ]);

        $json = $response->json();

        if (isset($json['error'])) {
            if ($fromModal) {
                return back()->with('error', '❌ Gagal mendapatkan respon dari AI.');
            }
            return response()->json([
                'reply' => '❌ Error dari AI: ' . $json['error']['message']
            ], 500);
        }

        $reply = $json['choices'][0]['message']['content'] ?? '🤖 AI tidak merespon.';

        // 💾 Simpan respon AI
        ChatMessage::create([
            'chat_topic_id' => $topic->id,
            'role' => 'assistant',
            'message' => $reply,
        ]);

        // 🔃 Konversi Markdown ke HTML
        $converter = new CommonMarkConverter([
            'html_input' => 'escape',
            'allow_unsafe_links' => false,
        ]);

        $html = $converter->convert($reply)->getContent();

        if ($fromModal) {
            return redirect()->route('user.chat.by.topic', $topic->id);
        }

        return response()->json([
            'reply' => $html,
            'topic_id' => $topic->id,
        ]);
    }

    public function newTopic(Request $request)
    {
        $user = Auth::user();

        $topic = ChatTopic::create([
            'user_id' => $user->id,
            'title' => 'Topik Chat ' . now()->format('Y-m-d H:i:s'),
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'topic_id' => $topic->id,
            ]);
        }

        // fallback (jika ada akses GET manual)
        return redirect()->route('user.chat.by.topic', $topic->id);
    }

    public function renameTopic(Request $request, $id)
    {
        $request->validate(['title' => 'required|string|max:255']);

        $topic = auth()->user()->topics()->findOrFail($id);
        $topic->title = $request->title;
        $topic->save();

        return response()->json(['success' => true, 'title' => $topic->title]);
    }

    public function deleteTopic($id)
    {
        $topic = auth()->user()->topics()->findOrFail($id);
        $topic->delete();

        return response()->json(['success' => true]);
    }


}
