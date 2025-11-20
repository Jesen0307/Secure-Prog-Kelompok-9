@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h2 class="text-xl font-bold mb-4">Reset Password</h2>

    <form method="POST" action="{{ route('password.update') }}">
        @csrf


        <input type="hidden" name="token" value="{{ $token }}">

        <div class="mb-4">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required class="border p-2 w-full">
            @error('email') <p class="text-red-500">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label>Password Baru</label>
            <input type="password" name="password" required class="border p-2 w-full">
            @error('password') <p class="text-red-500">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label>Konfirmasi Password</label>
            <input type="password" name="password_confirmation" required class="border p-2 w-full">
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
            Reset Password
        </button>
    </form>
</div>
@endsection
