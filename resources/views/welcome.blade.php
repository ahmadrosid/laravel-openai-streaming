<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="antialiased">
    <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-gray-500 selection:text-white">
        <section class="bg-gray-100">
            <div class="relative items-center w-full px-5 py-12 mx-auto md:px-12 lg:px-16 max-w-7xl">
                <div class="flex w-full mx-auto">
                    <div class="relative inline-flex items-center m-auto align-middle">
                        <div class="relative max-w-6xl p-10 overflow-hidden bg-white rounded-3xl lg:p-20">
                            <div class="relative max-w-lg">
                                <div>
                                    <p class="text-2xl font-medium tracking-tight text-black sm:text-4xl">
                                        Laravel Streaming OpenAI
                                    </p>
                                    <p class="max-w-xl mt-4 text-base tracking-tight text-gray-500">
                                        Streaming OpenAI Responses in Laravel with Server-Sent Events (SSE).
                                        <a class="underline hover:text-pink-500" href="https://ahmadrosid.com/blog/laravel-openai-streaming-response">Read tutorial here</a>
                                    </p>
                                    <p id="question" class="max-w-xl mt-4 text-base font-bold tracking-tight text-gray-900 min-h-[1.5rem]"></p>
                                    <p id="result" class="max-w-xl mt-4 text-base tracking-tight text-gray-700 min-h-[240px]"></p>
                                </div>
                                <form id="form-question" class="flex flex-col items-center justify-center gap-3 mt-10 lg:flex-row lg:justify-start">
                                    <input required type="text" name="input" placeholder="Type your question here!" class="flex-1 border border-gray-600 p-2 rounded-md focus:outline-gray-700" />
                                    <button type="submit" href="#" class="items-center justify-center w-full px-6 py-2.5 text-center text-white duration-200 bg-black border-2 border-black rounded-md nline-flex hover:bg-transparent hover:border-black hover:text-black focus:outline-none lg:w-auto focus-visible:outline-black text-sm focus-visible:ring-black">
                                        Submit
                                        <span aria-hidden="true"> → </span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
        const form = document.querySelector('form');
        const result = document.getElementById("result");

        form.addEventListener('submit', (event) => {
            event.preventDefault();
            const input = event.target.input.value
            if (input === "") return;
            const question = document.getElementById("question");
            question.innerText = input;
            event.target.input.value = "";

            const source = new EventSource('/ask?question=' + encodeURIComponent(input));
            source.addEventListener('update', function(event) {
                if (event.data === "<END_STREAMING_SSE>") {
                    source.close();
                    return;
                }
                result.innerText += event.data
            });
        });
    </script>
</body>

</html>