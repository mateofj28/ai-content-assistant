<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class OpenAIService
{
    private $apiKey;

    public function __construct()
    {
        $this->apiKey = env('GROQ_API_KEY');
    }

    
   public function processText($text)
    {
        $response = Http::withoutVerifying()->withHeaders([
            'Authorization' => "Bearer {$this->apiKey}",
            'Content-Type' => 'application/json',
        ])->post('https://api.groq.com/openai/v1/chat/completions', [
            'model' => 'llama-3.1-8b-instant',
            'messages' => [
                [
                    'role' => 'user',
                    'content' => "
                        Analiza el siguiente texto y responde SIEMPRE en el siguiente formato EXACTO:

                        **Resumen**
                        (Un resumen claro y breve del texto)

                        **Profesional**
                        (Una versión mejorada, formal y profesional del texto)

                        **Redes**
                        (Una versión corta, atractiva y optimizada para redes sociales)

                        REGLAS:
                        - No cambies los títulos (**Resumen**, **Profesional**, **Redes**)
                        - No agregues otros títulos
                        - No dejes secciones vacías
                        - No uses símbolos como '-' o 'N/A'

                        Texto:
                        $text"
                ]
            ],
        ]);

        if ($response->failed()) {
            return [
                'error' => true,
                'message' => $response->body()
            ];
        }

        return [
            'result' => $response->json()['choices'][0]['message']['content'] ?? 'No response'
        ];
    }
}