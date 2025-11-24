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

    <div class="max-w-xl mx-auto p-6 bg-white shadow rounded-2xl space-y-5">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold">Tanda Tangan Digital</h2>
            <span class="text-xs text-gray-500">Gunakan mouse, stylus, atau sentuhan</span>
        </div>

        <!-- Toolbar -->
        <div class="flex items-center gap-3">
            <label class="text-sm text-gray-600">Warna:</label>
            <input id="pen-color" type="color" value="#0f172a" class="h-8 w-8 p-0 border rounded"/>
            <label class="text-sm text-gray-600 ml-4">Ketebalan:</label>
            <input id="pen-width" type="range" min="1" max="8" value="2" class="w-32"/>
            <button id="undo" class="ml-auto px-3 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700">Undo</button>
        </div>

        <!-- Canvas wrapper -->
        <div class="border border-gray-200 rounded-2xl overflow-hidden relative">
            <canvas id="signature" class="w-full h-56 bg-gray-50"></canvas>
            <div id="empty-hint" class="absolute inset-0 flex items-center justify-center pointer-events-none">
                <div class="text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-10 w-10 text-gray-300" viewBox="0 0 24 24" fill="currentColor"><path d="M2 5a2 2 0 012-2h5a2 2 0 012 2v6h6a2 2 0 012 2v5a2 2 0 01-2 2H9a2 2 0 01-2-2v-6H3a1 1 0 01-1-1V5zm3 1v4h4V6H5zm5 6v5h9v-5h-9z"/></svg>
                    <p class="text-sm text-gray-400 mt-2">Mulailah menggambar tanda tangan di sini</p>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex gap-3">
            <button id="clear" class="px-4 py-2 rounded-lg bg-red-500 text-white hover:bg-red-600">Bersihkan</button>
            <button id="save" class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">Simpan</button>
            <button id="download" class="px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">Unduh PNG</button>
        </div>

        <!-- Output -->
        <div class="space-y-2">
            <input type="hidden" id="signature_data" name="signature">
            <div id="preview" class="hidden">
                <label class="text-sm font-medium text-gray-700">Preview</label>
                <img id="preview_img" alt="Preview TTD" class="mt-1 border rounded-lg max-h-40"/>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>

    <script>
        const canvas = document.getElementById('signature');
        const penColor = document.getElementById('pen-color');
        const penWidth = document.getElementById('pen-width');
        const undoBtn = document.getElementById('undo');
        const clearBtn = document.getElementById('clear');
        const saveBtn = document.getElementById('save');
        const downloadBtn = document.getElementById('download');
        const emptyHint = document.getElementById('empty-hint');
        const signatureInput = document.getElementById('signature_data');
        const preview = document.getElementById('preview');
        const previewImg = document.getElementById('preview_img');

        const signaturePad = new SignaturePad(canvas, {
            backgroundColor: 'rgba(0,0,0,0)',
            penColor: penColor.value,
            minWidth: 0.5,
            maxWidth: parseFloat(penWidth.value),
        });

        function updateEmptyHint() {
            emptyHint.classList.toggle('hidden', !signaturePad.isEmpty());
        }

        // Resize canvas responsive dan high-DPI
        function resizeCanvas() {
            const ratio = Math.max(window.devicePixelRatio || 1, 1);
            const { offsetWidth, offsetHeight } = canvas;
            canvas.width = offsetWidth * ratio;
            canvas.height = offsetHeight * ratio;
            const ctx = canvas.getContext('2d');
            ctx.scale(ratio, ratio);
            signaturePad.clear();
            updateEmptyHint();
        }
        window.addEventListener('resize', resizeCanvas);
        resizeCanvas();

        // Toolbar interactions
        penColor.addEventListener('input', (e) => {
            signaturePad.penColor = e.target.value;
        });
        penWidth.addEventListener('input', (e) => {
            signaturePad.maxWidth = parseFloat(e.target.value);
        });

        // Undo last stroke
        undoBtn.addEventListener('click', () => {
            const data = signaturePad.toData();
            if (data) {
                data.pop();
                signaturePad.fromData(data);
                updateEmptyHint();
            }
        });

        // Clear all
        clearBtn.addEventListener('click', () => {
            signaturePad.clear();
            updateEmptyHint();
            preview.classList.add('hidden');
            previewImg.removeAttribute('src');
            signatureInput.value = '';
        });

        // Save to hidden input and show preview
        saveBtn.addEventListener('click', () => {
            if (signaturePad.isEmpty()) {
                alert('Tolong isi tanda tangan dulu.');
                return;
            }
            const dataURL = signaturePad.toDataURL('image/png');
            signatureInput.value = dataURL;
            previewImg.src = dataURL;
            preview.classList.remove('hidden');
            alert('Tanda tangan berhasil disimpan.');
        });

        // Download as PNG
        downloadBtn.addEventListener('click', () => {
            if (signaturePad.isEmpty()) {
                alert('Tidak ada tanda tangan untuk diunduh.');
                return;
            }
            const link = document.createElement('a');
            link.href = signaturePad.toDataURL('image/png');
            link.download = 'ttd.png';
            link.click();
        });

        // Update hint on drawing
        canvas.addEventListener('pointerdown', updateEmptyHint);
        canvas.addEventListener('pointerup', updateEmptyHint);
    </script>

</body>

</html>
