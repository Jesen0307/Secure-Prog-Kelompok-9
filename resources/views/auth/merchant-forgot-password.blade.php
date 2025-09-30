<!DOCTYPE html>
<html>
<head>
  <title>Merchant Forgot Password</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
  <div class="bg-white shadow-md rounded-lg p-8 w-full max-w-md">
    <h2 class="text-2xl font-bold text-center mb-6">Forgot Password</h2>

    @if(session('status'))
      <div class="mb-4 text-green-600">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('merchant.password.email') }}">
      @csrf
      <div class="mb-4">
        <label>Email</label>
        <input type="email" name="email" required class="w-full border p-2 rounded">
      </div>
      <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        Send Reset Link
      </button>
    </form>
  </div>
</body>
</html>
