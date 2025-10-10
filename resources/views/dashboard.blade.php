<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-gray-100">

  <!-- Navbar -->
  <nav class="bg-gray-800 shadow-lg p-4 flex justify-between items-center">
    <h1 class="text-2xl font-bold text-blue-400">Shop Dashboard</h1>
    <div class="flex gap-3 items-center">
      <!-- Login as Merchant -->
      <a href="{{ route('merchant.login') }}"
         class="px-4 py-2 bg-yellow-500 hover:bg-yellow-400 rounded-lg text-white font-medium transition">
        Login as Merchant
      </a>

      <!-- Logout -->
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit"
          class="px-4 py-2 bg-red-600 hover:bg-red-500 rounded-lg text-white font-medium transition">
          Logout
        </button>
      </form>
    </div>
  </nav>

  <!-- Welcome Section -->
  <section class="text-center py-12 bg-gradient-to-r from-gray-900 to-gray-800 shadow-lg">
    <h2 class="text-4xl font-extrabold text-blue-400">Welcome, {{ Auth::user()->name }} 🎉</h2>
    <p class="mt-3 text-lg text-gray-300">Explore our newest and most popular products below!</p>
  </section>

  <!-- Search Bar -->
  <section class="flex justify-center mt-8 mb-6">
    <form action="{{ route('search') }}" method="GET" class="w-full max-w-lg flex">
      <input type="text" name="query" placeholder="Search products..."
             class="w-full px-4 py-2 rounded-l-lg border border-gray-600 bg-gray-800 text-gray-100 
                    focus:ring-2 focus:ring-blue-500 focus:outline-none placeholder-gray-400">
      <button type="submit"
              class="bg-blue-600 hover:bg-blue-500 text-white px-6 rounded-r-lg transition">
        Search
      </button>
    </form>
  </section>

  <!-- Product Section -->
  <section class="p-8">
    <h3 class="text-2xl font-semibold mb-6 text-blue-300">Recommended Products</h3>

    @if($products->isEmpty())
      <p class="text-gray-400 text-center">No products available at the moment.</p>
    @else
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
        @foreach ($products as $product)
          <div class="bg-gray-800 p-5 rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-1 transform transition">
            @if($product->image)
              <img src="{{ asset('storage/' . $product->image) }}" 
                   alt="{{ $product->name }}" 
                   class="h-48 w-full object-cover rounded-lg">
            @else
              <div class="h-48 w-full bg-gray-700 flex items-center justify-center rounded-lg text-gray-400">
                No Image
              </div>
            @endif

            <h4 class="mt-4 text-lg font-bold text-white">{{ $product->name }}</h4>
            <p class="text-gray-400 mb-3">${{ number_format($product->price, 2) }}</p>

            <button class="w-full bg-blue-600 hover:bg-blue-500 text-white py-2 rounded-lg transition">
              Buy Now
            </button>
          </div>
        @endforeach
      </div>
    @endif
  </section>

  <!-- Footer -->
  <footer class="bg-gray-800 text-center p-6 mt-12">
    <p class="text-gray-400">&copy; {{ date('Y') }} Shop. All rights reserved.</p>
  </footer>

</body>
</html>
