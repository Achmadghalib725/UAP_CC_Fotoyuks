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

                // Gunakan rumus jarak warna yang lebih sederhana untuk dominant_color
                $distanceCalculation = "SQRT(
                    POWER(('x' || SUBSTRING(dominant_color, 2, 2))::bit(8)::int - ?, 2) +
                    POWER(('x' || SUBSTRING(dominant_color, 4, 2))::bit(8)::int - ?, 2) +
                    POWER(('x' || SUBSTRING(dominant_color, 6, 2))::bit(8)::int - ?, 2)
                )";

                // Filter warna dengan toleransi yang lebih besar (200 alih-alih 100)
                $query->selectRaw("*, $distanceCalculation as color_distance", [$r, $g, $b])
                      ->whereRaw("$distanceCalculation <= 200", [$r, $g, $b])
                      ->whereNotNull('dominant_color')
                      ->orderBy('color_distance', 'asc');

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

        // --- DETEKSI PALET WARNA ---
        $hexColor = null;
        $colorPalette = null;

        // Ambil path fisik file menggunakan Storage facade (Lebih aman dari manual string)
        $fullPath = Storage::disk('public')->path($path);

        try {
            // Cek apakah file benar-benar ada
            if (!file_exists($fullPath)) {
                dd("File tidak ditemukan di: " . $fullPath);
            }

            $palette = Palette::fromFilename($fullPath);
            $extractor = new ColorExtractor($palette);

            // Ekstrak 5 warna teratas dengan persentase
            $colors = $extractor->extract(5);

            if (empty($colors)) {
                dd("Ekstraktor gagal menemukan warna.");
            }

            // Warna dominan (pertama)
            $hexColor = Color::fromIntToHex($colors[0]);

            // Palet warna lengkap dengan persentase (berdasarkan urutan ekstraksi)
            $colorPalette = [];
            $totalExtracted = count($colors);
            foreach ($colors as $index => $color) {
                $hex = Color::fromIntToHex($color);
                // Berikan persentase berdasarkan posisi (warna pertama = 50%, kedua = 25%, dst.)
                $percentage = 50 / pow(2, $index);
                $colorPalette[] = [
                    'hex' => $hex,
                    'percentage' => round($percentage, 2)
                ];
            }

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
            'color_palette' => json_encode($colorPalette),
        ]);

        return redirect()->route('photos.index')->with('success', 'Foto berhasil diupload!');
    }

    public function show(Photo $photo)
    {
        $this->authorize('view', $photo);
        return view('photos.show', compact('photo'));
    }

    public function rename(Request $request, Photo $photo)
    {
        $this->authorize('update', $photo);

        $request->validate([
            'original_name' => 'required|string|max:255',
        ]);

        $photo->update([
            'original_name' => $request->original_name,
        ]);

        return redirect()->route('photos.show', $photo)->with('success', 'Nama foto berhasil diubah!');
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
