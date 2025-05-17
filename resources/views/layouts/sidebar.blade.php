<div class="w-64 bg-gray-900 h-screen shadow-md fixed flex flex-col">

    <!-- Logo -->
    <div class="p-4 border-b border-gray-800 flex items-center gap-2">
        <img src="{{ asset('image/tb.jpg') }}" alt="TB Logo" class="w-14 h-14">
        <span class="text-white text-lg font-bold font-sans">SARPRAS TB</span>
    </div>
    
    <!-- Menu -->
    <div class="flex-1 overflow-y-auto">
        <div class="p-4 space-y-2 text-white">

            <!-- Dashboard -->
            <a 
                href="{{ route('dashboard') }}" 
                class="flex items-center gap-3 p-2  hover:bg-white hover:text-gray-900 rounded-md transition-all 
                {{ request()->routeIs('dashboard') ? 'bg-gray-800' : '' }}"
            >
                <span class="material-icons">dashboard</span>
                <span>Dashboard</span>
            </a>

            <!-- Pengguna -->
            <a 
                href="{{ route('users.index') }}"
                class="flex items-center gap-3 p-2  hover:bg-white hover:text-gray-900 rounded-md transition-all 
                {{ request()->routeIs('users.index') ? 'bg-gray-800' : '' }}"
            >
                <span class="material-icons">people</span>
                <span>Pengguna</span>
            </a>

            <!-- Barang -->
            <div x-data="{ open: {{ request()->routeIs('categories.*', 'items.*', 'unit-items.*', 'used.*') ? 'true' : 'false' }} }">
                <button @click="open = !open" class="w-full flex items-center justify-between gap-3 p-2  hover:bg-white hover:text-gray-900 rounded-md transition-all">
                    <div class="flex items-center gap-3">
                        <span class="material-icons">inventory</span>
                        <span>Barang</span>
                    </div>
                    <span class="material-icons" x-text="open ? 'expand_less' : 'expand_more'"></span>
                </button>
                
                <div x-show="open" x-collapse class="ml-8 mt-1 space-y-1">
                    <a 
                        href="{{ route('categories.index') }}"
                        class="flex items-center gap-3 p-2  hover:bg-white hover:text-gray-900 rounded-md transition-all 
                        {{ request()->routeIs('categories.index') ? 'bg-gray-800' : '' }}"
                    >
                        <span class="material-icons text-sm">category</span>
                        <span class="text-sm">Kategori Barang</span>
                    </a>
                    <a 
                        href="{{ route('items.index') }}"
                        class="flex items-center gap-3 p-2  hover:bg-white hover:text-gray-900 rounded-md transition-all 
                        {{ request()->routeIs('items.index') ? 'bg-gray-800' : '' }}"
                    >
                        <span class="material-icons text-sm">inventory_2</span>
                        <span class="text-sm">Induk Barang</span>
                    </a>
                    <a 
                        href="{{ route('unit-items.index') }}"
                        class="flex items-center gap-3 p-2  hover:bg-white hover:text-gray-900 rounded-md transition-all 
                        {{ request()->routeIs('unit-items.index') ? 'bg-gray-800' : '' }}"
                    >
                        <span class="material-icons text-sm">layers</span>
                        <span class="text-sm">Unit Barang</span>
                    </a>
                    <a 
                        href="#"
                        class="flex items-center gap-3 p-2  hover:bg-white hover:text-gray-900 rounded-md transition-all 
                        {{-- {{ request()->routeIs('used.index') ? 'bg-gray-800' : '' }}" --}} "
                    >
                        <span class="material-icons text-sm">assignment_turned_in</span>
                        <span class="text-sm">Barang Terpakai</span>
                    </a>
                </div>
            </div>

            <!-- Lokasi Barang -->
            <a 
                href="{{ route('locations.index') }}"
                class="flex items-center gap-3 p-2  hover:bg-white hover:text-gray-900 rounded-md transition-all 
                {{-- {{ request()->routeIs('dashboard') ? 'bg-gray-800' : '' }}" --}} "
            >
                <span class="material-icons">warehouse</span>
                <span>Lokasi</span>
            </a>

            <!-- Peminjaman -->
            <div x-data="{ open: false }">
                <button @click="open = !open" class="w-full flex items-center justify-between gap-3 p-2  hover:bg-white hover:text-gray-900 rounded-md transition-all 
                {{-- {{ request()->routeIs('dashboard') ? 'bg-gray-800' : '' }}" --}} "
            >
                    <div class="flex items-center gap-3">
                        <span class="material-icons">assignment</span>
                        <span>Peminjaman</span>
                    </div>
                    <span class="material-icons" x-text="open ? 'expand_less' : 'expand_more'"></span>
                </button>
                
                <div x-show="open" x-collapse class="ml-8 mt-1 space-y-1">
                    <a 
                        href="#"
                        class="flex items-center gap-3 p-2  hover:bg-white hover:text-gray-900 rounded-md transition-all 
                        {{-- {{ request()->routeIs('dashboard') ? 'bg-gray-800' : '' }}" --}} "
                    >
                        <span class="material-icons text-sm">exit_to_app</span>
                        <span class="text-sm">Peminjaman Masuk</span>
                    </a>
                    <a 
                        href="#"
                        class="flex items-center gap-3 p-2  hover:bg-white hover:text-gray-900 rounded-md transition-all 
                        {{-- {{ request()->routeIs('dashboard') ? 'bg-gray-800' : '' }}" --}} "
                    >
                        <span class="material-icons text-sm">assignment_return</span>
                        <span class="text-sm">Daftar Peminjaman</span>
                    </a>
                </div>
            </div>
            
            <!-- Pengembalian -->
            <div x-data="{ open: false }">
                <button @click="open = !open" class="w-full flex items-center justify-between gap-3 p-2  hover:bg-white hover:text-gray-900 rounded-md transition-all 
                {{-- {{ request()->routeIs('dashboard') ? 'bg-gray-800' : '' }}" --}} "
            >
                    <div class="flex items-center gap-3">
                        <span class="material-icons">assignment_return</span>
                        <span>Pengembalian</span>
                    </div>
                    <span class="material-icons" x-text="open ? 'expand_less' : 'expand_more'"></span>
                </button>
                
                <div x-show="open" x-collapse class="ml-8 mt-1 space-y-1">
                    <a 
                        href="#"
                        class="flex items-center gap-3 p-2  hover:bg-white hover:text-gray-900 rounded-md transition-all 
                        {{-- {{ request()->routeIs('dashboard') ? 'bg-gray-800' : '' }}" --}} "
                    >
                        <span class="material-icons text-sm">exit_to_app</span>
                        <span class="text-sm">Daftar Pengembalian</span>
                    </a>
                </div>
            </div>

            <!-- Riwayat Aktifitas -->
            <a 
                href="#"
                class="flex items-center gap-3 p-2  hover:bg-white hover:text-gray-900 rounded-md transition-all 
                {{-- {{ request()->routeIs('dashboard') ? 'bg-gray-800' : '' }}" --}} "
            >
                <span class="material-icons">list</span>
                <span>Riwayat Aktifitas</span>
            </a>
        </div>
    </div>

    <!-- Logout -->
    <div class="mt-auto p-4 border-t border-gray-800">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex items-center gap-3 p-2 text-white hover:bg-red-600 rounded-md transition-all w-full text-left">
                <span class="material-icons">logout</span>
                <span>Logout</span>
            </button>
        </form>
    </div>
</div>