<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Pengaturan Akun Saya<?= $this->endSection() ?>

<?= $this->section('content') ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script>

<div class="space-y-6 max-w-xl mx-auto">
    <div>
        <a href="<?= base_url('dashboard') ?>"
            class="text-xs font-bold text-slate-400 hover:text-slate-900 flex items-center gap-1 transition-colors group">
            <i data-lucide="arrow-left" class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform"></i> Kembali
            ke Dashboard
        </a>
    </div>

    <div>
        <h1 class="text-xl font-extrabold text-slate-950 tracking-tight">Pengaturan Profil Mandiri</h1>
        <p class="text-slate-400 text-xs mt-1">Perbarui informasi data diri atau foto profil Anda.</p>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div
            class="flex items-center gap-3 bg-rose-50 border border-rose-100 p-4 rounded-xl text-rose-800 text-xs font-semibold">
            <i data-lucide="alert-circle" class="w-4 h-4 text-rose-600 shrink-0"></i>
            <span><?= session()->getFlashdata('error') ?></span>
        </div>
    <?php endif; ?>

    <div class="bg-white border border-slate-100 p-6 sm:p-8 rounded-3xl shadow-xs">
        <form action="<?= base_url('profil/update') ?>" method="POST" enctype="multipart/form-data" id="form-profil"
            class="space-y-5">
            <?= csrf_field() ?>

            <input type="hidden" name="foto_crop_base64" id="foto-crop-base64">

            <div class="space-y-2 pb-5 border-b border-slate-100 flex flex-col sm:flex-row items-center gap-4">
                <?php
                $idUser = session()->get('id_pengguna');
                $avatarPath = 'uploads/avatars/' . $idUser . '.jpg';
                if (!file_exists(FCPATH . $avatarPath)) {
                    $avatarPath = 'uploads/avatars/' . $idUser . '.png';
                }
                if (!file_exists(FCPATH . $avatarPath)) {
                    $avatarPath = 'uploads/avatars/' . $idUser . '.jpeg';
                }
                $avatarNyata = file_exists(FCPATH . $avatarPath) ? base_url($avatarPath) : null;
                ?>

                <div
                    class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center border-4 border-white shadow-sm overflow-hidden shrink-0">
                    <img id="avatar-preview"
                        src="<?= $avatarNyata ? $avatarNyata . '?v=' . time() : 'https://ui-avatars.com/api/?name=' . urlencode($user['NAMA_LENGKAP']) . '&background=6366f1&color=fff' ?>"
                        class="w-full h-full object-cover">
                </div>

                <div class="space-y-1 flex-1 w-full text-center sm:text-left">
                    <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide block">Unggah & Potong
                        Foto</label>
                    <input type="file" id="file-input" accept="image/*"
                        class="w-full text-xs font-semibold text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer">
                    <p class="text-[10px] text-slate-400">Rekomendasi: Gambar persegi (1:1), Maksimal 2MB.</p>
                </div>
            </div>

            <div class="space-y-1">
                <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide block">Nama Lengkap
                    Anda</label>
                <div class="relative">
                    <input type="text" name="nama_lengkap"
                        value="<?= esc($user['NAMA_LENGKAP'] ?? old('nama_lengkap')) ?>" required
                        class="w-full text-xs font-semibold pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-indigo-500 outline-none transition-all text-slate-800">
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                        <i data-lucide="user" class="w-4 h-4"></i>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide block">Username
                        Akses</label>
                    <div class="relative">
                        <input type="text" name="username" value="<?= esc($user['USERNAME'] ?? old('username')) ?>"
                            required
                            class="w-full text-xs font-semibold pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-indigo-500 outline-none transition-all text-slate-800">
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                            <i data-lucide="shield" class="w-4 h-4"></i>
                        </div>
                    </div>
                </div>
                <div class="space-y-1">
                    <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide block">No. Telepon /
                        WA</label>
                    <div class="relative">
                        <input type="text" name="no_telp" value="<?= esc($user['NO_TELP'] ?? old('no_telp')) ?>"
                            required
                            class="w-full text-xs font-semibold pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-indigo-500 outline-none transition-all text-slate-800">
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                            <i data-lucide="phone" class="w-4 h-4"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-1">
                <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide block">Alamat Email
                    Aktif</label>
                <div class="relative">
                    <input type="email" name="email" value="<?= esc($user['EMAIL'] ?? old('email')) ?>" required
                        class="w-full text-xs font-semibold pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-indigo-500 outline-none transition-all text-slate-800">
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                        <i data-lucide="mail" class="w-4 h-4"></i>
                    </div>
                </div>
            </div>

            <div class="space-y-1">
                <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide block">Ganti Kata Sandi <span
                        class="text-slate-400 font-normal lowercase">(Opsional)</span></label>
                <div class="relative">
                    <input type="password" name="password" placeholder="Kosongkan jika tak ingin diubah"
                        class="w-full text-xs font-semibold pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-indigo-500 outline-none transition-all text-slate-800">
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                        <i data-lucide="lock" class="w-4 h-4"></i>
                    </div>
                </div>
            </div>

            <div class="space-y-1">
                <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wide block">Alamat
                    Domisili</label>
                <div class="relative">
                    <textarea name="alamat" rows="2" required
                        class="w-full text-xs font-semibold pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-indigo-500 outline-none transition-all resize-none text-slate-800"><?= esc($user['ALAMAT'] ?? old('alamat')) ?></textarea>
                    <div class="absolute left-4 top-4 text-slate-400">
                        <i data-lucide="map-pin" class="w-4 h-4"></i>
                    </div>
                </div>
            </div>

            <div class="flex justify-end items-center gap-3 pt-4 border-t border-slate-50 mt-6">
                <a href="<?= base_url('dashboard') ?>"
                    class="bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold px-6 py-3.5 rounded-xl transition-all uppercase tracking-wider">Batal</a>
                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold px-8 py-3.5 rounded-xl transition-all shadow-sm uppercase tracking-wider flex items-center gap-1.5 cursor-pointer">
                    <i data-lucide="save" class="w-4 h-4"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<div id="cropper-modal"
    class="fixed inset-0 z-50 hidden bg-slate-950/70 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-md w-full shadow-2xl space-y-4 p-6">
        <div class="flex justify-between items-center border-b border-slate-50 pb-2">
            <h3 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                <i data-lucide="crop" class="w-4 h-4 text-indigo-600"></i> Atur Posisi Foto
            </h3>
        </div>

        <div class="w-full bg-slate-50 rounded-2xl p-2 flex items-center justify-center">
            <div id="croppie-container" class="w-full"></div>
        </div>

        <div class="flex justify-end items-center gap-2 pt-3 border-t border-slate-100">
            <button type="button" id="btn-cancel-crop"
                class="bg-slate-100 hover:bg-slate-200 text-slate-700 text-[11px] font-bold px-4 py-2.5 rounded-xl uppercase cursor-pointer">
                Batal
            </button>
            <button type="button" id="btn-save-crop"
                class="bg-indigo-600 hover:bg-indigo-700 text-white text-[11px] font-bold px-5 py-2.5 rounded-xl shadow-sm uppercase flex items-center gap-1.5 cursor-pointer">
                <i data-lucide="check" class="w-3.5 h-3.5"></i> Gunakan
            </button>
        </div>
    </div>
