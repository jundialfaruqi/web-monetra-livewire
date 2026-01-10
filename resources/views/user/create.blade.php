<x-layout title="Create User">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold">Create User</h1>
            <p class="text-sm text-base-content/60 mt-1">Tambah pengguna baru</p>
        </div>
        <div class="text-sm breadcrumbs text-base-content/60">
            <ul>
                <li><a href="{{ route('dashboard.index') }}">Monetra</a></li>
                <li><a href="{{ route('users.index') }}">Users</a></li>
                <li><span class="text-base-content">Create</span></li>
            </ul>
        </div>
    </div>

    <div class="card bg-base-100 shadow-sm">
        <div class="card-body">
            <form id="user-create-form" method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data"
                class="space-y-6" data-loading>
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="label"><span class="label-text mb-2">Nama</span></label>
                        <input name="name" type="text" value="{{ old('name') }}"
                            class="input input-bordered w-full" placeholder="Masukkan nama lengkap">
                        @error('name')
                            <div class="mt-1 text-xs text-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label class="label"><span class="label-text mb-2">Email</span></label>
                        <input name="email" type="email" value="{{ old('email') }}"
                            class="input input-bordered w-full" placeholder="Masukkan alamat email">
                        @error('email')
                            <div class="mt-1 text-xs text-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div x-data="{ showPassword: false }">
                        <label class="label"><span class="label-text mb-2">Password</span></label>
                        <div class="relative">
                            <input name="password" :type="showPassword ? 'text' : 'password'"
                                class="input input-bordered w-full pr-12" minlength="6" placeholder="••••">
                            <button type="button" @click="showPassword = !showPassword"
                                class="absolute right-0 top-0 h-full px-4 text-base-content/50 hover:text-base-content transition-colors">
                                <!-- Eye Icon (Show) -->
                                <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                                <!-- Eye Slash Icon (Hide) -->
                                <svg x-show="showPassword" x-cloak xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <div class="mt-1 text-xs text-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label class="label"><span class="label-text mb-2">Status</span></label>
                        <select name="status" class="select select-bordered w-full">
                            <option value="active" @selected(old('status') === 'active')>Active</option>
                            <option value="pending" @selected(old('status') === 'pending')>Pending</option>
                            <option value="inactive" @selected(old('status') === 'inactive')>Inactive</option>
                        </select>
                        @error('status')
                            <div class="mt-1 text-xs text-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label class="label"><span class="label-text mb-2">Role</span></label>
                        <select name="role" class="select select-bordered w-full">
                            <option value="">Tidak ada</option>
                            @foreach ($roles ?? [] as $r)
                                <option value="{{ $r }}" @selected(old('role') === $r)>{{ $r }}
                                </option>
                            @endforeach
                        </select>
                        @error('role')
                            <div class="mt-1 text-xs text-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label class="label"><span class="label-text mb-2">Phone (opsional)</span></label>
                        <input name="phone" type="text" value="{{ old('phone') }}"
                            class="input input-bordered w-full">
                        @error('phone')
                            <div class="mt-1 text-xs text-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label class="label"><span class="label-text mb-2">Alamat (opsional)</span></label>
                        <input name="address" type="text" value="{{ old('address') }}"
                            class="input input-bordered w-full">
                        @error('address')
                            <div class="mt-1 text-xs text-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div x-data="{
                    previewUrl: null,
                    isOver: false,
                    errorTitle: '',
                    errorMessage: '',
                    showError: false,
                    handleFile(e) {
                        const file = e.target.files[0];
                        if (!file) return;
                
                        const allowed = ['image/jpeg', 'image/png', 'image/webp'];
                        if (!allowed.includes(file.type)) {
                            this.errorTitle = 'Format File Salah';
                            this.errorMessage = 'Silakan pilih gambar dengan format JPG, PNG, atau WEBP.';
                            this.showError = true;
                            e.target.value = '';
                            return;
                        }
                        if (file.size > 800 * 1024) {
                            this.errorTitle = 'Ukuran Gambar Terlalu Besar';
                            this.errorMessage = 'Maksimal ukuran gambar yang diperbolehkan adalah 800KB.';
                            this.showError = true;
                            e.target.value = '';
                            return;
                        }
                
                        this.previewUrl = URL.createObjectURL(file);
                    },
                    removePhoto() {
                        this.previewUrl = null;
                        document.getElementById('photo-input').value = '';
                    }
                }">
                    <!-- Error Modal -->
                    <template x-teleport="body">
                        <div x-show="showError" x-cloak class="modal modal-open">
                            <div class="modal-box border-t-4 border-error">
                                <div class="flex items-center gap-3 text-error mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="w-8 h-8">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                                    </svg>
                                    <h3 class="font-bold text-lg" x-text="errorTitle"></h3>
                                </div>
                                <p class="text-base-content/70" x-text="errorMessage"></p>
                                <div class="modal-action">
                                    <button type="button" class="btn btn-error"
                                        @click="showError = false">Tutup</button>
                                </div>
                            </div>
                            <div class="modal-backdrop bg-black/40" @click="showError = false"></div>
                        </div>
                    </template>

                    <label class="label"><span class="label-text mb-2">Photo (jpg, jpeg, png, webp; max
                            800KB)</span></label>
                    <div id="dropzone"
                        class="relative rounded-lg border-dashed border-2 p-6 min-h-45 transition-colors group"
                        :class="isOver ? 'border-primary bg-primary/5' : 'border-base-300 bg-base-200/50'"
                        @dragover.prevent="isOver = true" @dragleave.prevent="isOver = false"
                        @drop.prevent="isOver = false; $refs.photoInput.files = $event.dataTransfer.files; handleFile({target: $refs.photoInput})">

                        <input id="photo-input" x-ref="photoInput" name="photo" type="file"
                            accept=".jpg,.jpeg,.png,.webp"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" @change="handleFile">

                        <!-- Preview -->
                        <div x-show="previewUrl" x-cloak
                            class="absolute inset-0 flex flex-col items-center justify-center bg-base-100 rounded-lg p-4">
                            <div class="avatar mb-3 mt-2">
                                <div class="mask mask-squircle w-24 h-24">
                                    <img :src="previewUrl" alt="Preview">
                                </div>
                            </div>
                            <!-- Delete Button -->
                            <button type="button" @click.stop="removePhoto"
                                class="btn btn-error btn-outline btn-xs gap-2 z-20 mb-2" title="Hapus foto">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                <span>Hapus Foto</span>
                            </button>
                        </div>

                        <!-- Placeholder -->
                        <div x-show="!previewUrl"
                            class="flex flex-col items-center justify-center gap-3 text-base-content/60">
                            <img src="{{ asset('assets/images/illustrations/undraw_upload_cucu.svg') }}"
                                alt="Upload illustration" class="w-24 h-24">
                            <span>Drag & drop atau klik untuk pilih gambar</span>
                        </div>
                    </div>
                    @error('photo')
                        <div class="mt-1 text-xs text-error">{{ $message }}</div>
                    @enderror
                </div>
                <div class="flex justify-end gap-2">
                    <a href="{{ route('users.index') }}" class="btn">Batal</a>
                    <button type="submit" class="btn btn-secondary">
                        <span class="loading loading-spinner loading-xs hidden"></span>
                        <span class="btn-text">Simpan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layout>
