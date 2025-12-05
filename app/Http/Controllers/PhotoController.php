<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use League\ColorExtractor\Color;
use League\ColorExtractor\ColorExtractor;
use League\ColorExtractor\Palette;

class PhotoController extends Controller
{
   public function index(Request $request)
    {
       $query = auth()->user()->photos();

        if ($request->filled('color')) {
            $targetHex = $request->color;
            
            try {
                list($r, $g, $b) = sscanf($targetHex, "#%02x%02x%02x");
                
                // 1. Simpan rumus jarak warna dalam variabel agar rapi
                // Rumus ini khusus untuk PostgreSQL
                $distanceCalculation = "SQRT(
                    POWER(('x' || SUBSTRING(dominant_color, 2, 2))::bit(8)::int - ?, 2) +
                    POWER(('x' || SUBSTRING(dominant_color, 4, 2))::bit(8)::int - ?, 2) +
                    POWER(('x' || SUBSTRING(dominant_color, 6, 2))::bit(8)::int - ?, 2)
                )";

                // 2. Select data beserta jarak warnanya
                $query->selectRaw("*, $distanceCalculation as color_distance", [$r, $g, $b]);
                
                // 3. FILTER: Hanya ambil yang jaraknya kurang dari 100 (Bisa diubah sesuai kebutuhan)
                // Kita gunakan whereRaw karena 'color_distance' alias belum terbentuk saat filtering WHERE berjalan
                $query->whereRaw("$distanceCalculation <= 100", [$r, $g, $b]);
                
                // 4. Urutkan dari yang paling mirip
                $query->orderBy('color_distance', 'asc');

            } catch (\Exception $e) {
                $query->latest();
            }
        } else {
            $query->latest();
        }

        $photos = $query->paginate(12);
        
        // Append parameter 'color' ke link pagination agar saat pindah halaman filter tidak hilang
        $photos->appends(['color' => $request->color]);
        return view('photos.index', compact('photos'));
    }

    public function create()
    {
        return view('photos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:51200',
        ]);

        $file = $request->file('photo');
        $path = $file->store('photos', 'public');

        // --- DETEKSI WARNA DOMINAN (DEBUG MODE) ---
        $hexColor = null;
        
        // Ambil path fisik file menggunakan Storage facade (Lebih aman dari manual string)
        $fullPath = Storage::disk('public')->path($path); 

        try {
            // Cek apakah file benar-benar ada
            if (!file_exists($fullPath)) {
                dd("File tidak ditemukan di: " . $fullPath);
            }

            $palette = Palette::fromFilename($fullPath);
            $extractor = new ColorExtractor($palette);
            $colors = $extractor->extract(1);
            
            if (empty($colors)) {
                dd("Ekstraktor gagal menemukan warna.");
            }

            $hexColor = Color::fromIntToHex($colors[0]);
            
        } catch (\Exception $e) {
            // JANGAN DIAMKAN ERROR, TAMPILKAN KE LAYAR:
            dd("Error Ekstrak Warna: " . $e->getMessage());
        }
        // -------------------------------------------

        Photo::create([
            'name' => $file->hashName(),
            'path' => $path,
            'original_name' => $file->getClientOriginalName(),
            'size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
            'user_id' => auth()->id(),
            'dominant_color' => $hexColor, 
        ]);

        return redirect()->route('photos.index')->with('success', 'Foto berhasil diupload!');
    }

    public function show(Photo $photo)
    {
        $this->authorize('view', $photo);
        return view('photos.show', compact('photo'));
    }

    public function destroy(Photo $photo)
    {
        $this->authorize('delete', $photo);

        Storage::disk('public')->delete($photo->path);
        $photo->delete();

        return redirect()->route('photos.index')->with('success', 'Foto berhasil dihapus!');
    }

    public function image($id)
    {
        $photo = Photo::findOrFail($id);
        $this->authorize('view', $photo);

        $file = Storage::disk('public')->get($photo->path);

        return response($file, 200)->header('Content-Type', $photo->mime_type);
    }

    public function download($id)
    {
        $photo = Photo::findOrFail($id);
        $this->authorize('view', $photo);

        if (!Storage::disk('public')->exists($photo->path)) {
            abort(404, 'File not found.');
        }

        $filePath = Storage::disk('public')->path($photo->path);

        return response()->download($filePath, $photo->original_name);
    }
}
