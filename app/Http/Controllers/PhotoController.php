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
                // Convert target color to RGB
                list($targetR, $targetG, $targetB) = sscanf($targetHex, "#%02x%02x%02x");

                // Use PHP collection filtering for more reliable color matching
                $photos = $query->whereNotNull('dominant_color')->get();

                $filteredPhotos = $photos->filter(function ($photo) use ($targetR, $targetG, $targetB) {
                    $photoHex = $photo->dominant_color;
                    list($photoR, $photoG, $photoB) = sscanf($photoHex, "#%02x%02x%02x");

                    // Calculate Euclidean distance in RGB space
                    $distance = sqrt(
                        pow($photoR - $targetR, 2) +
                        pow($photoG - $targetG, 2) +
                        pow($photoB - $targetB, 2)
                    );

                    // Store distance for sorting
                    $photo->color_distance = $distance;

                    // Use threshold of 150 for balanced color matching
                    return $distance <= 150;
                })->sortBy('color_distance');

                // Convert back to query builder result for pagination
                $photoIds = $filteredPhotos->pluck('id')->toArray();
                if (!empty($photoIds)) {
                    // Create a CASE statement for PostgreSQL ordering
                    $orderCases = [];
                    foreach ($photoIds as $index => $id) {
                        $orderCases[] = "WHEN {$id} THEN {$index}";
                    }
                    $orderByCase = "CASE id " . implode(' ', $orderCases) . " END";
                    $query = Photo::whereIn('id', $photoIds)->orderByRaw($orderByCase);
                } else {
                    $query = Photo::whereRaw('1 = 0'); // No results
                }

            } catch (\Exception $e) {
                $query = auth()->user()->photos()->latest();
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
