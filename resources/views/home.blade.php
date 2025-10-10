<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>E-Commerce Home</title>
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-gray-100"
      x-data='{
          showAuth: {{ session("showAuth") ? "true" : "false" }},
          authMode: "{{ session("authMode") ?? "login" }}"
      }'>

  <!-- Navbar -->
  <nav class="bg-gray-800 shadow-lg p-4 flex justify-between items-center">
    <h1 class="text-2xl font-bold text-blue-400">Shop</h1>
    <button @click="showAuth = true; authMode = 'login'"
      class="px-4 py-2 bg-blue-600 hover:bg-blue-500 rounded-lg text-white font-medium transition">
      Login
    </button>
  </nav>

  <!-- Hero Section -->
  <section class="bg-gradient-to-r from-gray-900 to-gray-800 text-center py-20">
    <h2 class="text-4xl md:text-5xl font-extrabold text-blue-400">Welcome to Shop</h2>
    <p class="mt-4 text-lg text-gray-300">Find the best products at unbeatable prices</p>
    <button @click="showAuth = true; authMode = 'login'"
      class="mt-6 inline-block bg-blue-600 hover:bg-blue-500 text-white px-8 py-3 rounded-lg shadow-lg transition">
      Shop Now
    </button>
  </section>

  <!-- Product Listing -->
  <section id="products" class="p-8">
    <h3 class="text-2xl font-semibold mb-6 text-blue-300">Featured Products</h3>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
      @foreach($products as $product)
        <div class="bg-gray-800 p-5 rounded-xl shadow-lg hover:shadow-xl transition">
        <img src="{{ $product['image'] ? asset('storage/' . $product['image']) : asset('images/default-product.jpg') }}" 
            alt="{{ $product['name'] }}" 
            class="h-48 w-full object-cover rounded-lg">

          <h4 class="mt-4 text-lg font-bold text-white">{{ $product['name'] }}</h4>
          <p class="text-gray-400">${{ number_format($product['price'], 2) }}</p>
        </div>
      @endforeach
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-gray-800 text-center p-6 mt-12">
    <p class="text-gray-400">&copy; {{ date('Y') }} Shop. All rights reserved.</p>
  </footer>

  <!-- Auth Modal (Login + Register + Forgot Password) -->
  <div x-show="showAuth" 
       class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
       x-transition>
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl flex overflow-hidden relative">

      <!-- Close Button -->
      <button @click="showAuth = false" class="absolute top-3 right-3 text-gray-600 hover:text-gray-900 text-xl">&times;</button>

      <!-- Left Side -->
      <div class="hidden md:flex flex-col justify-center items-center w-1/2 bg-gradient-to-r from-indigo-600 to-blue-500 text-white p-10">
        <template x-if="authMode === 'login'">
          <div>
            <h2 class="text-3xl font-bold mb-4">Welcome Back 👋</h2>
            <p class="text-lg text-center">Log in to access your account and explore our amazing products.</p>
            <img src="https://cdn-icons-png.flaticon.com/512/3081/3081559.png" alt="Login Illustration" class="w-64 mt-6">
          </div>
        </template>
        <template x-if="authMode === 'register'">
          <div>
            <h2 class="text-3xl font-bold mb-4">Join Us 🚀</h2>
            <p class="text-lg text-center">Create your account and start shopping with us today.</p>
            <img src="https://cdn-icons-png.flaticon.com/512/1162/1162499.png" alt="Register Illustration" class="w-64 mt-6">
          </div>
        </template>
        <template x-if="authMode === 'forgot'">
          <div>
            <h2 class="text-3xl font-bold mb-4">Forgot Password 🔑</h2>
            <p class="text-lg text-center">Enter your email and we’ll send you a reset link.</p>
            <img src="https://cdn-icons-png.flaticon.com/512/2910/2910768.png" alt="Forgot Illustration" class="w-64 mt-6">
          </div>
        </template>
      </div>

      <!-- Right Side -->
      <div class="w-full md:w-1/2 p-8">
        
        <!-- Login Form -->
        <div x-show="authMode === 'login'">
          <h2 class="text-2xl font-bold text-gray-800 text-center mb-6">Login to Shop</h2>

          <form action="/login" method="POST" class="space-y-5">
            @csrf

            <div>
              <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
              <input type="email" name="loginemail" id="email" value="{{ old('loginemail') }}" required
                     class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm 
                     focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm
                     bg-white text-gray-900 placeholder-gray-400">
              @error('loginemail')
                <span class="text-red-500 text-sm">{{ $message }}</span>
              @enderror
            </div>

            <div>
              <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
              <input type="password" name="loginpassword" id="password" required
                     class="mt-1 w-full px-4 py-2 border rounded-lg shadow-sm 
                     focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm 
                     text-gray-900 bg-white">
            </div>

            <!-- Forgot password link -->
            <div class="text-right">
              <button type="button" @click="authMode = 'forgot'" class="text-sm text-indigo-600 hover:underline">
                Forgot password?
              </button>
            </div>

            <div class="flex gap-3">
              <button type="submit" class="w-1/2 bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 transition">
                Login
              </button>
              <button type="button" @click="authMode = 'register'" 
                class="w-1/2 text-center bg-gray-200 text-gray-800 py-2 rounded-lg hover:bg-gray-300 transition">
                Register
              </button>
            </div>
          </form>
        </div>

        <!-- Register Form -->
        <div x-show="authMode === 'register'">
          <h2 class="text-2xl font-bold text-gray-800 text-center mb-6">Register to Shop</h2>

          <form action="/register" method="POST" class="space-y-5">
            @csrf
            <div>
              <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
              <input type="text" name="name" id="name" value="{{ old('name') }}" required
                     class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm 
                     focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm
                     bg-white text-gray-900 placeholder-gray-400">
              @error('name')
                <span class="text-red-500 text-sm">{{ $message }}</span>
              @enderror
            </div>

            <div>
              <label for="regemail" class="block text-sm font-medium text-gray-700">Email</label>
              <input type="email" name="email" id="regemail" value="{{ old('email') }}" required
                     class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm 
                     focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm
                     bg-white text-gray-900 placeholder-gray-400">
              @error('email')
                <span class="text-red-500 text-sm">{{ $message }}</span>
              @enderror
            </div>

            <div>
              <label for="regpassword" class="block text-sm font-medium text-gray-700">Password</label>
              <input type="password" name="password" id="regpassword" required
                     class="mt-1 w-full px-4 py-2 border rounded-lg shadow-sm 
                     focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm 
                     text-gray-900 bg-white">
              @error('password')
                <span class="text-red-500 text-sm">{{ $message }}</span>
              @enderror
            </div>

            <div>
              <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
              <input type="password" name="password_confirmation" id="password_confirmation" required
                     class="mt-1 w-full px-4 py-2 border rounded-lg shadow-sm 
                     focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm 
                     text-gray-900 bg-white">
            </div>

            <div>
              <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 transition">
                Register
              </button>
            </div>
          </form>
        </div>

        <!-- Forgot Password Form -->
        <div x-show="authMode === 'forgot'">
          <h2 class="text-2xl font-bold text-gray-800 text-center mb-6">Forgot Password</h2>

          <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
            @csrf
            <div>
              <label for="forgot_email" class="block text-sm font-medium text-gray-700">Email</label>
              <input id="forgot_email" type="email" name="email" required autofocus
                     class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm
                     focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm
                     bg-white text-gray-900 placeholder-gray-400">
              @error('email')
                <span class="text-red-500 text-sm">{{ $message }}</span>
              @enderror
            </div>

            <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 transition">
              Send Reset Link
            </button>

            <div class="text-center mt-3">
              <button type="button" @click="authMode = 'login'" class="text-sm text-gray-600 hover:underline">
                Back to Login
              </button>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>

</body>
</html>
