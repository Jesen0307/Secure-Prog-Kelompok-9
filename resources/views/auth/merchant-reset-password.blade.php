<!DOCTYPE html>
<html>
<head>
  <title>Reset Password</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
  <div class="bg-white shadow-md rounded-lg p-8 w-full max-w-md">
    <h2 class="text-2xl font-bold text-center mb-6">Reset Password</h2>

    <form method="POST" action="{{ route('merchant.password.update') }}">
      @csrf
      <input type="hidden" name="token" value="{{ $token }}">
      <input type="hidden" name="email" value="{{ $email }}">

      <div class="mb-4">
        <label>New Password</label>
        <input type="password" name="password" required class="w-full border p-2 rounded">
      </div>
      <div class="mb-4">
        <label>Confirm Password</label>
        <input type="password" name="password_confirmation" required class="w-full border p-2 rounded">
      </div>
      <button type="submit" class="w-full bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
        Reset Password
      </button>
    </form>
  </div>
</body>
</html>
