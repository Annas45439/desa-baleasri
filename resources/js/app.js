import './bootstrap';
import heic2any from 'heic2any';

const heicExtensions = /\.(heic|heif)$/i;

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('input[type="file"][accept*="image"]').forEach((input) => {
        input.addEventListener('change', async () => {
            const file = input.files?.[0];

            if (!file || (!heicExtensions.test(file.name) && !['image/heic', 'image/heif'].includes(file.type))) {
                return;
            }

            input.disabled = true;

            try {
                const converted = await heic2any({
                    blob: file,
                    toType: 'image/jpeg',
                    quality: 0.88,
                });
                const jpegBlob = Array.isArray(converted) ? converted[0] : converted;
                const convertedFile = new File(
                    [jpegBlob],
                    file.name.replace(/\.(heic|heif)$/i, '.jpg'),
                    { type: 'image/jpeg', lastModified: Date.now() }
                );
                const transfer = new DataTransfer();
                transfer.items.add(convertedFile);
                input.files = transfer.files;
                input.disabled = false;
                input.dataset.heicConverted = 'true';
            } catch (error) {
                input.value = '';
                input.disabled = false;
                console.error('Konversi HEIC gagal:', error);
                window.alert('Foto HEIC tidak dapat dikonversi. Silakan pilih foto lain atau simpan sebagai JPG/PNG.');
            }
        });
    });
});
