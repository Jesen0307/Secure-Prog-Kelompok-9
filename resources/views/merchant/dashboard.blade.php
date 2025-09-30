<!DOCTYPE html>
<html>
<head>
  <title>Merchant Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

  <nav class="bg-green-600 p-4 flex justify-between items-center">
    <h1 class="text-xl font-bold text-white">Merchant Dashboard</h1>
    <form method="POST" action="{{ route('merchant.logout') }}">
      @csrf
      <button type="submit" class="bg-red-500 px-3 py-1 rounded text-white">Logout</button>
    </form>
  </nav>

  <div class="p-8">
    <h2 class="text-2xl font-bold mb-4">Welcome, {{ Auth::guard('merchant')->user()->name }}</h2>
    <p class="text-gray-600">Manage your products and orders here.</p>
  </div>

</body>
</html>
