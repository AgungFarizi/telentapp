<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Masuk') — Portal Resmi Magang PT. Tanjungenim Lestari</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        [x-cloak] { display: none !important; }

        /* Canvas partikel — di ATAS overlay, di BAWAH konten */
        #telent-particles {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            z-index: 5;
            pointer-events: none;
        }

        /* Fade + slide-up */
        .anim-fade {
            opacity: 0;
            transform: translateY(24px);
            transition: opacity 0.8s cubic-bezier(.22,1,.36,1), transform 0.8s cubic-bezier(.22,1,.36,1);
        }
        .anim-fade.show {
            opacity: 1;
            transform: translateY(0);
        }

        /* Typing cursor */
        .typing-cursor {
            display: inline-block;
            width: 3px;
            height: 1em;
            background: #4ade80;
            margin-left: 3px;
            vertical-align: text-bottom;
            border-radius: 2px;
            animation: blink-cursor 0.65s steps(1) infinite;
        }
        @keyframes blink-cursor {
            0%,100% { opacity: 1; }
            50%      { opacity: 0; }
        }

        /* Counter */
        .stat-num {
            font-size: 1.7rem;
            font-weight: 800;
            color: #4ade80;
            letter-spacing: -0.02em;
            line-height: 1;
        }
        .stat-label {
            font-size: 10px;
            color: rgba(255,255,255,0.5);
            margin-top: 3px;
        }

        /* Glow orbs — z-index 4 (di bawah canvas) */
        .glow-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(55px);
            pointer-events: none;
            z-index: 4;
        }
        .orb-a {
            width: 260px; height: 260px;
            background: rgba(74,222,128,0.18);
            top: 5%; left: 10%;
            animation: pulse-orb 4s ease-in-out infinite;
        }
        .orb-b {
            width: 180px; height: 180px;
            background: rgba(22,163,74,0.14);
            bottom: 20%; right: 5%;
            animation: pulse-orb 5s ease-in-out 1.5s infinite;
        }
        .orb-c {
            width: 120px; height: 120px;
            background: rgba(134,239,172,0.10);
            top: 40%; right: 20%;
            animation: pulse-orb 6s ease-in-out 0.8s infinite;
        }
        @keyframes pulse-orb {
            0%,100% { opacity: 0.5; transform: scale(1); }
            50%      { opacity: 1;   transform: scale(1.12); }
        }

        /* Shimmer pada garis badge */
        .badge-line {
            width: 28px; height: 2px;
            background: linear-gradient(90deg, #4ade80, #86efac, #4ade80);
            background-size: 200% 100%;
            animation: shimmer-line 2s linear infinite;
        }
        @keyframes shimmer-line {
            0%   { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }

        /* Float naik-turun pada cert badges */
        .cert-float {
            animation: float-badge 3s ease-in-out infinite;
        }
        .cert-float:nth-child(3) {
            animation-delay: 0.6s;
        }
        @keyframes float-badge {
            0%,100% { transform: translateY(0); }
            50%      { transform: translateY(-3px); }
        }

        /* Right panel fade */
        .right-anim {
            opacity: 0;
            transform: translateX(18px);
            transition: opacity 0.7s cubic-bezier(.22,1,.36,1), transform 0.7s cubic-bezier(.22,1,.36,1);
        }
        .right-anim.show {
            opacity: 1;
            transform: translateX(0);
        }
    </style>
</head>
<body class="h-full bg-white">

<div class="min-h-screen flex">

    {{-- ══════════════════════════════════════
         LEFT PANEL
    ══════════════════════════════════════ --}}
    <div class="hidden lg:block lg:w-[55%] relative overflow-hidden flex-shrink-0" id="left-panel">

        {{-- z-index 0: Background image --}}
        <img
            src="{{ asset('images/bck-telentapp.jpeg') }}"
            alt="TELENT Industrial Facility"
            class="absolute inset-0 w-full h-full object-cover object-center"
            style="z-index:0"
        >

        {{-- z-index 1-3: Green overlay --}}
        <div class="absolute inset-0" style="z-index:3; background: linear-gradient(to bottom,
            rgba(5,46,22,0.50) 0%,
            rgba(5,46,22,0.48) 40%,
            rgba(5,46,22,0.86) 100%);">
        </div>

        {{-- z-index 4: Glow orbs --}}
        <div class="glow-orb orb-a"></div>
        <div class="glow-orb orb-b"></div>
        <div class="glow-orb orb-c"></div>

        {{-- z-index 5: Particle canvas (DI ATAS overlay) --}}
        <canvas id="telent-particles"></canvas>

        {{-- z-index 10: Konten teks --}}
        <div class="relative h-full flex flex-col justify-between p-12 pb-80" style="z-index:10">

            <div></div>

            <div>
                {{-- Badge --}}
                <div class="flex items-center gap-3 mb-5 anim-fade" id="an-badge">
                    <div class="badge-line"></div>
                    <span class="text-emerald-300 text-xs font-bold tracking-widest uppercase">
                        Sustainability &amp; Efficiency
                    </span>
                </div>

                {{-- Headline typing --}}
                <h2 class="text-white font-extrabold leading-tight mb-4 anim-fade"
                    id="an-headline"
                    style="font-size: clamp(1.75rem, 2.8vw, 2.75rem); min-height: 5rem;">
                    <span id="typed-text"></span><span class="typing-cursor" id="typing-cursor"></span>
                </h2>

                {{-- Subtext --}}
                <p class="text-white/70 text-sm leading-relaxed mb-6 max-w-sm anim-fade" id="an-sub">
                    Platform terintegrasi TELENT untuk pengelolaan sumber daya
                    industri yang cerdas, efisien, dan ramah lingkungan.
                </p>

                {{-- Counters --}}
                <div class="flex items-start gap-8 mb-7 anim-fade" id="an-stats">
                    <div>
                        <div class="stat-num" id="cnt-mahasiswa">0</div>
                        <div class="stat-label">Mahasiswa Magang</div>
                    </div>
                    <div>
                        <div class="stat-num" id="cnt-proyek">0</div>
                        <div class="stat-label">Proyek Aktif</div>
                    </div>
                    <div>
                        <div class="stat-num" id="cnt-kepuasan">0%</div>
                        <div class="stat-label">Kepuasan Peserta</div>
                    </div>
                </div>

                {{-- Cert badges --}}
                <div class="flex items-center gap-5 anim-fade" id="an-certs">
                    <div class="flex items-center gap-2 text-white/80 text-sm font-medium cert-float">
                        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        ISO 14001 Certified
                    </div>
                    <div class="w-1 h-1 rounded-full bg-white/30"></div>
                    <div class="flex items-center gap-2 text-white/80 text-sm font-medium cert-float">
                        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Net Zero Initiative
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════
         RIGHT PANEL — Form
    ══════════════════════════════════════ --}}
    <div class="flex-1 flex flex-col justify-center overflow-y-auto bg-white">
        <div class="w-full max-w-[420px] mx-auto px-6 sm:px-8 py-12 right-anim" id="an-right">

            @yield('content')
        </div>
    </div>

