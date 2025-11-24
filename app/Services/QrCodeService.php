<?php

namespace App\Services;

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\Agenda;

class QrCodeService
{
    public function generateAgendaQrCode(Agenda $agenda): string
    {
        $qrCodeUrl = route('attendance.form', ['agendaId' => $agenda->id, 'slug' => $agenda->slug]);
        
        $fileName = 'qr-codes/agenda-' . $agenda->id . '.png';
        $filePath = storage_path('app/public/' . $fileName);
        
        // Create directory if it doesn't exist
        $directory = dirname($filePath);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }
        
        // Generate QR code with agenda details
        $qr = QrCode::format('png')
            ->size(300)
            ->margin(2);

        $logoPath = public_path('images/logo.png');
        if (file_exists($logoPath)) {
            // Validasi MIME agar hanya memproses bitmap yang didukung
            $imageInfo = @getimagesize($logoPath);
            $mime = $imageInfo['mime'] ?? null;
            if ($imageInfo && in_array($mime, ['image/png', 'image/jpeg'])) {
                try {
                    $qr->merge($logoPath, 0.3, true);
                } catch (\Throwable $e) {
                    Log::warning('QR merge logo failed: ' . $e->getMessage());
                    // Lanjutkan tanpa logo
                }
            } else {
                Log::warning('Logo image invalid or unsupported mime: ' . ($mime ?: 'unknown'));
            }
        }

        $qr->generate($qrCodeUrl, $filePath);
        
        return 'storage/' . $fileName;
    }

    public function generateSimpleQrCode(string $data, string $fileName): string
    {
        $filePath = storage_path('app/public/qr-codes/' . $fileName);
        
        // Create directory if it doesn't exist
        $directory = dirname($filePath);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }
        
        QrCode::format('png')
            ->size(200)
            ->margin(1)
            ->generate($data, $filePath);
        
        return 'storage/qr-codes/' . $fileName;
    }

    public function deleteQrCode(string $path): bool
    {
        if (Storage::exists(str_replace('storage/', '', $path))) {
            return Storage::delete(str_replace('storage/', '', $path));
        }
        
        return false;
    }
}