Here's a comprehensive README.md for your DeepSeek Laravel package:

# DeepSeek Laravel Integration

[![Latest Version](https://img.shields.io/packagist/v/mmnijas/deepseek.svg?style=flat-square)](https://packagist.org/packages/mmnijas/deepseek)
[![License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

A seamless integration package for DeepSeek API in Laravel applications. Easily interact with DeepSeek's AI capabilities through an expressive Laravel-friendly interface.

## Features

- 🚀 Simple facade-based API
- ⚡️ Guzzle HTTP client integration
- 🔧 Configurable through environment variables
- 📦 Out-of-the-box service provider
- 💬 Support for chat completions
- 🛠 Extensible architecture

## Requirements

- PHP 8.0 or higher
- Laravel 9.x or 10.x
- GuzzleHTTP 7.x

## Installation

1. Install via Composer:

```bash
composer require mmnijas/deepseek
```

2. Add your DeepSeek API key to `.env`:

```env
DEEPSEEK_API_KEY=your-api-key-here
```

3. (Optional) Publish config file:

```bash
php artisan vendor:publish --tag=deepseek-config
```

## Configuration

After publishing the config file (`config/deepseek.php`), you can customize:

```php
return [
    'api_key' => env('DEEPSEEK_API_KEY'),    // Your API key
    'base_uri' => 'https://api.deepseek.com/v1', // API endpoint
    'model' => 'deepseek-chat',              // Default model
    'timeout' => 30,                         // Request timeout in seconds
];
```

## Basic Usage

### 1. Using the Facade

```php
use Mmnijas\DeepSeek\Facades\DeepSeek;

$response = DeepSeek::chat([
    ['role' => 'user', 'content' => 'Hello, DeepSeek!']
]);

// Get the assistant's reply
echo $response['choices'][0]['message']['content'];
```

### 2. In a Controller

```php
use Mmnijas\DeepSeek\Facades\DeepSeek;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function handle(Request $request)
    {
        $messages = [
            ['role' => 'user', 'content' => $request->input('message')]
        ];

        $response = DeepSeek::chat($messages);

        return response()->json([
            'reply' => $response['choices'][0]['message']['content']
        ]);
    }
}
```

### 3. Blade View Example

```blade
<form action="/chat" method="POST">
    @csrf
    <input type="text" name="message" required>
    <button type="submit">Ask DeepSeek</button>
</form>

@isset($response)
<div class="response">
    {{ $response['choices'][0]['message']['content'] }}
</div>
@endisset
```

### 4. Artisan Command

Create a command:

```bash
php artisan make:command AskDeepSeek
```

Implement:

```php
use Mmnijas\DeepSeek\Facades\DeepSeek;

class AskDeepSeek extends Command
{
    protected $signature = 'ask:deepseek {question}';

    public function handle()
    {
        $response = DeepSeek::chat([
            ['role' => 'user', 'content' => $this->argument('question')]
        ]);

        $this->info($response['choices'][0]['message']['content']);
    }
}
```

Usage:

```bash
php artisan ask:deepseek "What is Laravel?"
```

## Advanced Usage

### Custom Parameters

```php
$response = DeepSeek::chat(
    messages: [
        ['role' => 'user', 'content' => 'Explain quantum computing in simple terms']
    ],
    params: [
        'temperature' => 0.7,
        'max_tokens' => 500,
        'top_p' => 1.0,
    ]
);
```

### Multiple Messages

```php
$messages = [
    ['role' => 'system', 'content' => 'You are a helpful assistant'],
    ['role' => 'user', 'content' => 'Who won the world series in 2020?'],
    ['role' => 'assistant', 'content' => 'The Los Angeles Dodgers won the World Series in 2020.'],
    ['role' => 'user', 'content' => 'Where was it played?']
];

$response = DeepSeek::chat($messages);
```

### Error Handling

```php
try {
    $response = DeepSeek::chat([...]);
} catch (\Exception $e) {
    // Handle API errors
    logger()->error('DeepSeek API Error: ' . $e->getMessage());
    return response()->json(['error' => 'Service unavailable'], 503);
}
```

## Rate Limiting

The DeepSeek API has rate limits. Implement Laravel's rate limiter in `AppServiceProvider`:

```php
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;

RateLimiter::for('deepseek', function ($job) {
    return Limit::perMinute(60); // Adjust based on your API plan
});
```

## Testing

Add to your test case:

```php
public function test_deepseek_integration()
{
    Http::fake([
        'api.deepseek.com/v1/chat/completions' => Http::response([
            'choices' => [
                ['message' => ['content' => 'Mocked response']]
            ]
        ], 200)
    ]);

    $response = DeepSeek::chat([
        ['role' => 'user', 'content' => 'Test message']
    ]);

    $this->assertEquals('Mocked response', $response['choices'][0]['message']['content']);
}
```

## Security

Always:

- 🔑 Keep your API key secret
- 🛡 Validate user input
- ⏱ Implement rate limiting
- 📝 Follow DeepSeek's API guidelines

## Common Issues

### Missing API Key

**Error:** "DeepSeek API key not configured"  
**Solution:** Verify `.env` contains `DEEPSEEK_API_KEY`

### Network Errors

**Error:** "Could not connect to DeepSeek API"  
**Solution:**

1. Check internet connection
2. Verify API endpoint in config
3. Review firewall settings

### Invalid Response Format

**Error:** "Undefined index choices"  
**Solution:**

```php
// Check for successful response first
if (isset($response['choices'])) {
    // Process response
}
```

## Changelog

See [CHANGELOG.md](CHANGELOG.md) for recent changes.

## License

The MIT License (MIT). See [LICENSE.md](LICENSE.md) for details.

## Contributing

Pull requests are welcome! Please follow PSR coding standards and include tests.

---

📧 **Support:** hello@mmnijas.in
🌐 **Documentation:** [https://mmnijas.in/docs/deepseek](https://mmnijas.in/docs/deepseek)
