<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;

class StreamsController extends Controller
{
    public function stream(Request $request)
    {
        $question = $request->query('question');
        return response()->stream(function () use ($question) {
            $stream = OpenAI::completions()->createStreamed([
                'model' => 'text-davinci-003',
                'prompt' => $question,
                'max_tokens' => 1024,
            ]);

            foreach ($stream as $response) {
                $text = $response->choices[0]->text;
                if (connection_aborted()) {
                    break;
                }

                echo "event: ping\n";
                echo 'data: ' . $text;
                echo "\n\n";
                ob_flush();
                flush();
            }

            echo "event: ping\n";
            echo 'data: <END_STREAMING>';
            echo "\n\n";
            ob_flush();
            flush();
        }, 200, [
            'Cache-Control' => 'no-cache',
            'Content-Type' => 'text/event-stream',
        ]);
    }
}
