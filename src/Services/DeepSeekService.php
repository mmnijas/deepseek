<?php

namespace Mmnijas\DeepSeek\Services;

use Illuminate\Support\Facades\Http;

class DeepSeekService
{
    protected $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function chat(array $messages, array $params = [])
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->config['api_key'],
            'Content-Type' => 'application/json',
        ])->post($this->config['base_uri'] . '/chat/completions', array_merge([
            'model' => $this->config['model'],
            'messages' => $messages
        ], $params));

        return $response->json();
    }
}
