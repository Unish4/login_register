<?php
require_once 'admin_logic.php'; // loads admin session, user list, and selected user details
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="min-h-screen bg-slate-100">

<nav class="bg-slate-900 text-white px-6 py-4 flex items-center justify-between">
    <div class="flex items-center gap-2">
        <span class="text-2xl">🏦</span>
        <div>
            <h1 class="text-xl font-bold">Admin Dashboard</h1>
            <p class="text-xs text-slate-300">Hamro Bank &mdash; Manage users</p>
        </div>
    </div>
    <div class="flex items-center gap-3 text-sm">
        <span class="px-3 py-1 rounded-full bg-slate-800 text-slate-100">
            Logged in as <strong><?= htmlspecialchars($adminName); ?></strong>
        </span>
        <a href="home.php" class="underline text-slate-200 hover:text-white">Logout</a>
    </div>
</nav>

<main class="max-w-6xl mx-auto p-6 grid gap-6 lg:grid-cols-[2fr,3fr]">
    <!-- Left: Users list -->
    <section class="bg-white rounded-xl shadow p-5 flex flex-col gap-4">
        <header class="flex items-center justify-between">
            <div>
                <h2 class="text-lg font-semibold text-slate-800">User Accounts</h2>
                <p class="text-xs text-slate-500">View and manage registered user accounts.</p>
            </div>
        </header>

        <?php if (!empty($message)): ?>
            <div class="text-sm border rounded-lg px-3 py-2 mt-1 <?= $messageType === 'success'
                ? 'bg-emerald-50 text-emerald-800 border-emerald-200'
                : 'bg-red-50 text-red-800 border-red-200' ?>">
                <?= htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <div class="overflow-x-auto border border-slate-200 rounded-lg">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="px-3 py-2 text-left">Name</th>
                        <th class="px-3 py-2 text-left">Email</th>
                        <th class="px-3 py-2 text-left">Role</th>
                        <th class="px-3 py-2 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (!empty($users)): ?>
                    <?php foreach ($users as $u): ?>
                        <tr class="border-t border-slate-100 hover:bg-slate-50">
                            <td class="px-3 py-2 align-middle">
                                <?= htmlspecialchars($u['Name']); ?>
                            </td>
                            <td class="px-3 py-2 align-middle text-slate-600">
                                <?= htmlspecialchars($u['Email']); ?>
                            </td>
                            <td class="px-3 py-2 align-middle">
                                <?php if ($u['Role'] === 'admin'): ?>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-purple-100 text-purple-700 border border-purple-200">
                                        Admin
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                                        User
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-3 py-2 align-middle text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="admin_page.php?user_id=<?= $u['id']; ?>"
                                       class="px-2.5 py-1 text-xs rounded-lg bg-blue-600 text-white hover:bg-blue-700">
                                        View
                                    </a>
                                    <?php if ($u['Role'] !== 'admin'): ?>
                                        <form method="POST" class="inline"
                                              onsubmit="return confirm('Are you sure you want to delete this user?');">
                                            <input type="hidden" name="delete_user_id" value="<?= $u['id']; ?>">
                                            <button type="submit"
                                                    class="px-2.5 py-1 text-xs rounded-lg bg-red-600 text-white hover:bg-red-700">
                                                Delete
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="px-3 py-4 text-center text-slate-500 text-sm">
                            No users found.
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>

    <!-- Right: Selected user details -->
    <section class="bg-white rounded-xl shadow p-5 flex flex-col gap-4 min-h-[260px]">
        <header>
            <h2 class="text-lg font-semibold text-slate-800">User Details</h2>
            <p class="text-xs text-slate-500">Select a user from the list to see balance and recent transactions.</p>
        </header>

        <?php if ($selectedUser): ?>
            <div class="border border-slate-200 rounded-lg p-4 space-y-2 bg-slate-50">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-slate-800">
                            <?= htmlspecialchars($selectedUser['Name']); ?>
                        </p>
                        <p class="text-xs text-slate-500">
                            <?= htmlspecialchars($selectedUser['Email']); ?>
                        </p>
                    </div>
                    <div>
                        <?php if ($selectedUser['Role'] === 'admin'): ?>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-purple-100 text-purple-700 border border-purple-200">
                                Admin
                            </span>
                        <?php else: ?>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                                User
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="mt-3">
                    <p class="text-xs text-slate-500 uppercase tracking-wide">Current Balance</p>
                    <p class="text-2xl font-bold text-emerald-600">
                        $<?= number_format($selectedUserBalance, 2); ?>
                    </p>
                </div>
            </div>

            <div class="mt-4">
                <h3 class="text-sm font-semibold text-slate-700 mb-2">Recent Transactions</h3>
                <?php if (!empty($selectedUserTransactions)): ?>
                    <div class="space-y-2 max-h-64 overflow-y-auto pr-1">
                        <?php foreach ($selectedUserTransactions as $tx): ?>
                            <?php
                                $isDeposit = ($tx['type'] === 'deposit');
                                $sign      = $isDeposit ? '+' : '-';
                                $color     = $isDeposit ? 'text-emerald-600' : 'text-red-600';
                            ?>
                            <div class="flex items-center justify-between border border-slate-200 rounded-lg px-3 py-2 text-xs bg-white">
                                <div>
                                    <div class="font-semibold">
                                        <?= $isDeposit ? 'Deposit' : 'Withdrawal'; ?>
                                    </div>
                                    <?php if (!empty($tx['description'])): ?>
                                        <div class="text-[11px] text-slate-500">
                                            <?= htmlspecialchars($tx['description']); ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="text-[11px] text-slate-400">
                                        <?= date('M d, Y H:i:s', strtotime($tx['created_at'])); ?>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="font-bold <?= $color; ?>">
                                        <?= $sign; ?>$<?= number_format((float)$tx['amount'], 2); ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-xs text-slate-500 mt-1">No transactions found for this user.</p>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <p class="text-sm text-slate-500 mt-2">
                No user selected. Click the <span class="font-semibold">View</span> button for a user in the list.
            </p>
        <?php endif; ?>
    </section>
</main>

</body>
</html>
