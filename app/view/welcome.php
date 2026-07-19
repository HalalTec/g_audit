<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>G&amp;G Transaction Sentinel — Welcome</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50:  '#f0fdf4',
                            100: '#dcfce7',
                            200: '#bbf7d0',
                            300: '#86efac',
                            500: '#22c55e',
                            600: '#16a34a',
                            700: '#15803d',
                            800: '#166534',
                            900: '#14532d',
                        }
                    },
                    animation: {
                        'fade-up': 'fadeUp 0.6s ease-out forwards',
                        'fade-up-delay': 'fadeUp 0.6s ease-out 0.2s forwards',
                        'fade-up-delay2': 'fadeUp 0.6s ease-out 0.4s forwards',
                    },
                    keyframes: {
                        fadeUp: {
                            '0%':   { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .opacity-0-init { opacity: 0; }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased">

<!-- ── NAV ─────────────────────────────────────────────────────────── -->
<nav class="fixed top-0 inset-x-0 z-50 bg-brand-800/95 backdrop-blur-sm shadow-lg">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 h-14 flex items-center justify-between">
        <div class="flex items-center gap-2.5">
            <div class="bg-brand-600 rounded-lg p-1.5">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
            </div>
            <span class="text-white font-bold text-sm tracking-wide">G&amp;G Transaction Sentinel</span>
        </div>
        <a href="<?= BASE_URL ?>/login"
           class="text-sm font-semibold text-white bg-brand-600 hover:bg-brand-500 px-4 py-1.5 rounded-lg transition-colors">
            Sign In
        </a>
    </div>
</nav>

<!-- ── HERO ──────────────────────────────────────────────────────────── -->
<section class="relative min-h-screen flex items-center justify-center overflow-hidden bg-gradient-to-br from-brand-900 via-brand-800 to-green-700 pt-14">

    <!-- subtle grid overlay -->
    <div class="absolute inset-0 opacity-10"
         style="background-image: linear-gradient(rgba(255,255,255,.15) 1px, transparent 1px),
                                  linear-gradient(90deg, rgba(255,255,255,.15) 1px, transparent 1px);
                background-size: 40px 40px;">
    </div>

    <!-- glow blobs -->
    <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-green-500 rounded-full opacity-10 blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-1/4 right-1/4 w-72 h-72 bg-brand-400 rounded-full opacity-10 blur-3xl pointer-events-none"></div>

    <div class="relative z-10 text-center max-w-3xl mx-auto px-4">

        <!-- shield icon -->
        <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-white/10 border border-white/20 mb-8 backdrop-blur-sm">
            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
            </svg>
        </div>

        <div class="inline-flex items-center gap-2 bg-white/10 border border-white/20 text-green-200 text-xs font-medium px-3 py-1 rounded-full mb-5 backdrop-blur-sm">
            <span class="w-1.5 h-1.5 bg-green-400 rounded-full animate-pulse"></span>
            Internal Use Only — Enterprise Platform
        </div>

        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white leading-tight tracking-tight mb-4">
            G&amp;G Transaction<br>
            <span class="text-green-300">Sentinel</span>
        </h1>

        <p class="text-lg sm:text-xl text-green-100 mb-3 font-light max-w-xl mx-auto leading-relaxed">
            Near real-time anomaly detection for your Snacks &amp; Soft Drinks enterprise transactions.
        </p>
        <p class="text-sm text-green-300/80 mb-10 max-w-md mx-auto">
            Monitor sales, detect fraud, and review flagged transactions — all in one place.
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="<?= BASE_URL ?>/login"
               class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-white text-brand-800 font-bold px-8 py-3.5 rounded-xl shadow-lg hover:bg-green-50 transition-colors text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                </svg>
                Sign In to Dashboard
            </a>
            <a href="#features"
               class="w-full sm:w-auto inline-flex items-center justify-center gap-2 border border-white/30 text-white hover:bg-white/10 font-medium px-8 py-3.5 rounded-xl transition-colors text-sm backdrop-blur-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
                Explore Features
            </a>
        </div>
    </div>

    <!-- scroll indicator -->
    <div class="absolute bottom-8 inset-x-0 flex justify-center">
        <a href="#features" class="text-white/40 hover:text-white/70 transition-colors animate-bounce">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </a>
    </div>
</section>

<!-- ── STATS STRIP ────────────────────────────────────────────────────── -->
<div class="bg-brand-800 border-y border-brand-700">
    <div class="max-w-5xl mx-auto px-4 py-5 grid grid-cols-2 sm:grid-cols-4 divide-x divide-brand-700">
        <?php
        $stats = [
            ['value' => '2',     'label' => 'User Roles',        'sub' => 'Cashier & Manager'],
            ['value' => '2',     'label' => 'Detection Rules',   'sub' => 'Amount & Frequency'],
            ['value' => '30s',   'label' => 'Refresh Interval',  'sub' => 'Near Real-Time'],
            ['value' => '18+',   'label' => 'Products Tracked',  'sub' => 'Across 4 Categories'],
        ];
        foreach ($stats as $s):
        ?>
        <div class="text-center px-4 py-1">
            <div class="text-2xl font-extrabold text-white"><?= $s['value'] ?></div>
            <div class="text-xs font-semibold text-green-300 mt-0.5"><?= $s['label'] ?></div>
            <div class="text-xs text-brand-300/70 mt-0.5"><?= $s['sub'] ?></div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- ── FEATURES ───────────────────────────────────────────────────────── -->
<section id="features" class="bg-white py-20 px-4">
    <div class="max-w-5xl mx-auto">
        <div class="text-center mb-14">
            <span class="text-xs font-bold text-brand-600 uppercase tracking-widest">Core Capabilities</span>
            <h2 class="text-3xl font-extrabold text-gray-900 mt-2">Everything you need to stay in control</h2>
            <p class="text-gray-500 mt-3 max-w-lg mx-auto text-sm leading-relaxed">
                From recording a sale to reviewing a flagged anomaly — the Sentinel covers the full audit lifecycle.
            </p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">

            <?php
            $features = [
                [
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>',
                    'color' => 'bg-brand-50 text-brand-700',
                    'border'=> 'border-brand-100',
                    'title' => 'Real-Time Monitoring',
                    'desc'  => 'Manager dashboard auto-refreshes every 30 seconds. Stay on top of every transaction as your team records sales throughout the day.',
                ],
                [
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>',
                    'color' => 'bg-amber-50 text-amber-700',
                    'border'=> 'border-amber-100',
                    'title' => 'Smart Anomaly Detection',
                    'desc'  => 'Automatically flags transactions exceeding ₦50,000 and cashiers recording more than 10 transactions in 5 minutes — configurable thresholds.',
                ],
                [
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>',
                    'color' => 'bg-blue-50 text-blue-700',
                    'border'=> 'border-blue-100',
                    'title' => 'Role-Based Access',
                    'desc'  => 'Cashiers record sales and view their own history. Managers get full oversight — stats, filterable transaction tables, and one-click review.',
                ],
                [
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>',
                    'color' => 'bg-purple-50 text-purple-700',
                    'border'=> 'border-purple-100',
                    'title' => 'Full Audit Trail',
                    'desc'  => 'Every transaction is logged with cashier identity, product, quantity, price, and timestamp. Anomalies carry a reason and a review status.',
                ],
                [
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>',
                    'color' => 'bg-red-50 text-red-700',
                    'border'=> 'border-red-100',
                    'title' => 'Secure by Design',
                    'desc'  => 'CSRF protection, bcrypt password hashing, PDO prepared statements, output escaping, and session regeneration on login — security at every layer.',
                ],
                [
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>',
                    'color' => 'bg-teal-50 text-teal-700',
                    'border'=> 'border-teal-100',
                    'title' => 'Live KPI Cards',
                    'desc'  => 'At-a-glance metrics: total transactions, daily revenue, average transaction value, flagged count, and pending reviews — updated each page load.',
                ],
            ];
            foreach ($features as $f):
            ?>
            <div class="border <?= $f['border'] ?> rounded-2xl p-6 hover:shadow-md transition-shadow">
                <div class="w-10 h-10 rounded-xl <?= $f['color'] ?> flex items-center justify-center mb-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <?= $f['icon'] ?>
                    </svg>
                </div>
                <h3 class="font-bold text-gray-900 mb-2 text-sm"><?= $f['title'] ?></h3>
                <p class="text-gray-500 text-sm leading-relaxed"><?= $f['desc'] ?></p>
            </div>
            <?php endforeach; ?>

        </div>
    </div>
</section>

<!-- ── HOW IT WORKS ───────────────────────────────────────────────────── -->
<section class="bg-gray-50 border-t border-gray-100 py-20 px-4">
    <div class="max-w-4xl mx-auto">
        <div class="text-center mb-14">
            <span class="text-xs font-bold text-brand-600 uppercase tracking-widest">Workflow</span>
            <h2 class="text-3xl font-extrabold text-gray-900 mt-2">How It Works</h2>
        </div>

        <div class="relative">
            <!-- connector line (desktop) -->
            <div class="hidden md:block absolute top-8 left-1/6 right-1/6 h-0.5 bg-gradient-to-r from-brand-200 via-brand-400 to-brand-200" style="left:16.67%; right:16.67%;"></div>

            <div class="grid md:grid-cols-3 gap-8 relative z-10">

                <?php
                $steps = [
                    [
                        'num'   => '01',
                        'color' => 'bg-brand-600',
                        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>',
                        'title' => 'Cashier Records Sale',
                        'desc'  => 'Cashier selects a product, enters the quantity, and submits. The system calculates the total and previews any threshold warnings before submission.',
                    ],
                    [
                        'num'   => '02',
                        'color' => 'bg-amber-500',
                        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>',
                        'title' => 'Anomaly Engine Runs',
                        'desc'  => 'Every save triggers automatic checks: amount threshold (₦50k) and frequency limit (10 txns/5 min). Violations are flagged instantly with a reason.',
                    ],
                    [
                        'num'   => '03',
                        'color' => 'bg-blue-600',
                        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                        'title' => 'Manager Reviews Flags',
                        'desc'  => 'Manager sees flagged transactions highlighted in the dashboard, filters by status, reads the anomaly reason, and marks each one as reviewed.',
                    ],
                ];
                foreach ($steps as $step):
                ?>
                <div class="flex flex-col items-center text-center">
                    <div class="w-16 h-16 <?= $step['color'] ?> rounded-2xl flex items-center justify-center shadow-lg mb-5">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <?= $step['icon'] ?>
                        </svg>
                    </div>
                    <span class="text-xs font-bold text-gray-400 tracking-widest mb-1">STEP <?= $step['num'] ?></span>
                    <h3 class="font-bold text-gray-900 mb-2"><?= $step['title'] ?></h3>
                    <p class="text-gray-500 text-sm leading-relaxed max-w-xs"><?= $step['desc'] ?></p>
                </div>
                <?php endforeach; ?>

            </div>
        </div>
    </div>
</section>

<!-- ── CTA FOOTER ─────────────────────────────────────────────────────── -->
<section class="bg-gradient-to-br from-brand-800 to-brand-900 py-16 px-4">
    <div class="max-w-lg mx-auto text-center">
        <div class="inline-flex items-center justify-center w-12 h-12 bg-white/10 rounded-xl mb-6 border border-white/20">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
            </svg>
        </div>
        <h2 class="text-2xl font-extrabold text-white mb-3">Ready to get started?</h2>
        <p class="text-green-300 text-sm mb-8 leading-relaxed">
            Sign in with your assigned credentials to access your dashboard.<br>
            Contact your administrator if you don't have an account.
        </p>
        <a href="<?= BASE_URL ?>/login"
           class="inline-flex items-center gap-2 bg-white text-brand-800 font-bold px-10 py-3.5 rounded-xl shadow-lg hover:bg-green-50 transition-colors text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
            </svg>
            Sign In Now
        </a>
    </div>
</section>

<!-- ── FOOTER ─────────────────────────────────────────────────────────── -->
<footer class="bg-brand-900 py-5 px-4">
    <p class="text-center text-brand-300/50 text-xs">
        G&amp;G Enterprise &copy; <?= date('Y') ?> &mdash; Internal Use Only &mdash; G&amp;G Transaction Sentinel
    </p>
</footer>

</body>
</html>
