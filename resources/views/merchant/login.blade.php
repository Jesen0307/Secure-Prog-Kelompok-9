<!DOCTYPE html>
<html>
<head>
  <title>Merchant Login</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

  <div class="bg-white shadow-md rounded-lg p-8 w-full max-w-md">
    <h2 class="text-2xl font-bold text-center mb-6">Merchant Login</h2>

    <form method="POST" action="{{ route('merchant.login.submit') }}">
      @csrf
      <div class="mb-4">
        <label>Email</label>
        <input type="email" name="email" required class="w-full border p-2 rounded">
      </div>
      <div class="mb-4">
        <label>Password</label>
        <input type="password" name="password" required class="w-full border p-2 rounded">
      </div>
      <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        Login
      </button>
    </form>

    <!-- Register & Forgot Password Links -->
    <div class="mt-4 flex justify-between text-sm">
      <a href="{{ route('merchant.register') }}" class="text-blue-600 hover:underline">
        Register as Merchant
      </a>
      <a href="{{ route('merchant.password.request') }}" class="text-blue-600 hover:underline">
        Forgot Password?
      </a>
    </div>
  </div>

</body>
</html>