</div>

@stack('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ══ 1. PARTICLE CANVAS ══
       Canvas di z-index 5 — di atas overlay (z-index 3), di bawah konten (z-index 10)
       Partikel pakai warna putih/hijau transparan agar terlihat di atas foto + overlay
    */
    const canvas = document.getElementById('telent-particles');
    const panel  = document.getElementById('left-panel');
    if (!canvas || !panel) return;
    const ctx = canvas.getContext('2d');
    let particles = [];
    let mouse = { x: -999, y: -999 };

    function resizeCanvas() {
        canvas.width  = panel.offsetWidth;
        canvas.height = panel.offsetHeight;
    }
    resizeCanvas();
    window.addEventListener('resize', () => { resizeCanvas(); initParticles(); });

    panel.addEventListener('mousemove', function(e) {
        const rect = panel.getBoundingClientRect();
        mouse.x = e.clientX - rect.left;
        mouse.y = e.clientY - rect.top;
    });
    panel.addEventListener('mouseleave', function() {
        mouse.x = -999; mouse.y = -999;
    });

    function rand(a, b) { return a + Math.random() * (b - a); }

    function initParticles() {
        particles = [];
        const count = Math.floor((canvas.width * canvas.height) / 9000);
        for (let i = 0; i < Math.max(count, 55); i++) {
            particles.push({
                x:     rand(0, canvas.width),
                y:     rand(0, canvas.height),
                r:     rand(0.8, 2.8),
                vx:    rand(-0.2, 0.2),
                vy:    rand(-0.35, -0.08),
                alpha: rand(0.35, 1.0),
                phase: rand(0, Math.PI * 2),
                color: Math.random() > 0.4 ? '255,255,255' : '134,239,172'
            });
        }
    }
    initParticles();

    function drawParticles() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        particles.forEach(p => {
            p.phase += 0.018;
            const twinkle = 0.5 + 0.5 * Math.sin(p.phase);
            const a = p.alpha * twinkle;

            /* Mouse repel effect */
            const dx = p.x - mouse.x;
            const dy = p.y - mouse.y;
            const dist = Math.sqrt(dx * dx + dy * dy);
            if (dist < 80) {
                const force = (80 - dist) / 80;
                p.x += (dx / dist) * force * 1.5;
                p.y += (dy / dist) * force * 1.5;
            }

            /* Draw particle */
            ctx.beginPath();
            ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
            ctx.fillStyle = `rgba(${p.color},${a})`;
            ctx.fill();

            /* Cross sparkle untuk partikel besar */
            if (p.r > 2.0 && twinkle > 0.8) {
                ctx.strokeStyle = `rgba(${p.color},${a * 0.5})`;
                ctx.lineWidth = 0.5;
                ctx.beginPath();
                ctx.moveTo(p.x - p.r * 2, p.y);
                ctx.lineTo(p.x + p.r * 2, p.y);
                ctx.moveTo(p.x, p.y - p.r * 2);
                ctx.lineTo(p.x, p.y + p.r * 2);
                ctx.stroke();
            }

            /* Move */
            p.x += p.vx;
            p.y += p.vy;
            if (p.y < -5)             p.y = canvas.height + 5;
            if (p.x < -5)             p.x = canvas.width  + 5;
            if (p.x > canvas.width+5) p.x = -5;
        });

        /* Connection lines antar partikel terdekat */
        for (let i = 0; i < particles.length; i++) {
            for (let j = i + 1; j < particles.length; j++) {
                const dx   = particles[i].x - particles[j].x;
                const dy   = particles[i].y - particles[j].y;
                const dist = Math.sqrt(dx * dx + dy * dy);
                if (dist < 70) {
                    ctx.beginPath();
                    ctx.moveTo(particles[i].x, particles[i].y);
                    ctx.lineTo(particles[j].x, particles[j].y);
                    ctx.strokeStyle = `rgba(255,255,255,${0.18 * (1 - dist / 70)})`;
                    ctx.lineWidth   = 0.6;
                    ctx.stroke();
                }
            }
        }

        requestAnimationFrame(drawParticles);
    }
    drawParticles();


    /* ══ 2. FADE + SLIDE UP ══ */
    [
        ['an-badge',    100],
        ['an-headline', 260],
        ['an-sub',      420],
        ['an-stats',    560],
        ['an-certs',    700],
        ['an-right',    150],
    ].forEach(([id, delay]) => {
        setTimeout(() => {
            const el = document.getElementById(id);
            if (el) el.classList.add('show');
        }, delay);
    });


    /* ══ 3. TYPING EFFECT (loop) ══ */
    const lines   = ['Membangun Masa Depan\nBerkelanjutan'];
    const typedEl = document.getElementById('typed-text');
    const cursor  = document.getElementById('typing-cursor');

    function typeLoop(lineIdx) {
        if (!typedEl) return;
        const text = lines[lineIdx % lines.length];
        let i = 0;
        typedEl.innerHTML = '';
        if (cursor) cursor.style.display = 'inline-block';

        const typeIv = setInterval(() => {
            if (i < text.length) {
                typedEl.innerHTML += text[i] === '\n' ? '<br>' : text[i];
                i++;
            } else {
                clearInterval(typeIv);
                /* pause 3 detik, lalu hapus dan ketik ulang */
                setTimeout(() => {
                    const eraseIv = setInterval(() => {
                        const html = typedEl.innerHTML;
                        if (html.length > 0) {
                            typedEl.innerHTML = html.endsWith('>') && html.includes('<br>')
                                ? html.slice(0, html.lastIndexOf('<br>'))
                                : html.slice(0, -1);
                        } else {
                            clearInterval(eraseIv);
                            setTimeout(() => typeLoop(lineIdx + 1), 400);
                        }
                    }, 30);
                }, 3000);
            }
        }, 60);
    }

    setTimeout(() => typeLoop(0), 400);


    /* ══ 4. COUNTER (dengan efek easing) ══ */
    function animateCounter(id, target, suffix, delay) {
        setTimeout(() => {
            const el = document.getElementById(id);
            if (!el) return;
            const duration = 1800;
            const start    = performance.now();
            function step(now) {
                const elapsed  = Math.min(now - start, duration);
                const progress = 1 - Math.pow(1 - elapsed / duration, 3); /* ease-out cubic */
                const value    = Math.round(progress * target);
                el.textContent = value + (suffix || '');
                if (elapsed < duration) requestAnimationFrame(step);
                else el.textContent = target + (suffix || '');
            }
            requestAnimationFrame(step);
        }, delay);
    }

    animateCounter('cnt-mahasiswa', 500, '+',  700);
    animateCounter('cnt-proyek',     48,  '',  850);
    animateCounter('cnt-kepuasan',   97,  '%', 1000);

});
</script>

</body>
</html>