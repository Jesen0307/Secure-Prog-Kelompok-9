<!DOCTYPE html>
<html>
<head>
  <title>Merchant Register</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
  <div class="bg-white shadow-md rounded-lg p-8 w-full max-w-md">
    <h2 class="text-2xl font-bold text-center mb-6">Merchant Register</h2>

    {{-- Show validation errors --}}
    @if ($errors->any())
      <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
        <ul class="list-disc pl-5">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('merchant.register.submit') }}">
      @csrf

      <div class="mb-4">
        <label>Name</label>
        <input type="text" name="name" value="{{ old('name') }}" 
               class="w-full border p-2 rounded @error('name') border-red-500 @enderror" required>
        @error('name')
          <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="mb-4">
        <label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}" 
               class="w-full border p-2 rounded @error('email') border-red-500 @enderror" required>
        @error('email')
          <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="mb-4">
        <label>Password</label>
        <input type="password" name="password" 
               class="w-full border p-2 rounded @error('password') border-red-500 @enderror" required>
        @error('password')
          <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="mb-4">
        <label>Confirm Password</label>
        <input type="password" name="password_confirmation" class="w-full border p-2 rounded" required>
      </div>

      <button type="submit" class="w-full bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
        Register
      </button>
    </form>
  </div>
</body>
</html>
