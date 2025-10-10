<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Merchant Login</title>
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-900 text-gray-100 flex items-center justify-center h-screen">

  <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl flex overflow-hidden relative">

    <!-- Left Side (illustration + intro) -->
    <div class="hidden md:flex flex-col justify-center items-center w-1/2 bg-gradient-to-r from-indigo-600 to-blue-500 text-white p-10">
      <h2 class="text-3xl font-bold mb-4">Merchant Portal 🏪</h2>
      <p class="text-lg text-center">Log in to manage your store, add products, and track your sales easily.</p>
      <img src="https://cdn-icons-png.flaticon.com/512/3081/3081559.png" 
           alt="Merchant Login Illustration" class="w-64 mt-6">
    </div>

    <!-- Right Side (login form) -->
    <div class="w-full md:w-1/2 p-8 bg-gray-50 text-gray-800">
      <h2 class="text-2xl font-bold text-center mb-6 text-gray-800">Merchant Login</h2>

      @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm">
          <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form method="POST" action="{{ route('merchant.login.submit') }}" class="space-y-5">
        @csrf

        <div>
          <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
          <input type="email" id="email" name="email" value="{{ old('email') }}" required
                 class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm 
                 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm
                 bg-white text-gray-900 placeholder-gray-400">
        </div>

        <div>
          <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
          <input type="password" id="password" name="password" required
                 class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm 
                 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm
                 bg-white text-gray-900">
        </div>

        <div class="text-right">
          <a href="{{ route('merchant.password.request') }}" class="text-sm text-indigo-600 hover:underline">
            Forgot password?
          </a>
        </div>

        <button type="submit"
                class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 transition">
          Login
        </button>

        <div class="text-center mt-3">
          <a href="{{ route('merchant.register') }}"
             class="text-sm text-gray-600 hover:underline">
            Don’t have an account? Register here
          </a>
        </div>
      </form>
    </div>
  </div>

</body>
</html>
