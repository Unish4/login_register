<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bank Dashboard</title>
  
  <!-- <link href="/src/style.css" rel="stylesheet"> -->
  <!-- <link href="/src/style.css" rel="stylesheet"> For previewing using html -->
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

  <!-- Navbar -->
  <nav class="bg-blue-600 text-white px-6 py-4 flex justify-between items-center">
    <h1 class="text-2xl font-bold">Hamro Bank</h1>
    <div class="space-x-4">
      <a href="dashboard.html" class="hover:underline">Dashboard</a>
      <a href="profile.html" class="hover:underline">Profile</a>
      <a href="home.php" class="hover:underline">Logout</a>
    </div>
  </nav>

  <!-- Dashboard Layout -->
  <div class="flex">

    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow h-screen p-6">
      <h2 class="text-lg font-bold mb-4">Menu</h2>
      <ul class="space-y-3">
        <li><a href="#" class="block p-2 rounded hover:bg-gray-200">View Balance</a></li>
        <li><a href="#" class="block p-2 rounded hover:bg-gray-200">Deposit</a></li>
        <li><a href="#" class="block p-2 rounded hover:bg-gray-200">Withdraw</a></li>
        <li><a href="#" class="block p-2 rounded hover:bg-gray-200">Transfer</a></li>
        <li><a href="#" class="block p-2 rounded hover:bg-gray-200">Transaction History</a></li>
      </ul>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6">
      <h2 class="text-2xl font-bold mb-6">Welcome, Admin!</h2>

      <!-- Cards -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-lg shadow">
          <h3 class="text-lg font-semibold">Balance</h3>
          <p class="text-2xl font-bold text-green-600 mt-2">Npr 100,500</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
          <h3 class="text-lg font-semibold">Last Deposit</h3>
          <p class="text-2xl font-bold text-blue-600 mt-2">Npr 10,000</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
          <h3 class="text-lg font-semibold">Last Withdrawal</h3>
          <p class="text-2xl font-bold text-red-600 mt-2">Npr 250</p>
        </div>
      </div>

      <!-- Recent Transactions -->
      <div class="mt-8 bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-4">Recent Transactions</h3>
        <table class="w-full text-left border-collapse">
          <thead>
            <tr class="bg-gray-100">
              <th class="p-3">Date</th>
              <th class="p-3">Description</th>
              <th class="p-3">Amount</th>
              <th class="p-3">Type</th>
            </tr>
          </thead>
          <tbody>
            <tr class="border-b">
              <td class="p-3">2025-08-31</td>
              <td class="p-3">Deposit</td>
              <td class="p-3 text-green-600">+ $1,000</td>
              <td class="p-3">Credit</td>
            </tr>
            <tr class="border-b">
              <td class="p-3">2025-08-30</td>
              <td class="p-3">ATM Withdrawal</td>
              <td class="p-3 text-red-600">- $250</td>
              <td class="p-3">Debit</td>
            </tr>
            <tr>
              <td class="p-3">2025-08-28</td>
              <td class="p-3">Transfer to John</td>
              <td class="p-3 text-red-600">- $500</td>
              <td class="p-3">Debit</td>
            </tr>
          </tbody>
        </table>
      </div>
    </main>
  </div>
</body>
</html>
