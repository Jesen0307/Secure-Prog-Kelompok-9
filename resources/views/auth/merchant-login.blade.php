<!DOCTYPE html>
<html>
<head>
  <title>Merchant Login</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

  <div class="bg-white shadow-md rounded-lg p-8 w-full max-w-md">
    <h2 class="text-2xl font-bold text-center mb-6">Merchant Login</h2>

    {{-- Show global error (e.g., invalid credentials) --}}
    @if(session('error'))
      <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm">
        {{ session('error') }}
      </div>
    @endif

    {{-- Show validation errors --}}
    @if ($errors->any())
      <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm">
        <ul class="list-disc list-inside">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('merchant.login.submit') }}">
      @csrf
      <div class="mb-4">
        <label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}" required
               class="w-full border p-2 rounded @error('email') border-red-500 @enderror">

        @error('email')
          <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>
      <div class="mb-4">
        <label>Password</label>
        <input type="password" name="password" required
               class="w-full border p-2 rounded @error('password') border-red-500 @enderror">

        @error('password')
          <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>
      <button type="submit"
              class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
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
