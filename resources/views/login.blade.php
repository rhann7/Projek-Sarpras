<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <title>Login Sarpras</title>

        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    </head>
    <body class="flex items-center justify-center min-h-screen" style="background-image: url('{{ asset('image/tbpic.jpg') }}'); background-size: cover; background-position: center;">
        <div class="absolute inset-0 bg-black/50 z-0"></div>
        <div class="w-full max-w-sm bg-white rounded-lg shadow-md p-6 relative z-10 mx-auto">
            <div class="text-center">
                <img src="{{ asset('image/tb.jpg') }}" alt="Taruna Bhakti Logo" class="w-32 mx-auto" />
            </div>

            <h2 class="text-2xl font-bold text-center mb-6">SISFO SARPRAS</h2>

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-sm">
                    <strong class="font-semibold">Terjadi kesalahan:</strong>
                    @foreach($errors->all() as $err)
                        <p>{{ $err }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <input type="email" name="email" placeholder="Email"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400 focus:outline-none"
                        required/>
                </div>

                <div>
                    <input type="password" name="password" placeholder="Kata Sandi"
                        class="w-full px-3 py-2 mb-4 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400 focus:outline-none"
                        required />
                </div>

                <div>
                    <button type="submit"
                        class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 rounded-md cursor-pointer">
                        Login
                    </button>
                </div>
            </form>
        </div>
    </body>
</html>