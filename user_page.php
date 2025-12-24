<?php
require_once 'banking_logic.php'; // loads session, DB, and sets variables
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>User Banking</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tailwind CSS (same style as index.php) -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="min-h-screen bg-gradient-to-br from-indigo-500 to-purple-600 p-4">

    <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-2xl overflow-hidden">
        <!-- Header -->
        <header class="bg-gradient-to-r from-slate-900 to-blue-600 text-white px-6 py-5 flex flex-col gap-1 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold flex items-center gap-2">
                    <span>🏦</span>
                    <span>Banking Dashboard</span>
                </h1>
                <p class="text-sm text-blue-100 mt-1">
                    Welcome, <span class="font-semibold"><?= htmlspecialchars($userName); ?></span>
                </p>
            </div>
            <a href="login_page.php" class="text-xs underline text-blue-100 hover:text-white mt-3 md:mt-0">
                Back to Login
            </a>
        </header>

        <main class="p-6 space-y-6">
            <!-- Message -->
            <?php if (!empty($message)): ?>
                <div class="<?= $messageType === 'success'
                                ? 'bg-green-50 text-green-800 border-green-200'
                                : 'bg-red-50 text-red-800 border-red-200'
                            ?> border rounded-lg px-4 py-3 text-sm font-medium">
                    <?= htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <!-- Balance + Forms -->
            <div class="grid gap-6 md:grid-cols-3">
                <!-- Balance -->
                <section class="md:col-span-1 bg-slate-50 rounded-xl shadow p-5">
                    <h2 class="text-lg font-semibold text-slate-800 mb-3">Current Balance</h2>
                    <div class="bg-gradient-to-r from-emerald-500 to-emerald-600 text-white rounded-lg p-4 text-center space-y-2">
                        <div class="text-xs uppercase tracking-wide text-emerald-100">Balance</div>
                        <div class="text-3xl font-bold">
                            $<?= number_format($currentBalance, 2); ?>
                        </div>
                    </div>
                </section>

                <!-- Deposit Form -->
                <section class="bg-slate-50 rounded-xl shadow p-5">
                    <h2 class="text-lg font-semibold text-slate-800 mb-3">Deposit</h2>
                    <form method="POST" class="space-y-3">
                        <input type="hidden" name="action" value="deposit">
                        <div>
                            <label class="block text-sm text-slate-700 mb-1">Amount ($)</label>
                            <input
                                type="number"
                                name="amount"
                                step="0.01"
                                min="0.01"
                                required
                                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        </div>
                        <div>
                            <label class="block text-sm text-slate-700 mb-1">Description (optional)</label>
                            <input
                                type="text"
                                name="description"
                                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                                placeholder="e.g. Salary">
                        </div>
                        <button
                            type="submit"
                            class="w-full rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">
                            Deposit
                        </button>
                    </form>
                </section>

                <!-- Withdraw Form -->
                <section class="bg-slate-50 rounded-xl shadow p-5">
                    <h2 class="text-lg font-semibold text-slate-800 mb-3">Withdraw</h2>
                    <form method="POST" class="space-y-3">
                        <input type="hidden" name="action" value="withdraw">
                        <div>
                            <label class="block text-sm text-slate-700 mb-1">Amount ($)</label>
                            <input
                                type="number"
                                name="amount"
                                step="0.01"
                                min="0.01"
                                required
                                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-500">
                        </div>
                        <div>
                            <label class="block text-sm text-slate-700 mb-1">Description (optional)</label>
                            <input
                                type="text"
                                name="description"
                                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-500"
                                placeholder="e.g. ATM">
                        </div>
                        <button
                            type="submit"
                            class="w-full rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700">
                            Withdraw
                        </button>
                    </form>
                </section>
            </div>

            <!-- Transactions -->
            <section class="bg-slate-50 rounded-xl shadow p-5">
                <h2 class="text-lg font-semibold text-slate-800 mb-3">Recent Transactions</h2>
                <?php if (!empty($transactions)): ?>
                    <div class="space-y-2 max-h-72 overflow-y-auto pr-1">
                        <?php foreach ($transactions as $tx): ?>
                            <?php
                            $isDeposit = ($tx['type'] === 'deposit');
                            $sign      = $isDeposit ? '+' : '-';
                            $color     = $isDeposit ? 'text-emerald-600' : 'text-red-600';
                            ?>
                            <div class="flex items-center justify-between bg-white border border-slate-200 rounded-lg px-4 py-2 text-sm">
                                <div>
                                    <div class="font-semibold">
                                        <?= $isDeposit ? 'Deposit' : 'Withdrawal'; ?>
                                    </div>
                                    <?php if (!empty($tx['description'])): ?>
                                        <div class="text-xs text-slate-500">
                                            <?= htmlspecialchars($tx['description']); ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="text-[11px] text-slate-400">
                                        <?= date('M d, Y H:i:s', strtotime($tx['created_at'])); ?>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-base font-bold <?= $color; ?>">
                                        <?= $sign; ?>$<?= number_format((float)$tx['amount'], 2); ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-center text-sm text-slate-500 py-4">
                        No transactions yet. Try making a deposit or withdrawal.
                    </p>
                <?php endif; ?>
            </section>
        </main>
    </div>
</body>

</html>