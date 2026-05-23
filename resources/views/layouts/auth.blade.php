<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Masuk') — TELENT</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="h-full bg-white">

<div class="min-h-screen flex">

    {{-- ═══════════════════════════════════════════
         LEFT PANEL — Foto Industri + Overlay Hijau
    ════════════════════════════════════════════ --}}
    <div class="hidden lg:block lg:w-[55%] relative overflow-hidden flex-shrink-0">

        {{-- Background image --}}
        <img
            src="https://images.unsplash.com/photo-1504328345606-18bbc8c9d7d1?w=1400&q=85&auto=format&fit=crop"
            alt="TELENT Industrial Facility"
            class="absolute inset-0 w-full h-full object-cover object-center"
        >

        {{-- Green overlay gradient --}}
        <div class="absolute inset-0"
             style="background: linear-gradient(to bottom,
                rgba(5,46,22,0.40) 0%,
                rgba(5,46,22,0.50) 40%,
                rgba(5,46,22,0.78) 100%);">
        </div>

        {{-- Content --}}
        <div class="relative z-10 h-full flex flex-col justify-end p-12">

            {{-- Badge --}}
            <div class="flex items-center gap-3 mb-5">
                <div class="w-8 h-0.5 bg-emerald-400"></div>
                <span class="text-emerald-300 text-xs font-bold tracking-widest uppercase">
                    Sustainability &amp; Efficiency
                </span>
            </div>

            {{-- Headline --}}
            <h2 class="text-white font-extrabold leading-tight mb-4"
                style="font-size: clamp(1.75rem, 2.8vw, 2.75rem);">
                Membangun Masa Depan<br>Berkelanjutan
            </h2>

            {{-- Sub-text --}}
            <p class="text-white/70 text-sm leading-relaxed mb-7 max-w-sm">
                Platform terintegrasi TELENT untuk pengelolaan sumber daya
                industri yang cerdas, efisien, dan ramah lingkungan.
            </p>

            {{-- Badges --}}
            <div class="flex items-center gap-5">
                <div class="flex items-center gap-2 text-white/80 text-sm font-medium">
                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955
                                 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824
                                 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622
                                 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    ISO 14001 Certified
                </div>
                <div class="w-1 h-1 rounded-full bg-white/30"></div>
                <div class="flex items-center gap-2 text-white/80 text-sm font-medium">
                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0
                                 0H9m11 11v-5h-.581m0 0a8.003 8.003 0
                                 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Net Zero Initiative
                </div>
            </div>

        </div>
    </div>

    {{-- ═══════════════════════════════════════════
         RIGHT PANEL — Form
    ════════════════════════════════════════════ --}}
    <div class="flex-1 flex flex-col justify-center overflow-y-auto bg-white">
        <div class="w-full max-w-[420px] mx-auto px-6 sm:px-8 py-12">
            @yield('content')
        </div>
    </div>

</div>

@stack('scripts')
</body>
</html>