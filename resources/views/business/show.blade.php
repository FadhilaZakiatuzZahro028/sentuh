<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $business->name }} — SENTUH</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-100 text-slate-900">

    <main class="mx-auto min-h-screen max-w-xl bg-white shadow-sm">

        <div class="h-44 overflow-hidden bg-slate-200">
            @if ($coverUrl)
                <img
                    src="{{ $coverUrl }}"
                    alt="Sampul {{ $business->name }}"
                    class="h-full w-full object-cover"
                >
            @endif
        </div>

        <div class="px-6 pb-12">

            @if ($logoUrl)
                <img
                    src="{{ $logoUrl }}"
                    alt="Logo {{ $business->name }}"
                    class="relative -mt-10 mb-5 h-20 w-20 rounded-2xl
                           border-4 border-white bg-white object-cover"
                >
            @else
                <div class="h-6"></div>
            @endif

            <h1 class="text-3xl font-bold">
                {{ $business->name }}
            </h1>

            @if ($business->tagline)
                <p class="mt-2 text-slate-600">
                    {{ $business->tagline }}
                </p>
            @endif

            @if ($business->description)
                <p class="mt-5 whitespace-pre-line text-slate-700">
                    {{ $business->description }}
                </p>
            @endif

            @if ($business->address)
                <div class="mt-5 rounded-xl bg-slate-50 p-4">
                    <p class="text-sm font-semibold">Alamat</p>
                    <p class="mt-1 text-sm text-slate-600">
                        {{ $business->address }}
                    </p>
                </div>
            @endif

            <div class="mt-8 space-y-3">
                @foreach ($links as $link)
                    <a
                        href="{{ $link->url }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        style="background-color: {{ $accentColor }}"
                        class="block min-h-12 rounded-xl px-5 py-3
                               text-center font-semibold text-white
                               focus-visible:outline-2
                               focus-visible:outline-offset-2"
                    >
                        {{ $link->label }}
                    </a>
                @endforeach
            </div>

        </div>
    </main>

</body>
</html>