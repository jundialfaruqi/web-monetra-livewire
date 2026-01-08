<x-layout title="Create User - Monetra">
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
                    <div>
                        <label class="label"><span class="label-text mb-2">Password</span></label>
                        <div class="relative">
                            <input name="password" id="password-input" type="password"
                                class="input input-bordered w-full pr-10" minlength="6" placeholder="••••">
                            <button type="button" id="password-toggle"
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-base-content/60 hover:text-primary transition-colors">
                                <!-- Eye Icon -->
                                <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                                <!-- Eye Slash Icon -->
                                <svg id="eye-slash-icon" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 hidden">
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
                <div>
                    <label class="label"><span class="label-text mb-2">Photo (jpg, jpeg, png, webp; max
                            800KB)</span></label>
                    <div id="dropzone"
                        class="relative rounded-lg border-dashed border-2 border-base-300 bg-base-200/50 p-4 cursor-pointer min-h-36">
                        <input id="photo-input" name="photo" type="file" accept=".jpg,.jpeg,.png,.webp"
                            class="hidden">
                        <div id="placeholder"
                            class="flex flex-col items-center justify-center gap-3 text-base-content/60">
                            <img src="{{ asset('assets/images/illustrations/undraw_upload_cucu.svg') }}"
                                alt="Upload illustration" class="w-24 h-24">
                            <span>Drag & drop atau klik untuk pilih gambar</span>
                        </div>
                        <div id="preview" class="absolute inset-0 hidden items-center justify-center">
                            <div class="avatar">
                                <div class="mask mask-squircle w-24 h-24">
                                    <img id="preview-img" src="" alt="Preview">
                                </div>
                            </div>
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
    <script src="{{ asset('js/user-form.js') }}"></script>
</x-layout>
