<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Profile</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-gray-100">


<nav class="bg-gray-800 shadow-lg p-4 flex justify-between items-center">
    <h1 class="text-2xl font-bold text-blue-400">User Profile</h1>
    <div class="flex gap-3 items-center">
        <a href="{{ route('dashboard.home') }}"
           class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg text-white font-medium transition">
           🏠 Dashboard
        </a>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
              class="px-4 py-2 bg-red-600 hover:bg-red-500 rounded-lg text-white font-medium transition">
              Logout
            </button>
        </form>
    </div>
</nav>

<section class="text-center py-12 bg-gradient-to-r from-gray-900 to-gray-800 shadow-lg">
    <h2 class="text-4xl font-extrabold text-blue-400">
      {{ e(Auth::user()->name) }}’s Profile 👤
    </h2>
    <p class="mt-3 text-lg text-gray-300">Manage your account and personal information here.</p>
</section>


<section class="max-w-3xl mx-auto mt-10 bg-gray-800 rounded-xl shadow-xl p-8">

    @if (session('success'))
        <div class="bg-green-600 text-white p-3 rounded mb-4 text-center">
            {{ session('success') }}
        </div>
    @endif


    @if ($errors->any())
        <div class="bg-red-600 text-white p-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <div class="flex flex-col items-center">
        <div class="relative">
            <img src="{{ Auth::user()->profile_photo 
                ? asset('storage/' . Auth::user()->profile_photo) 
                : 'https://via.placeholder.com/150' }}" 
                alt="Profile Photo" 
                class="w-32 h-32 rounded-full object-cover border-4 border-blue-500 shadow-md">
        </div>

        <h3 class="text-2xl font-bold mt-4">{{ e(Auth::user()->name) }}</h3>
        <p class="text-gray-400">{{ e(Auth::user()->email) }}</p>

        <div class="mt-4 bg-purple-600 text-white px-4 py-2 rounded-lg font-semibold shadow">
            💰 Wallet Balance: ${{ number_format(Auth::user()->wallet_balance, 2) }}
        </div>
    </div>


    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="mt-8 space-y-5">
        @csrf
        @method('POST')

        <div>
            <label class="block text-gray-300 font-semibold mb-2">Full Name</label>
            <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}"
                   required minlength="3" maxlength="50"
                   class="w-full bg-gray-700 text-white p-3 rounded-lg border border-gray-600 
                   focus:border-blue-500 focus:ring focus:ring-blue-400 outline-none transition">
        </div>

        <div>
            <label class="block text-gray-300 font-semibold mb-2">Email</label>
            <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}"
                   required
                   class="w-full bg-gray-700 text-white p-3 rounded-lg border border-gray-600 
                   focus:border-blue-500 focus:ring focus:ring-blue-400 outline-none transition">
        </div>

        <div>
            <label class="block text-gray-300 font-semibold mb-2">Bio</label>
            <textarea name="bio" rows="3"
                      class="w-full bg-gray-700 text-white p-3 rounded-lg border border-gray-600 
                      focus:border-blue-500 focus:ring focus:ring-blue-400 outline-none transition">{{ old('bio', Auth::user()->bio) }}</textarea>
        </div>

        <div>
            <label class="block text-gray-300 font-semibold mb-2">Profile Photo</label>
            <input type="file" name="profile_photo" accept=".jpg,.jpeg,.png,.webp"
                   class="w-full bg-gray-700 text-gray-200 rounded-lg border border-gray-600 p-2">
            <p class="text-sm text-gray-400 mt-1">Allowed formats: JPG, JPEG, PNG, WEBP (Max 2MB)</p>
        </div>

        <div class="flex justify-center mt-6">
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-500 text-white px-6 py-2 rounded-lg font-semibold transition">
                💾 Save Changes
            </button>
        </div>
    </form>
</section>


<footer class="bg-gray-800 text-center p-6 mt-12">
    <p class="text-gray-400">&copy; {{ date('Y') }} Shop. All rights reserved.</p>
</footer>

</body>
</html>
