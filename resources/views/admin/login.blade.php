<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - TopUp Store</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-purple-600 to-blue-600 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full mx-4">
        <div class="bg-white rounded-lg shadow-2xl p-8">
            <div class="text-center mb-8">
                <i class="fas fa-shield-alt text-6xl text-purple-600 mb-4"></i>
                <h1 class="text-3xl font-bold text-gray-800">Admin Login</h1>
                <p class="text-gray-600">TopUp Store</p>
            </div>

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('admin.login.post') }}" method="POST">
                @csrf
                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-envelope"></i> Email
                    </label>
                    <input type="email" name="email" required class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600" placeholder="admin@example.com" value="{{ old('email') }}">
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-lock"></i> Password
                    </label>
                    <input type="password" name="password" required class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600" placeholder="••••••••">
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-blue-600 text-white py-3 rounded-lg font-semibold hover:from-purple-700 hover:to-blue-700 transition">
                    <i class="fas fa-sign-in-alt"></i> Login
                </button>
            </form>

            <div class="text-center mt-6">
                <a href="{{ route('home') }}" class="text-purple-600 hover:text-purple-800">
                    <i class="fas fa-home"></i> Kembali ke Home
                </a>
            </div>
        </div>
    </div>
</body>
</html>
