<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'G&G Transaction Sentinel') ?></title>
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
                            500: '#22c55e',
                            600: '#16a34a',
                            700: '#15803d',
                            800: '#166534',
                            900: '#14532d',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 min-h-screen font-sans antialiased">

<!-- Top Navigation -->
<nav class="bg-brand-800 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            <!-- Logo + Brand -->
            <div class="flex items-center gap-3">
                <div class="bg-brand-600 rounded-lg p-1.5 flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <div class="leading-tight">
                    <div class="text-white font-bold text-base">G&amp;G Transaction Sentinel</div>
                    <div class="text-brand-300 text-xs">Snacks &amp; Soft Drinks — Anomaly Detection</div>
                </div>
            </div>

            <!-- User info + logout -->
            <?php if (Auth::check()): $u = Auth::user(); ?>
            <div class="flex items-center gap-4">
                <div class="text-right hidden sm:block">
                    <div class="text-sm text-white font-medium"><?= htmlspecialchars($u['full_name']) ?></div>
                    <div class="text-xs text-brand-300 capitalize"><?= htmlspecialchars($u['role']) ?> Account</div>
                </div>
                <span class="w-8 h-8 rounded-full bg-brand-600 flex items-center justify-center text-white font-bold text-sm">
                    <?= strtoupper(substr($u['full_name'], 0, 1)) ?>
                </span>
                <form method="post" action="<?= BASE_URL ?>/logout">
                    <button type="submit"
                            class="text-xs text-brand-200 hover:text-white border border-brand-600 hover:border-brand-400 px-3 py-1.5 rounded-lg transition">
                        Logout
                    </button>
                </form>
            </div>
            <?php endif; ?>
        </div>
    </div>
</nav>

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
