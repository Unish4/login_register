<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="./src/output.css" rel="stylesheet">
  
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-50 text-gray-800">

  <!-- Navbar -->
  <nav class="bg-white shadow-md">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
      <!-- Logo -->
      <div class="text-2xl font-bold text-blue-600 cursor-pointer">Hamro Bank</div>
      <!-- Links -->
      <div class="hidden md:flex space-x-6">
        <a href="#" class="hover:text-blue-600">Home</a>
        <a href="#" class="hover:text-blue-600">About</a>
        <a href="#" class="hover:text-blue-600">Services</a>
        <a href="#" class="hover:text-blue-600">Contact</a>
      </div>
      <!-- Button -->
      <a href="index.php"
        class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition">
        Login
      </a>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="bg-gray-100">
    <div class="max-w-7xl mx-auto px-6 py-20 flex flex-col md:flex-row items-center">
      <!-- Text -->
      <div class="flex-1 text-center md:text-left">
        <h1 class="text-4xl md:text-5xl font-extrabold leading-tight mb-4">
          Welcome to <span class="text-blue-600">Hamro Bank</span>
        </h1>
        <p class="text-lg text-gray-600 mb-6">
          Hamro Bank- Sabai ko lagi- Sadai ko lagi 
        </p>
        <a href="#"
          class="bg-blue-600 text-white px-6 py-3 rounded-lg shadow hover:bg-blue-700 transition">
          Explore Now
        </a>
      </div>
      <!-- Image Placeholder -->
      <div class="flex-1 mt-10 md:mt-0">
        <div class="w-full h-64 bg-blue-100 rounded-lg flex items-center justify-center">
          <span class="text-gray-400">[ Hero Image ]</span>
        </div>
      </div>
    </div>
  </section>

  <!-- Features Section -->
  <section class="py-16 bg-white">
    <div class="max-w-5xl mx-auto px-6">
      <h2 class="text-3xl font-bold text-center mb-12">Our Features</h2>
      
      <!-- Grid container for all cards -->
      <div class="grid md:grid-cols-3 gap-8">
        <!-- Card 1 -->
        <div class="bg-gray-50 p-6 rounded-xl shadow hover:shadow-lg transition">
          <h3 class="text-xl font-semibold mb-3">Secure Login</h3>
          <p class="text-gray-600">Two-factor authentication and role-based access for complete security.</p>
        </div>
  
        <!-- Card 2 -->
        <div class="bg-gray-50 p-6 rounded-xl shadow hover:shadow-lg transition">
          <h3 class="text-xl font-semibold mb-3">Account Management</h3>
          <p class="text-gray-600">View balances, manage accounts, and update your profile easily.</p>
        </div>
  
        <!-- Card 3 -->
        <div class="bg-gray-50 p-6 rounded-xl shadow hover:shadow-lg transition">
          <h3 class="text-xl font-semibold mb-3">Fund Transfers</h3>
          <p class="text-gray-600">Transfer money instantly between accounts and across banks.</p>
        </div>
  
        <!-- Card 4 -->
        <div class="bg-gray-50 p-6 rounded-xl shadow hover:shadow-lg transition">
          <h3 class="text-xl font-semibold mb-3">Bill Payments</h3>
          <p class="text-gray-600">Pay utility bills, recharge mobiles, and schedule recurring payments.</p>
        </div>
  
        <!-- Card 5 -->
        <div class="bg-gray-50 p-6 rounded-xl shadow hover:shadow-lg transition">
          <h3 class="text-xl font-semibold mb-3">Loan Services</h3>
          <p class="text-gray-600">Apply for loans online and track repayment progress anytime.</p>
        </div>
  
        <!-- Card 6 -->
        <div class="bg-gray-50 p-6 rounded-xl shadow hover:shadow-lg transition">
          <h3 class="text-xl font-semibold mb-3">Transaction History</h3>
          <p class="text-gray-600">Download statements and filter transactions with ease.</p>
        </div>
      </div>
    </div>
  </section>
  

  <!-- Footer -->
  <footer class="bg-gray-900 text-gray-400 py-6">
    <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row items-center justify-between">
      <p>&copy; 2025 MyProject. All rights reserved.</p>
      <div class="space-x-4 mt-4 md:mt-0">
        <a href="#" class="hover:text-white">Privacy</a>
        <a href="#" class="hover:text-white">Terms</a>
        <a href="#" class="hover:text-white">Contact</a>
      </div>
    </div>
  </footer>

</body>
</html>