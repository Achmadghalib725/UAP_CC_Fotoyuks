<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Galeri Foto Saya') }}
            </h2>
            <a href="{{ route('photos.create') }}" class="bg-gradient-to-r from-green-600 to-green-500 hover:from-green-700 hover:to-green-600 text-white font-bold py-2 px-6 rounded-full shadow-lg transform hover:scale-105 transition-all duration-200 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Upload Foto Baru
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- [MULAI] BAGIAN FILTER WARNA --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-8 p-6"
                 x-data="colorPickerComponent()"
                 x-init="customColor = '{{ request('color', '#000000') }}'">
                <form method="GET" action="{{ route('photos.index') }}" x-ref="colorForm">
                    <input type="hidden" name="color" x-ref="customColorInput">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wide">Filter Warna Dominan</h3>
                        
                        <div class="flex flex-wrap gap-3 items-center">
                            {{-- Helper function untuk class tombol warna --}}
                            @php
                                $colors = [
                                    '#FF0000' => 'bg-red-500',
                                    '#0000FF' => 'bg-blue-500',
                                    '#008000' => 'bg-green-500',
                                    '#FFFF00' => 'bg-yellow-400',
                                    '#000000' => 'bg-black',
                                    '#FFFFFF' => 'bg-white border border-gray-200'
                                ];
                            @endphp

                            @foreach($colors as $hex => $class)
                                <button type="submit" name="color" value="{{ $hex }}"
                                    class="w-8 h-8 rounded-full {{ $class }} hover:scale-110 transition-transform duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 shadow-sm {{ request('color') == $hex ? 'ring-2 ring-offset-2 ring-green-500 scale-110' : '' }}"
                                    title="{{ $hex }}">
                                </button>
                            @endforeach

                            {{-- Custom Color Picker Button --}}
                            <button type="button"
                                    @click="togglePicker()"
                                    :class="showPicker ? 'ring-2 ring-green-500 ring-offset-2 scale-110' : ''"
                                    class="w-8 h-8 rounded-full bg-gradient-to-br from-purple-400 via-pink-400 to-yellow-400 hover:scale-110 transition-all duration-200 focus:outline-none shadow-sm border border-white relative group"
                                    title="Pilih Warna Kustom"
                                    aria-label="Buka pemilih warna kustom"
                                    :aria-expanded="showPicker">
                                <svg class="w-5 h-5 mx-auto text-white drop-shadow" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 2a2 2 0 00-2 2v11a2 2 0 002 2h12a2 2 0 002-2V4a2 2 0 00-2-2H4zm0 2h12v11H4V4zm2 2a1 1 0 100 2 1 1 0 000-2zm4 0a1 1 0 100 2 1 1 0 000-2zm4 0a1 1 0 100 2 1 1 0 000-2zM6 10a1 1 0 100 2 1 1 0 000-2zm4 0a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"></path>
                                </svg>
                                <span x-show="selectedColorType === 'custom' && !showPicker"
                                      class="absolute -top-1 -right-1 w-3 h-3 bg-green-500 rounded-full border-2 border-white">
                                </span>
                            </button>

                            {{-- Tombol Reset --}}
                            @if(request('color'))
                                <a href="{{ route('photos.index') }}" 
                                   class="ml-2 px-4 py-1.5 bg-gray-100 text-gray-600 rounded-full hover:bg-gray-200 transition-colors text-xs font-bold uppercase tracking-wider">
                                    Reset
                                </a>
                            @endif
                        </div>
                    </div>
                </form>

                {{-- [MULAI] COLOR PICKER PANEL --}}
                <div x-show="showPicker"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 transform -translate-y-2"
                     x-transition:enter-end="opacity-100 transform translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 transform translate-y-0"
                     x-transition:leave-end="opacity-0 transform -translate-y-2"
                     @keydown.escape="showPicker = false"
                     role="dialog"
                     aria-labelledby="picker-title"
                     class="mt-6 p-6 bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl border border-gray-200">

                    {{-- Header --}}
                    <div class="flex justify-between items-center mb-4">
                        <h4 id="picker-title" class="text-sm font-bold text-gray-700 uppercase tracking-wide">
                            Pilih Warna Kustom
                        </h4>
                        <button @click="showPicker = false"
                                type="button"
                                class="text-gray-400 hover:text-gray-600 transition-colors"
                                aria-label="Tutup pemilih warna">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    {{-- Color Preview & Hex Input --}}
                    <div class="flex gap-4 mb-4">
                        {{-- Preview Swatch --}}
                        <div class="w-16 h-16 rounded-xl shadow-inner border-2 border-white ring-1 ring-gray-200"
                             :style="`background-color: ${customColor}`"
                             title="Preview warna">
                        </div>

                        {{-- Hex Input --}}
                        <div class="flex-1">
                            <label for="hexInput" class="block text-xs font-bold text-gray-600 mb-1">Kode Hex</label>
                            <input type="text"
                                   id="hexInput"
                                   x-model="customColor"
                                   @input="updateCustomColor($event.target.value)"
                                   @keydown.enter="applyCustomColor()"
                                   placeholder="#000000"
                                   maxlength="7"
                                   class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 font-mono text-sm transition-colors"
                                   :class="isValidHex(customColor) ? 'border-green-300 bg-green-50' : 'border-red-300 bg-red-50'">
                            <p x-show="!isValidHex(customColor)"
                               class="text-xs text-red-600 mt-1 font-medium">
                                Format tidak valid. Gunakan format #RRGGBB (contoh: #FF5733)
                            </p>
                        </div>
                    </div>

                    {{-- Quick Palette Grid --}}
                    <div class="mb-4">
                        <label class="block text-xs font-bold text-gray-600 mb-2">Warna Populer</label>
                        <div class="grid grid-cols-8 sm:grid-cols-10 md:grid-cols-12 gap-1.5 sm:gap-2">
                            @php
                                $quickPalette = [
                                    // Reds (8)
                                    '#FFEBEE', '#FFCDD2', '#EF9A9A', '#E57373', '#EF5350', '#F44336', '#E53935', '#C62828',
                                    // Oranges (6)
                                    '#FFE0B2', '#FFCC80', '#FFB74D', '#FFA726', '#FF9800', '#F57C00',
                                    // Yellows (6)
                                    '#FFF9C4', '#FFF176', '#FFEE58', '#FFEB3B', '#FDD835', '#F9A825',
                                    // Greens (8)
                                    '#E8F5E9', '#C8E6C9', '#A5D6A7', '#81C784', '#66BB6A', '#4CAF50', '#43A047', '#2E7D32',
                                    // Blues (8)
                                    '#E3F2FD', '#BBDEFB', '#90CAF9', '#64B5F6', '#42A5F5', '#2196F3', '#1E88E5', '#1565C0',
                                    // Purples (6)
                                    '#F3E5F5', '#CE93D8', '#BA68C8', '#AB47BC', '#9C27B0', '#7B1FA2',
                                    // Grays (6)
                                    '#FFFFFF', '#E0E0E0', '#BDBDBD', '#9E9E9E', '#616161', '#000000'
                                ];
                            @endphp

                            @foreach($quickPalette as $color)
                                <button type="button"
                                        @click="customColor = '{{ $color }}'"
                                        :class="customColor === '{{ $color }}' ? 'ring-2 ring-green-500 ring-offset-1 scale-110' : ''"
                                        class="w-8 h-8 rounded-lg hover:scale-110 transition-transform shadow-sm border {{ $color === '#FFFFFF' ? 'border-gray-300' : 'border-gray-200' }}"
                                        style="background-color: {{ $color }}"
                                        title="{{ $color }}">
                                </button>
                            @endforeach
                        </div>
                    </div>

                    {{-- HSL Color Spectrum Picker --}}
                    <div class="mb-4">
                        <label class="block text-xs font-bold text-gray-600 mb-2">Pilih Warna</label>

                        {{-- 2D Color Spectrum (Saturation x Lightness) --}}
                        <div class="relative w-full h-48 rounded-xl overflow-hidden cursor-crosshair mb-3 border-2 border-gray-200 shadow-inner"
                             @mousedown="startDrag($event, 'spectrum')"
                             @touchstart="startDrag($event, 'spectrum')"
                             x-ref="spectrum"
                             :style="`background: linear-gradient(to top, #000, transparent), linear-gradient(to right, #fff, hsl(${hue}, 100%, 50%))`">

                            {{-- Draggable Picker Dot --}}
                            <div class="absolute w-5 h-5 border-3 border-white rounded-full shadow-lg pointer-events-none transform -translate-x-1/2 -translate-y-1/2"
                                 :style="`left: ${saturation}%; top: ${100 - lightness}%; box-shadow: 0 0 0 1px rgba(0,0,0,0.3), 0 2px 4px rgba(0,0,0,0.3)`">
                            </div>
                        </div>

                        {{-- Hue Slider --}}
                        <div class="mb-2">
                            <div class="flex items-center gap-3">
                                <span class="text-xs font-bold text-gray-600 w-8">Hue</span>
                                <div class="relative flex-1 h-8 rounded-lg overflow-hidden cursor-pointer border-2 border-gray-200 shadow-inner"
                                     @mousedown="startDrag($event, 'hue')"
                                     @touchstart="startDrag($event, 'hue')"
                                     x-ref="hueBar"
                                     style="background: linear-gradient(to right, #ff0000 0%, #ffff00 17%, #00ff00 33%, #00ffff 50%, #0000ff 67%, #ff00ff 83%, #ff0000 100%);">

                                    {{-- Hue Slider Handle --}}
                                    <div class="absolute top-0 bottom-0 w-1 bg-white border-2 border-gray-800 shadow-lg transform -translate-x-1/2"
                                         :style="`left: ${(hue / 360) * 100}%`">
                                    </div>
                                </div>
                                <span class="text-xs font-mono text-gray-600 w-8 text-right" x-text="Math.round(hue)"></span>
                            </div>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex gap-3 pt-2">
                        <button type="button"
                                @click="showPicker = false"
                                class="flex-1 px-4 py-2.5 bg-white border border-gray-200 text-gray-600 rounded-xl hover:bg-gray-50 font-bold text-sm transition-colors">
                            Batal
                        </button>
                        <button type="button"
                                @click="applyCustomColor()"
                                :disabled="!isValidHex(customColor)"
                                class="flex-1 px-4 py-2.5 bg-gradient-to-r from-green-600 to-green-500 text-white rounded-xl hover:from-green-700 hover:to-green-600 font-bold text-sm shadow-lg disabled:opacity-50 disabled:cursor-not-allowed transition-all">
                            Terapkan Filter
                        </button>
                    </div>

                </div>
                {{-- [SELESAI] COLOR PICKER PANEL --}}
            </div>
            {{-- [SELESAI] BAGIAN FILTER WARNA --}}

            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" class="bg-green-50 border border-green-200 text-green-700 p-4 mb-6 rounded-xl shadow-sm flex justify-between items-center">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                    <button @click="show = false" class="text-green-500 hover:text-green-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            @endif

            @if($photos->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($photos as $photo)
                        <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl border border-gray-100 overflow-hidden transition-all duration-300 transform hover:-translate-y-1">
                            <div class="relative aspect-square overflow-hidden bg-gray-100">
                                <a href="{{ route('photos.show', $photo) }}" class="block w-full h-full">
                                    <img src="{{ Storage::url($photo->path) }}" alt="{{ $photo->original_name }}"
                                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                </a>
                                
                                {{-- Overlay Actions --}}
                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center gap-3">
                                    <a href="{{ route('photos.show', $photo) }}" class="p-2 bg-white rounded-full text-gray-800 hover:text-green-600 transition-colors shadow-lg" title="Lihat">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                    
                                    <form action="{{ route('photos.destroy', $photo) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus foto ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 bg-white rounded-full text-gray-800 hover:text-red-600 transition-colors shadow-lg" title="Hapus">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            
                            <div class="p-4">
                                <h3 class="font-bold text-gray-800 text-sm mb-1 truncate" title="{{ $photo->original_name }}">
                                    {{ $photo->original_name }}
                                </h3>
                                <div class="flex justify-between items-center mt-2">
                                    <span class="text-xs font-medium px-2 py-1 bg-gray-100 text-gray-500 rounded-md">
                                        {{ $photo->size ? number_format($photo->size / 1024, 1) . ' KB' : 'N/A' }}
                                    </span>
                                    <span class="text-xs text-gray-400">
                                        {{ $photo->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-10">
                    {{ $photos->links() }}
                </div>
            @else
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-16 text-center">
                    <div class="mb-6 inline-flex p-4 bg-green-50 rounded-full">
                        <svg class="w-16 h-16 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Belum ada foto</h3>
                    <p class="text-gray-500 mb-8 max-w-md mx-auto">Galeri Anda masih kosong. Mulailah mengupload momen berharga Anda sekarang.</p>
                    <a href="{{ route('photos.create') }}"
                       class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-full shadow-lg hover:shadow-green-500/30 transform hover:scale-105 transition-all duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Upload Foto Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>

    <script>
        function colorPickerComponent() {
            return {
                showPicker: false,
                customColor: '#000000',

                // HSL values for color picker
                hue: 0,           // 0-360
                saturation: 100,  // 0-100
                lightness: 50,    // 0-100

                // Drag state
                isDragging: false,
                dragMode: null,   // 'spectrum' or 'hue'

                // Preset colors array for detection
                presetColors: ['#FF0000', '#0000FF', '#008000', '#FFFF00', '#000000', '#FFFFFF'],

                // Check if current filter is custom
                get selectedColorType() {
                    const currentColor = '{{ request("color") }}';
                    if (!currentColor) return 'none';
                    return this.presetColors.includes(currentColor.toUpperCase()) ? 'preset' : 'custom';
                },

                // Hex validation
                isValidHex(color) {
                    return /^#[0-9A-F]{6}$/i.test(color);
                },

                // Toggle picker
                togglePicker() {
                    this.showPicker = !this.showPicker;
                    if (this.showPicker) {
                        // Sync HSL with current hex
                        this.hexToHSL(this.customColor);
                    }
                },

                // Update custom color from hex input
                updateCustomColor(value) {
                    // Auto-add # if missing
                    if (value && !value.startsWith('#')) {
                        value = '#' + value;
                    }
                    this.customColor = value.toUpperCase();

                    // Update HSL if valid
                    if (this.isValidHex(value)) {
                        this.hexToHSL(value);
                    }
                },

                // Apply custom color
                applyCustomColor() {
                    if (this.isValidHex(this.customColor)) {
                        this.$refs.customColorInput.value = this.customColor;
                        this.$refs.colorForm.submit();
                    }
                },

                // Start drag interaction
                startDrag(event, mode) {
                    this.isDragging = true;
                    this.dragMode = mode;

                    // Handle initial position
                    this.handleDrag(event);

                    // Add global event listeners
                    const handleMove = (e) => {
                        if (this.isDragging) {
                            this.handleDrag(e);
                        }
                    };

                    const handleEnd = () => {
                        this.isDragging = false;
                        this.dragMode = null;
                        document.removeEventListener('mousemove', handleMove);
                        document.removeEventListener('mouseup', handleEnd);
                        document.removeEventListener('touchmove', handleMove);
                        document.removeEventListener('touchend', handleEnd);
                    };

                    document.addEventListener('mousemove', handleMove);
                    document.addEventListener('mouseup', handleEnd);
                    document.addEventListener('touchmove', handleMove);
                    document.addEventListener('touchend', handleEnd);

                    event.preventDefault();
                },

                // Handle drag movement
                handleDrag(event) {
                    if (!this.isDragging) return;

                    const clientX = event.touches ? event.touches[0].clientX : event.clientX;
                    const clientY = event.touches ? event.touches[0].clientY : event.clientY;

                    if (this.dragMode === 'spectrum') {
                        const rect = this.$refs.spectrum.getBoundingClientRect();
                        const x = Math.max(0, Math.min(clientX - rect.left, rect.width));
                        const y = Math.max(0, Math.min(clientY - rect.top, rect.height));

                        this.saturation = (x / rect.width) * 100;
                        this.lightness = 100 - (y / rect.height) * 100;

                        this.updateHexFromHSL();
                    } else if (this.dragMode === 'hue') {
                        const rect = this.$refs.hueBar.getBoundingClientRect();
                        const x = Math.max(0, Math.min(clientX - rect.left, rect.width));

                        this.hue = (x / rect.width) * 360;

                        this.updateHexFromHSL();
                    }
                },

                // Convert HSL to Hex
                updateHexFromHSL() {
                    const h = this.hue / 360;
                    const s = this.saturation / 100;
                    const l = this.lightness / 100;

                    let r, g, b;

                    if (s === 0) {
                        r = g = b = l;
                    } else {
                        const hue2rgb = (p, q, t) => {
                            if (t < 0) t += 1;
                            if (t > 1) t -= 1;
                            if (t < 1/6) return p + (q - p) * 6 * t;
                            if (t < 1/2) return q;
                            if (t < 2/3) return p + (q - p) * (2/3 - t) * 6;
                            return p;
                        };

                        const q = l < 0.5 ? l * (1 + s) : l + s - l * s;
                        const p = 2 * l - q;

                        r = hue2rgb(p, q, h + 1/3);
                        g = hue2rgb(p, q, h);
                        b = hue2rgb(p, q, h - 1/3);
                    }

                    const toHex = (x) => {
                        const hex = Math.round(x * 255).toString(16);
                        return hex.length === 1 ? '0' + hex : hex;
                    };

                    this.customColor = '#' + toHex(r) + toHex(g) + toHex(b);
                    this.customColor = this.customColor.toUpperCase();
                },

                // Convert Hex to HSL
                hexToHSL(hex) {
                    const result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
                    if (!result) return;

                    let r = parseInt(result[1], 16) / 255;
                    let g = parseInt(result[2], 16) / 255;
                    let b = parseInt(result[3], 16) / 255;

                    const max = Math.max(r, g, b);
                    const min = Math.min(r, g, b);
                    let h, s, l = (max + min) / 2;

                    if (max === min) {
                        h = s = 0;
                    } else {
                        const d = max - min;
                        s = l > 0.5 ? d / (2 - max - min) : d / (max + min);

                        switch (max) {
                            case r: h = ((g - b) / d + (g < b ? 6 : 0)) / 6; break;
                            case g: h = ((b - r) / d + 2) / 6; break;
                            case b: h = ((r - g) / d + 4) / 6; break;
                        }
                    }

                    this.hue = h * 360;
                    this.saturation = s * 100;
                    this.lightness = l * 100;
                }
            }
        }
    </script>
</x-app-layout>