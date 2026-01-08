/**
 * User Form Scripts
 * Handles Dropzone photo upload and Password visibility toggle
 */
document.addEventListener('DOMContentLoaded', function() {
    // --- Dropzone & Photo Preview ---
    const dz = document.getElementById('dropzone');
    const input = document.getElementById('photo-input');
    const preview = document.getElementById('preview');
    const placeholder = document.getElementById('placeholder');
    const img = document.getElementById('preview-img');

    if (dz && input) {
        dz.addEventListener('click', () => input.click());
        dz.addEventListener('dragover', e => {
            e.preventDefault();
            dz.classList.add('border-primary');
        });
        dz.addEventListener('dragleave', () => dz.classList.remove('border-primary'));
        dz.addEventListener('drop', e => {
            e.preventDefault();
            dz.classList.remove('border-primary');
            if (e.dataTransfer.files && e.dataTransfer.files[0]) {
                input.files = e.dataTransfer.files;
                updatePreview();
            }
        });
        input.addEventListener('change', updatePreview);

        function updatePreview() {
            const file = input.files?.[0];
            if (!file) return;
            const allowed = ['image/jpeg', 'image/png', 'image/webp'];
            if (!allowed.includes(file.type)) {
                alert('Format gambar harus jpg, jpeg, png, atau webp');
                input.value = '';
                return;
            }
            if (file.size > 800 * 1024) {
                alert('Ukuran gambar maksimal 800KB');
                input.value = '';
                return;
            }
            const url = URL.createObjectURL(file);
            if (img) img.src = url;
            if (preview) {
                preview.classList.remove('hidden');
                preview.classList.add('flex');
            }
            if (placeholder) placeholder.classList.add('hidden');
        }
    }

    // --- Password Toggle ---
    const passwordToggle = document.getElementById('password-toggle');
    const passwordInput = document.getElementById('password-input');
    const eyeIcon = document.getElementById('eye-icon');
    const eyeSlashIcon = document.getElementById('eye-slash-icon');

    if (passwordToggle && passwordInput) {
        passwordToggle.addEventListener('click', function() {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon?.classList.add('hidden');
                eyeSlashIcon?.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeIcon?.classList.remove('hidden');
                eyeSlashIcon?.classList.add('hidden');
            }
        });
    }
});
