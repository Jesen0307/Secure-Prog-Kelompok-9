<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-800">

  <!-- Navbar -->
  <nav class="bg-blue-600 p-4 flex justify-between items-center shadow-md">
    <h1 class="text-2xl font-bold text-white">Shop Dashboard</h1>
    <div class="flex gap-3">
      <!-- Login as Merchant Button -->
      <a href="{{ route('merchant.login') }}"
         class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg">
        Login as Merchant
      </a>
      
      <!-- Logout -->
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">
          Logout
        </button>
      </form>
    </div>
  </nav>

  <!-- Welcome Section -->
  <section class="p-8">
    <h2 class="text-3xl font-bold text-gray-900">Welcome, {{ Auth::user()->name }} 🎉</h2>
    <p class="mt-2 text-lg text-gray-600">You are now logged in. Explore your dashboard below.</p>
    
    <!-- Search Bar -->
    <div class="mt-6 flex justify-center">
      <form action="{{ route('search') }}" method="GET" class="w-full max-w-md flex">
        <input type="text" name="query" placeholder="Search products..."
               class="w-full px-4 py-2 rounded-l-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none">
        <button type="submit" class="bg-blue-600 text-white px-6 rounded-r-lg hover:bg-blue-700 transition">
          Search
        </button>
      </form>
    </div>
  </section>

  <!-- Example Content -->
  <section class="p-8">
    <h3 class="text-2xl font-semibold mb-6 text-blue-600">Your Recommendations</h3>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
      <div class="bg-white shadow-md rounded-lg p-5 hover:shadow-lg transition">
        <h4 class="text-lg font-bold mb-2">Product 1</h4>
        <p class="text-gray-600">$20.00</p>
        <button class="mt-3 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
          Buy Now
        </button>
      </div>
      <div class="bg-white shadow-md rounded-lg p-5 hover:shadow-lg transition">
        <h4 class="text-lg font-bold mb-2">Product 2</h4>
        <p class="text-gray-600">$35.00</p>
        <button class="mt-3 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
          Buy Now
        </button>
      </div>
      <div class="bg-white shadow-md rounded-lg p-5 hover:shadow-lg transition">
        <h4 class="text-lg font-bold mb-2">Product 3</h4>
        <p class="text-gray-600">$50.00</p>
        <button class="mt-3 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
          Buy Now
        </button>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-gray-800 text-center p-6 mt-12">
    <p class="text-gray-400">&copy; {{ date('Y') }} Shop. All rights reserved.</p>
  </footer>

</body>
</html>
