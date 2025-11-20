<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Merchant Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <script>
    function toggleModal(show) {
      document.getElementById('addProductModal').classList.toggle('hidden', !show);
    }
  </script>
</head>

<body class="bg-gray-900 text-gray-100 min-h-screen">


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


  <div class="p-8 max-w-6xl mx-auto">
    <h2 class="text-2xl font-bold mb-2">Welcome, <span class="text-green-400">{{ $merchant->name }}</span></h2>
    <p class="text-gray-400 mb-6">Manage your products and view your sales performance.</p>


    @if (session('success'))
      <div class="bg-green-900 text-green-200 border border-green-700 p-3 mb-4 rounded">
        {{ session('success') }}
      </div>
    @endif


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
              <p class="text-sm text-gray-300"><span class="font-semibold">Category:</span> {{ $product->category }}</p>
              <p class="text-sm text-gray-300 mb-2"><span class="font-semibold">Stock:</span> {{ $product->stock }}</p>

              @if ($product->description)
                <p class="text-gray-300 text-sm mt-1">{{ $product->description }}</p>
              @endif


              <form method="POST" action="{{ route('merchant.products.destroy', $product->id) }}" 
                    onsubmit="return confirm('Are you sure you want to delete this product?');" class="mt-3">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition text-sm">
                  Delete
                </button>
              </form>
            </div>
          @endforeach
        </div>
      @endif
    </div>


    <div class="bg-gray-800 p-5 rounded-lg shadow-md mt-10">
      <h3 class="text-xl font-semibold text-green-400 mb-4">Incoming Orders</h3>

      @if (isset($orders) && $orders->isNotEmpty())
        <div class="overflow-x-auto">
          <table class="min-w-full border border-gray-700 text-sm">
            <thead class="bg-gray-700 text-gray-200">
              <tr>
                <th class="px-4 py-2 text-left">Order ID</th>
                <th class="px-4 py-2 text-left">Buyer</th>
                <th class="px-4 py-2 text-left">Product</th>
                <th class="px-4 py-2 text-left">Total</th>
                <th class="px-4 py-2 text-left">Status</th>
                <th class="px-4 py-2 text-left">Date</th>
              </tr>
            </thead>
                      <tbody class="bg-gray-800 text-gray-100">
            @foreach ($orders as $order)
              <tr class="border-t border-gray-700 hover:bg-gray-700 transition">

                <td class="px-4 py-2">#{{ $order->id }}</td>


                <td class="px-4 py-2">
                  {{ $order->buyer ? $order->buyer->name : 'Unknown Buyer' }}
                </td>


                <td class="px-4 py-2">
                  @if ($order->items->isNotEmpty())
                    @foreach ($order->items as $item)
                      <div>
                        {{ $item->product->name }} (x{{ $item->quantity }})
                      </div>
                    @endforeach
                  @else
                    <span class="text-gray-400">No Products</span>
                  @endif
                </td>


                <td class="px-4 py-2 text-green-400">
                  ${{ number_format($order->total_amount, 2) }}
                </td>

                <td class="px-4 py-2 capitalize">
                  <span class="px-2 py-1 rounded text-xs 
                    @if($order->status === 'pending') bg-yellow-600 text-yellow-100 
                    @elseif($order->status === 'paid') bg-blue-600 text-blue-100
                    @elseif($order->status === 'shipped') bg-purple-600 text-purple-100
                    @else bg-green-600 text-green-100 @endif">
                    {{ $order->status }}
                  </span>
                </td>

                <td class="px-4 py-2">
                  {{ $order->created_at->format('d M Y H:i') }}
                </td>
              </tr>
            @endforeach
          </tbody>
          </table>
        </div>
      @else
        <p class="text-gray-400 text-center py-6">No orders received yet.</p>
      @endif
    </div>
  </div>

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
          <label class="block text-gray-300 font-medium">Category</label>
          <select name="category" class="w-full border border-gray-600 bg-gray-700 rounded px-3 py-2 text-white" required>
            <option value="" disabled selected>-- Select Category --</option>
            <option value="Electronic">Electronic</option>
            <option value="Food">Food</option>
            <option value="Fashion">Fashion</option>
            <option value="Beauty and Personal Care">Beauty and Personal Care</option>
            <option value="Furniture">Furniture</option>
            <option value="Pet Products">Pet Products</option>
          </select>
        </div>

        <div class="mb-3">
          <label class="block text-gray-300 font-medium">Stock Quantity</label>
          <input type="number" name="stock" min="0" value="0" class="w-full border border-gray-600 bg-gray-700 rounded px-3 py-2 text-white" required>
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
