<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Merchant Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <script>
    // Modal toggle for Add Product
    function toggleModal(show) {
      document.getElementById('addProductModal').classList.toggle('hidden', !show);
    }
  </script>
</head>

<body class="bg-gray-900 text-gray-100 min-h-screen">

  <!-- NAVBAR -->
  <nav class="bg-gray-800 p-4 flex justify-between items-center shadow-md">
    <h1 class="text-2xl font-bold text-green-400">Merchant Dashboard</h1>
    <div class="flex space-x-3 items-center">
      <button onclick="toggleModal(true)" class="bg-green-500 text-white px-3 py-2 rounded-lg font-semibold hover:bg-green-600 transition">
        + Add Product
      </button>
      <form method="POST" action="{{ route('merchant.logout') }}">
        @csrf
        <button type="submit" class="bg-red-500 px-3 py-2 rounded-lg text-white hover:bg-red-600 transition">
          Logout
        </button>
      </form>
    </div>
  </nav>

  <!-- MAIN CONTENT -->
  <div class="p-8 max-w-6xl mx-auto">
    <h2 class="text-2xl font-bold mb-2">Welcome, <span class="text-green-400">{{ $merchant->name }}</span></h2>
    <p class="text-gray-400 mb-6">Manage your products and view your sales performance.</p>

    <!-- SUCCESS MESSAGE -->
    @if (session('success'))
      <div class="bg-green-900 text-green-200 border border-green-700 p-3 mb-4 rounded">
        {{ session('success') }}
      </div>
    @endif

    <!-- PRODUCT LIST -->
    <div class="bg-gray-800 p-5 rounded-lg shadow-md">
      <h3 class="text-xl font-semibold text-green-400 mb-4">Your Products</h3>

      @if ($products->isEmpty())
        <p class="text-gray-400 text-center py-6">No products added yet.</p>
      @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
          @foreach ($products as $product)
            <div class="bg-gray-700 rounded-lg shadow hover:shadow-lg p-4 transition transform hover:-translate-y-1">
              @if ($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-40 object-cover rounded mb-3" alt="{{ $product->name }}">
              @else
                <div class="w-full h-40 bg-gray-600 flex items-center justify-center text-gray-300 mb-3 rounded">
                  No Image
                </div>
              @endif
              <h4 class="text-lg font-semibold text-white">{{ $product->name }}</h4>
              <p class="text-green-400 mb-1 font-medium">${{ number_format($product->price, 2) }}</p>
              @if ($product->description)
                <p class="text-gray-300 text-sm mt-1">{{ $product->description }}</p>
              @endif
            </div>
          @endforeach
        </div>
      @endif
    </div>
  </div>

  <!-- ADD PRODUCT MODAL -->
  <div id="addProductModal" class="hidden fixed inset-0 bg-black bg-opacity-60 flex justify-center items-center z-50">
    <div class="bg-gray-800 rounded-lg w-96 p-6 relative shadow-lg border border-gray-700">
      <h2 class="text-2xl font-bold mb-4 text-center text-green-400">Add New Product</h2>

      <form method="POST" action="{{ route('merchant.products.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
          <label class="block text-gray-300 font-medium">Product Name</label>
          <input type="text" name="name" class="w-full border border-gray-600 bg-gray-700 rounded px-3 py-2 text-white" required>
        </div>

        <div class="mb-3">
          <label class="block text-gray-300 font-medium">Price (USD)</label>
          <input type="number" name="price" step="0.01" class="w-full border border-gray-600 bg-gray-700 rounded px-3 py-2 text-white" required>
        </div>

        <div class="mb-3">
          <label class="block text-gray-300 font-medium">Description</label>
          <textarea name="description" class="w-full border border-gray-600 bg-gray-700 rounded px-3 py-2 text-white" rows="3"></textarea>
        </div>

        <div class="mb-3">
          <label class="block text-gray-300 font-medium">Product Image</label>
          <input type="file" name="image" accept="image/*" class="w-full border border-gray-600 bg-gray-700 rounded px-3 py-2 text-white">
        </div>

        <div class="flex justify-between mt-5">
          <button type="button" onclick="toggleModal(false)" class="bg-gray-600 px-4 py-2 rounded hover:bg-gray-500 text-white transition">
            Cancel
          </button>
          <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">
            Save Product
          </button>
        </div>
      </form>
    </div>
  </div>

</body>
</html>
