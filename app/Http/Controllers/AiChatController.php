<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log; // Добавили логирование
use App\Models\Product;

class AiChatController extends Controller
{
    public function ask(Request $request)
    {
        try {
            $userMessage = $request->input('message');

            // 1. Берем список товаров
            $products = Product::where('is_active', true)
                ->select('name', 'price')
                ->limit(20) 
                ->get()
                ->map(function ($p) {
                    return "- {$p->name} ({$p->price} ₸)";
                })->implode("\n");

            // 2. Инструкция для ИИ
            $systemPrompt = "Ты — консультант магазина 'Vernyi'. 
                             Твоя цель — помочь клиенту и продать товар.
                             
                             НАШ АССОРТИМЕНТ:
                             {$products}
                             
                             Если товара нет в списке, скажи, что сейчас его нет в наличии.
                             Отвечай коротко (до 2 предложений) и вежливо.
                             
                             Клиент пишет: {$userMessage}";

            // 3. Настройки API
            $apiKey = env('GEMINI_API_KEY');
            
            // ⚠️ ВАЖНО: Используем 1.5, так как 2.5 не существует в API
            $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}";

            // 4. Отправка запроса
            // withoutVerifying() — отключает проверку SSL (важно для локалки)
            $response = Http::withoutVerifying()->post($url, [
                'contents' => [['parts' => [['text' => $systemPrompt]]]]
            ]);

            // Логируем, если Google вернул ошибку
            if ($response->failed()) {
                Log::error('Gemini API Error: ' . $response->body());
                return response()->json(['reply' => 'Извините, я немного устал (Ошибка API).'], 500);
            }

            $answer = $response->json()['candidates'][0]['content']['parts'][0]['text'] ?? 'Не понял вопрос.';
            
            return response()->json(['reply' => $answer]);

        } catch (\Exception $e) {
            // Записываем реальную ошибку в лог
            Log::error('Chat Controller Error: ' . $e->getMessage());
            return response()->json(['reply' => 'Ошибка сервера. Попробуйте позже.'], 500);
        }
    }
}