<div x-data="{
    showSuccess: false,
    showError: false,
    message: '',
    init() {
        this.$wire.on('toast', (event) => {
            this.message = event.message;
            if (event.type === 'success') {
                this.showSuccess = true;
                setTimeout(() => this.showSuccess = false, 5000);
            } else {
                this.showError = true;
                setTimeout(() => this.showError = false, 5000);
            }
        });
    }
}">
    <!-- Success Toast -->
    <template x-if="showSuccess">
        <div class="toast toast-top toast-end z-50 shadow-2xl rounded-xl">
            <div class="alert glass backdrop-blur-lg border border-primary text-secondary font-bold">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M9 12l2 2 4-4M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z" />
                </svg>
                <span x-text="message"></span>
            </div>
        </div>
    </template>

    <!-- Error Toast -->
    <template x-if="showError">
        <div class="toast toast-bottom toast-end z-50 shadow-2xl">
            <div class="alert alert-primary border border-error text-error font-bold">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2v6m0-6V4m0 0L3 10m7-6l7 6" />
                </svg>
                <span x-text="message"></span>
            </div>
        </div>
    </template>

    <form wire:submit.prevent="updateSettings" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- App Name -->
            <div class="form-control">
                <label class="label">
                    <span class="label-text font-semibold mb-3">Nama Aplikasi</span>
                </label>
                <input type="text" wire:model="app_name" class="input input-bordered w-full" placeholder="Monetra">
                @error('app_name')
                    <span class="text-error text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Login Title -->
            <div class="form-control">
                <label class="label">
                    <span class="label-text font-semibold mb-3">Judul Halaman Login</span>
                </label>
                <input type="text" wire:model="login_title" class="input input-bordered w-full"
                    placeholder="Welcome Back">
                @error('login_title')
                    <span class="text-error text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Login Description -->
        <div class="form-control">
            <label class="label">
                <span class="label-text font-semibold mb-3">Deskripsi Halaman Login</span>
            </label>
            <textarea wire:model="login_description" class="textarea textarea-bordered w-full h-24"
                placeholder="Enter your credentials to access your account"></textarea>
            @error('login_description')
                <span class="text-error text-xs mt-1">{{ $message }}</span>
            @enderror
        </div>

        <!-- Logo Upload -->
        <div class="form-control">
            <label class="label p-0 mb-3">
                <span class="label-text font-semibold">Logo Aplikasi (Square)</span>
            </label>
            <div x-data="{
                previewUrl: '{{ $current_logo_url }}',
                isRemoved: @entangle('remove_logo'),
                isOver: false,
                handleFile(e) {
                    const file = e.target.files[0];
                    if (!file) return;
                    if (file.size > 1024 * 1024) {
                        alert('Ukuran file maksimal 1MB');
                        return;
                    }
                    this.previewUrl = URL.createObjectURL(file);
                    this.isRemoved = false;
                }
            }" class="space-y-3">
                <div id="logo-dropzone"
                    class="relative rounded-xl border-dashed border-2 p-8 min-h-48 transition-all group flex flex-col items-center justify-center text-center"
                    :class="isOver ? 'border-primary bg-primary/5 scale-[0.99]' :
                        'border-base-300 bg-base-50 hover:bg-base-100'"
                    @dragover.prevent="isOver = true" @dragleave.prevent="isOver = false"
                    @drop.prevent="isOver = false; $refs.logoInput.files = $event.dataTransfer.files; handleFile({target: $refs.logoInput})">

                    <input id="logo-input" x-ref="logoInput" wire:model="app_logo" type="file"
                        accept=".jpg,.jpeg,.png,.webp"
                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" @change="handleFile">

                    <!-- Preview Overlay -->
                    <div x-show="previewUrl && !isRemoved" x-cloak
                        class="absolute inset-0 flex flex-col items-center justify-center bg-base-100 rounded-xl p-4 z-20">
                        <div class="avatar mb-4">
                            <div
                                class="w-24 h-24 rounded-lg flex items-center justify-center bg-base-200 overflow-hidden">
                                <img :src="previewUrl" alt="Preview" class="object-contain w-full h-full">
                            </div>
                        </div>
                        <button type="button"
                            @click.stop="isRemoved = true; previewUrl = null; $wire.set('app_logo', null)"
                            class="btn btn-error btn-outline btn-sm gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Hapus Logo
                        </button>
                    </div>

                    <!-- Placeholder -->
                    <div
                        class="flex flex-col items-center gap-3 text-base-content/40 group-hover:text-primary transition-colors">
                        <div class="w-16 h-16 rounded-full bg-base-200 flex items-center justify-center mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 16.5V9.75m0 0 3 3m-3-3-3 3M6.75 19.5a4.5 4.5 0 0 1-1.41-8.775 5.25 5.25 0 0 1 10.233-2.33 3 3 0 0 1 3.758 3.848A4.523 4.523 0 0 1 18.75 18.75h-1.875" />
                            </svg>
                        </div>
                        <div class="text-sm font-medium">Klik atau tarik logo ke sini</div>
                        <div class="text-xs">JPG, PNG, WebP (Maks. 1MB)</div>
                    </div>
                </div>
                @error('app_logo')
                    <div class="mt-1 text-xs text-error">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="btn btn-secondary" wire:loading.attr="disabled">
                <span wire:loading.remove>Simpan Perubahan</span>
                <span wire:loading><span class="loading loading-spinner loading-xs"></span> Menyimpan...</span>
            </button>
        </div>
    </form>
</div>
