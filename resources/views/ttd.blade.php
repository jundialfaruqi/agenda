<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

    <div class="max-w-lg mx-auto p-6 bg-white shadow rounded-xl space-y-4">
        <h2 class="text-xl font-semibold">Form Tanda Tangan</h2>

        <!-- Canvas -->
        <div class="border rounded-xl overflow-hidden">
            <canvas id="signature" class="w-full h-48 bg-gray-50"></canvas>
        </div>

        <!-- Buttons -->
        <div class="flex gap-3">
            <button id="clear" class="px-4 py-2 rounded-lg bg-red-500 text-white hover:bg-red-600">
                Hapus
            </button>
            <button id="save" class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">
                Simpan
            </button>
        </div>

        <!-- Hasil Base64 -->
        <input type="hidden" id="signature_data" name="signature">

        <p class="text-sm text-gray-500">Gunakan mouse atau sentuhan untuk tanda tangan.</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>

    <script>
        const canvas = document.getElementById("signature");
        const signaturePad = new SignaturePad(canvas);

        // Resize canvas biar tetap proporsional
        function resizeCanvas() {
            const ratio = Math.max(window.devicePixelRatio || 1, 1);
            canvas.width = canvas.offsetWidth * ratio;
            canvas.height = canvas.offsetHeight * ratio;
            canvas.getContext("2d").scale(ratio, ratio);
            signaturePad.clear();
        }

        window.addEventListener("resize", resizeCanvas);
        resizeCanvas();

        document.getElementById("clear").addEventListener("click", () => {
            signaturePad.clear();
        });

        document.getElementById("save").addEventListener("click", () => {
            if (signaturePad.isEmpty()) {
                alert("Tolong isi tanda tangan dulu.");
                return;
            }

            const data = signaturePad.toDataURL("image/png");
            document.getElementById("signature_data").value = data;
            alert("Tanda tangan berhasil disimpan.");
        });
    </script>

</body>

</html>
