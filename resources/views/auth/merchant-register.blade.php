<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Merchant Register</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">

  <div class="flex flex-col md:flex-row min-h-screen">
    <!-- Left side: Image / Illustration -->
    <div class="hidden md:flex md:w-1/2 bg-blue-600 items-center justify-center p-10">
      <div class="text-center text-white space-y-4">
        <h1 class="text-4xl font-bold">Join as Merchant</h1>
        <p class="text-lg opacity-90">Grow your business with our eCommerce platform</p>
        <img src="https://cdn-icons-png.flaticon.com/512/2331/2331966.png" alt="Merchant Illustration" class="w-64 mx-auto">
      </div>
    </div>

    <!-- Right side: Register form -->
    <div class="flex-1 flex items-center justify-center bg-white shadow-lg">
      <div class="w-full max-w-md p-8">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">Merchant Register</h2>

        {{-- Error Messages --}}
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
            <label class="block font-medium text-gray-700">Name</label>
            <input type="text" name="name" value="{{ old('name') }}"
                   class="w-full border border-gray-300 p-2 rounded focus:ring-2 focus:ring-blue-500 focus:outline-none @error('name') border-red-500 @enderror"
                   required>
            @error('name')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div class="mb-4">
            <label class="block font-medium text-gray-700">Email</label>
            <input type="email" name="email" value="{{ old('email') }}"
                   class="w-full border border-gray-300 p-2 rounded focus:ring-2 focus:ring-blue-500 focus:outline-none @error('email') border-red-500 @enderror"
                   required>
            @error('email')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div class="mb-4">
            <label class="block font-medium text-gray-700">Password</label>
            <input type="password" name="password"
                   class="w-full border border-gray-300 p-2 rounded focus:ring-2 focus:ring-blue-500 focus:outline-none @error('password') border-red-500 @enderror"
                   required>
            @error('password')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div class="mb-4">
            <label class="block font-medium text-gray-700">Confirm Password</label>
            <input type="password" name="password_confirmation"
                   class="w-full border border-gray-300 p-2 rounded focus:ring-2 focus:ring-blue-500 focus:outline-none"
                   required>
          </div>

          <button type="submit"
                  class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
            Register
          </button>

          <p class="text-center text-sm text-gray-600 mt-4">
            Already have an account?
            <a href="{{ route('merchant.login') }}" class="text-blue-600 hover:underline">Login here</a>
          </p>
        </form>
      </div>
    </div>
  </div>

</body>
</html>
