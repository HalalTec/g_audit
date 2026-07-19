<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — G&amp;G Transaction Sentinel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: { extend: { colors: { brand: { 600:'#16a34a', 700:'#15803d', 800:'#166534' } } } }
        }
    </script>
</head>
<body class="bg-gradient-to-br from-brand-800 via-brand-700 to-green-600 min-h-screen flex items-center justify-center px-4">

<div class="w-full max-w-md">

    <!-- Card -->
    <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">

        <!-- Card Header -->
        <div class="bg-brand-800 px-8 pt-8 pb-6 text-center">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-green-600 mb-4">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
            </div>
            <h1 class="text-xl font-bold text-white">G&amp;G Transaction Sentinel</h1>
            <p class="text-green-300 text-sm mt-1">Snacks &amp; Soft Drinks — Enterprise</p>
        </div>

        <!-- Form -->
        <div class="px-8 py-7">
            <h2 class="text-gray-700 font-semibold text-base mb-5">Sign in to your account</h2>

            <?php if (!empty($flash['error'])): ?>
            <div class="mb-4 flex items-start gap-2 bg-red-50 border border-red-200 text-red-700 rounded-lg px-4 py-3 text-sm">
                <svg class="w-4 h-4 mt-0.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <?= htmlspecialchars($flash['error']) ?>
            </div>
            <?php endif; ?>

            <form method="post" action="<?= BASE_URL ?>/auth" novalidate>
                <input type="hidden" name="csrf_token" value="<?= Auth::csrfToken() ?>">

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-600 mb-1.5" for="username">Username</label>
                    <input
                        id="username"
                        type="text"
                        name="username"
                        required
                        autocomplete="username"
                        value="<?= htmlspecialchars($_POST['username'] ?? '') ?>"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-600 focus:border-transparent transition"
                        placeholder="Enter your username"
                    >
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-600 mb-1.5" for="password">Password</label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-600 focus:border-transparent transition"
                        placeholder="Enter your password"
                    >
                </div>

                <button type="submit"
                        class="w-full bg-brand-700 hover:bg-brand-800 text-white font-semibold py-2.5 rounded-lg transition text-sm">
                    Sign In
                </button>
            </form>
        </div>
    </div>

    <p class="text-center text-green-200 text-xs mt-5 opacity-70">
        G&amp;G Enterprise &copy; <?= date('Y') ?> &mdash; Internal Use Only
    </p>
</div>

</body>
</html>