</div>

<script>
    let croppieInstance = null;
    const fileInput = document.getElementById('file-input');
    const cropperModal = document.getElementById('cropper-modal');
    const croppieContainer = document.getElementById('croppie-container');
    const avatarPreview = document.getElementById('avatar-preview');
    const inputBase64 = document.getElementById('foto-crop-base64');
    const btnSaveCrop = document.getElementById('btn-save-crop');
    const btnCancelCrop = document.getElementById('btn-cancel-crop');

    // 1. Ambil File Gambar & Inisialisasi Croppie
    fileInput.addEventListener('change', function (e) {
        const files = e.target.files;
        if (files && files.length > 0) {
            const file = files[0];

            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran berkas terlalu besar! Maksimal batas ukuran adalah 2MB.');
                fileInput.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function (event) {
                // Tampilkan Modal Terlebih Dahulu agar lebar elemen ter-render stabil
                cropperModal.classList.remove('hidden');

                // Jika ada sisa instansi Croppie lama, hancurkan berkasnya
                if (croppieInstance) {
                    croppieInstance.destroy();
                }

                // Buat instansi Croppie baru di container
                croppieInstance = new Croppie(croppieContainer, {
                    viewport: {
                        width: 200,
                        height: 200,
                        type: 'circle' // Otomatis berbentuk lingkaran pratinjau profil
                    },
                    boundary: {
                        width: 300,
                        height: 300
                    },
                    showZoomer: true, // Menyalakan bar slider zoom di bawah gambar
                    enableOrientation: true
                });

                // Masukkan bind data gambar ke Croppie
                croppieInstance.bind({
                    url: event.target.result
                });
            };
            reader.readAsDataURL(file);
        }
    });

    // 2. Eksekusi Tombol "Gunakan" -> Convert ke Teks Base64
    btnSaveCrop.addEventListener('click', function (e) {
        e.preventDefault();

        if (!croppieInstance) return;

        // Ambil hasil pemotongan berupa Base64 secara asinkron lewat Promise Croppie
        croppieInstance.result({
            type: 'base64',
            size: { width: 400, height: 400 }, // Resolusi tajam untuk avatar
            format: 'jpeg',
            quality: 0.92
        }).then(function (base64Result) {
            // Pasang hasil ke preview UI dan hidden input form
            avatarPreview.src = base64Result;
            inputBase64.value = base64Result;

            // Sembunyikan modal dan hancurkan instansi
            cropperModal.classList.add('hidden');
            croppieInstance.destroy();
            croppieInstance = null;
        }).catch(function (err) {
            console.error('Croppie Error:', err);
            alert('Gagal memproses pemotongan gambar.');
        });
    });

    // 3. Tombol Batal
    btnCancelCrop.addEventListener('click', function (e) {
        e.preventDefault();
        cropperModal.classList.add('hidden');
        fileInput.value = '';
        if (croppieInstance) {
            croppieInstance.destroy();
            croppieInstance = null;
        }
    });
</script>

<?= $this->endSection() ?>