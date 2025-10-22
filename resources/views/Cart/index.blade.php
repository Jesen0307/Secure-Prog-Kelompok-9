<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Your Cart</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body class="bg-gray-900 text-gray-100">

<!-- Navbar -->
<nav class="bg-gray-800 shadow-lg p-4 flex justify-between items-center">
    <h1 class="text-2xl font-bold text-blue-400">Your Cart</h1>

    <div class="flex gap-3 items-center">
        <!-- Back to Dashboard -->
        <a href="{{ route('dashboard.home') }}" 
           class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg text-white font-medium transition">
           ← Back
        </a>

        <!-- Login as Merchant -->
        <a href="{{ route('merchant.login') }}"
           class="px-4 py-2 bg-yellow-500 hover:bg-yellow-400 rounded-lg text-white font-medium transition">
          Login as Merchant
        </a>

        <!-- Cart Icon Dropdown -->
        <div class="relative" x-data="{ open: false }" @mouseleave="open = false">
            <button @click="open = !open" class="relative px-4 py-2 bg-green-500 hover:bg-green-400 rounded-lg text-white font-medium transition flex items-center gap-2">
                🛒 Cart ({{ auth()->user()->cart?->items->count() ?? 0 }})
            </button>

            <div x-show="open" class="absolute right-0 mt-2 w-80 bg-gray-700 text-white rounded-lg shadow-lg z-50 p-4"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform scale-95"
                 x-transition:enter-end="opacity-100 transform scale-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 transform scale-100"
                 x-transition:leave-end="opacity-0 transform scale-95">

                @if(auth()->user()->cart && auth()->user()->cart->items->count())
                    <ul class="divide-y divide-gray-600 max-h-64 overflow-y-auto">
                        @foreach(auth()->user()->cart->items as $item)
                        <li class="py-2 flex justify-between items-center">
                            <div class="flex items-center gap-2">
                                @if($item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}" class="w-10 h-10 object-cover rounded">
                                @endif
                                <span>{{ e($item->product->name) }}</span>
                            </div>
                            <span>${{ number_format($item->price * $item->quantity, 2) }}</span>
                        </li>
                        @endforeach
                    </ul>
                    <div class="mt-3 text-right">
                        <p class="font-bold mb-2">Total: ${{ number_format(auth()->user()->cart->items->sum(fn($i) => $i->price * $i->quantity), 2) }}</p>
                        <a href="{{ route('cart.index') }}"
                           class="block bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded-lg transition">
                            Checkout
                        </a>
                    </div>
                @else
                    <p class="text-gray-300 text-center">Your cart is empty.</p>
                @endif
            </div>
        </div>

        <!-- Logout -->
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
              class="px-4 py-2 bg-red-600 hover:bg-red-500 rounded-lg text-white font-medium transition">
              Logout
            </button>
        </form>
    </div>
</nav>

<!-- Cart Content -->
<section class="max-w-5xl mx-auto mt-10 bg-gray-800 p-6 rounded-lg shadow-lg">
    @if($cart && $cart->items->count() > 0)
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="border-b border-gray-700 text-blue-300">
            <th class="py-3">Product</th>
            <th class="py-3">Price</th>
            <th class="py-3">Quantity</th>
            <th class="py-3">Subtotal</th>
            <th class="py-3 text-center">Action</th>
          </tr>
        </thead>
        <tbody>
          @php $total = 0; @endphp
          @foreach($cart->items as $item)
            @php $subtotal = $item->price * $item->quantity; $total += $subtotal; @endphp
            <tr class="border-b border-gray-700">
              <td class="py-3">
                {{ e($item->product->name) }}
              </td>
              <td class="py-3">${{ number_format($item->price, 2) }}</td>
              <td class="py-3">
                <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center gap-2">
                  @csrf
                  <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" 
                         class="w-16 text-center text-gray-900 rounded p-1">
                  <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white px-3 py-1 rounded">
                    Update
                  </button>
                </form>
              </td>
              <td class="py-3 text-green-400">${{ number_format($subtotal, 2) }}</td>
              <td class="py-3 text-center">
                <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="bg-red-600 hover:bg-red-500 text-white px-3 py-1 rounded">
                    Remove
                  </button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>

      <div class="flex justify-end mt-6 text-xl font-semibold text-green-400">
        Total: ${{ number_format($total, 2) }}
      </div>

      <div class="flex justify-end mt-4">
        <button class="bg-blue-600 hover:bg-blue-500 text-white px-6 py-2 rounded-lg transition">
          Proceed to Checkout
        </button>
      </div>

    @else
      <p class="text-center text-gray-400 text-lg">Your cart is empty 🛒</p>
    @endif
</section>

<!-- Footer -->
<footer class="text-center text-gray-400 py-6 mt-10 border-t border-gray-800">
    &copy; {{ date('Y') }} Shop. All rights reserved.
</footer>

</body>
</html>
