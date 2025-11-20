<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ e($product->name) }} - Product Detail</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body class="bg-gray-900 text-gray-100">

<nav class="bg-gray-800 p-4 shadow-md flex justify-between items-center">
    <h1 class="text-2xl font-bold text-blue-400">Product Detail</h1>
    
    <div class="flex items-center gap-3">


      <a href="{{ route('dashboard.home') }}" 
         class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg text-white font-medium transition">
         ← Back
      </a>

      <div class="relative" x-data="{ open: false }" @mouseleave="open = false">
          <button @click="open = !open" 
                  class="relative px-4 py-2 bg-green-500 hover:bg-green-400 rounded-lg text-white font-medium transition flex items-center gap-2">
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

    </div>
</nav>

<section class="max-w-4xl mx-auto mt-10 bg-gray-800 p-6 rounded-lg shadow-lg">
    <div class="flex flex-col md:flex-row gap-6">

      <div class="flex-shrink-0">
        @if($product->image)
          <img src="{{ asset('storage/' . e($product->image)) }}" 
               alt="{{ e($product->name) }}" 
               class="w-80 h-80 object-cover rounded-lg border border-gray-700">
        @else
          <div class="w-80 h-80 bg-gray-700 flex items-center justify-center text-gray-400 rounded-lg">
            No Image
          </div>
        @endif
      </div>


      <div class="flex-1">
        <h2 class="text-3xl font-bold text-blue-300 mb-2">{{ e($product->name) }}</h2>
        <p class="text-gray-400 mb-4">{{ e($product->description ?? 'No description available.') }}</p>

        <p class="text-green-400 text-xl font-semibold mb-2">
          ${{ number_format($product->price, 2) }}
        </p>

        <p class="text-gray-300 mb-1"><strong>Category:</strong> {{ e($product->category) }}</p>
        <p class="text-gray-300 mb-1"><strong>Stock:</strong> {{ $product->stock }}</p>
        <p class="text-gray-300 mb-4"><strong>Merchant:</strong> {{ e(optional($product->merchant)->name ?? 'Unknown') }}</p>


        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="w-full md:w-auto">
          @csrf
          <button type="submit" 
                  class="bg-blue-600 hover:bg-blue-500 text-white px-6 py-2 rounded-lg transition">
            Add to Cart
          </button>
        </form>

      </div>
    </div>
</section>


<footer class="text-center text-gray-400 py-6 mt-10 border-t border-gray-800">
    &copy; {{ date('Y') }} Shop. All rights reserved.
</footer>

</body>
</html>
