<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pendaftaran Akun - SMP Negeri 01 Namrole</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f4ff',
                            100: '#e0e9ff',
                            500: '#13315c',
                            600: '#0f2650',
                            700: '#0b1a44'
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="min-h-screen" style="background: linear-gradient(135deg, #13315c 0%, #1e4d8b 100%);">
    <div class="min-h-screen flex items-center justify-center py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl w-full">
    <!-- Header -->
    <div class="text-center mb-8">
                <div class="mx-auto w-20 h-20 bg-white rounded-full flex items-center justify-center mb-6 shadow-lg">
                    <i class="fas fa-graduation-cap text-4xl text-primary-500"></i>
                </div>
                <h1 class="text-3xl font-bold text-white mb-2">SMP Negeri 01 Namrole</h1>
                <p class="text-sm text-white opacity-80">Pendaftaran Akun Pengguna</p>
            </div>

            <!-- Form Container -->
            <div class="bg-white rounded-2xl shadow-2xl p-8 md:p-12 relative">
                <!-- Progress Steps -->
                <div class="mb-10">
                    <div class="flex justify-between items-center relative">
                        <!-- Progress Line Background -->
                        <div class="absolute top-6 left-0 w-full h-0.5 bg-gray-200 z-0"></div>
                        
                        <!-- Progress Line Active -->
                        <div class="absolute top-6 left-0 h-0.5 bg-primary-500 z-10 transition-all duration-300 ease-in-out" 
                             :style="`width: ${(currentStep - 1) * 25}%`"></div>
                        
                        <!-- Step Items -->
                        <template x-for="(step, index) in steps" :key="index">
                            <div class="flex flex-col items-center relative z-20">
                                <!-- Circle -->
                                <div class="w-12 h-12 rounded-full border-3 flex items-center justify-center font-bold transition-all duration-200"
                                     :class="{
                                         'bg-white border-gray-300 text-gray-400': currentStep < index + 1,
                                         'bg-primary-500 border-primary-500 text-white scale-110 shadow-lg': currentStep === index + 1,
                                         'bg-primary-500 border-primary-500 text-white': currentStep > index + 1
                                     }">
                                    <i x-show="currentStep > index + 1" class="fas fa-check text-white"></i>
                                    <span x-show="currentStep <= index + 1" x-text="index + 1"></span>
    </div>

                                <!-- Label -->
                                <span class="text-xs md:text-sm mt-2 text-center max-w-20 hidden md:block"
                                      :class="{
                                          'text-gray-600': currentStep < index + 1,
                                          'text-primary-500 font-semibold': currentStep === index + 1,
                                          'text-gray-900': currentStep > index + 1
                                      }"
                                      x-text="step.name"></span>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Form -->
                <form @submit.prevent="submitForm" class="space-y-8">
                    <!-- Step 1: Pilih Tipe -->
                    <div x-show="currentStep === 1" class="space-y-6">
                        <div class="text-center mb-8">
                            <h2 class="text-2xl font-bold text-primary-500 mb-2">Pilih Tipe Pendaftaran</h2>
                            <p class="text-gray-600">Pilih kategori yang sesuai dengan Anda</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Siswa Option -->
                            <div class="relative">
                                <input type="radio" name="registration_type" value="student" id="type-student" 
                                       class="hidden" x-model="formData.registration_type">
                                <label for="type-student" 
                                       class="block p-8 border-3 rounded-2xl cursor-pointer transition-all duration-200 hover:border-primary-500 hover:bg-blue-50 hover:-translate-y-1 hover:shadow-lg"
                                       :class="formData.registration_type === 'student' ? 'border-primary-500 bg-blue-50 scale-102 shadow-xl' : 'border-gray-300 bg-white'">
                                    <div class="text-center">
                                        <i class="fas fa-user-graduate text-6xl text-primary-500 mb-4"></i>
                                        <h3 class="text-xl font-bold text-gray-900 mb-2">Siswa</h3>
                                        <p class="text-sm text-gray-600 leading-relaxed">Daftar sebagai siswa untuk mengakses portal pembelajaran</p>
                                    </div>
                                    <div x-show="formData.registration_type === 'student'" 
                                         class="absolute top-4 right-4 w-6 h-6 bg-primary-500 rounded-full flex items-center justify-center">
                                        <i class="fas fa-check text-white text-sm"></i>
                                    </div>
                                </label>
                            </div>

                            <!-- Orang Tua Option -->
                            <div class="relative">
                                <input type="radio" name="registration_type" value="parent" id="type-parent" 
                                       class="hidden" x-model="formData.registration_type">
                                <label for="type-parent" 
                                       class="block p-8 border-3 rounded-2xl cursor-pointer transition-all duration-200 hover:border-primary-500 hover:bg-blue-50 hover:-translate-y-1 hover:shadow-lg"
                                       :class="formData.registration_type === 'parent' ? 'border-primary-500 bg-blue-50 scale-102 shadow-xl' : 'border-gray-300 bg-white'">
                                    <div class="text-center">
                                        <i class="fas fa-users text-6xl text-primary-500 mb-4"></i>
                                        <h3 class="text-xl font-bold text-gray-900 mb-2">Orang Tua/Wali</h3>
                                        <p class="text-sm text-gray-600 leading-relaxed">Daftar sebagai orang tua untuk memantau perkembangan anak</p>
                                    </div>
                                    <div x-show="formData.registration_type === 'parent'" 
                                         class="absolute top-4 right-4 w-6 h-6 bg-primary-500 rounded-full flex items-center justify-center">
                                        <i class="fas fa-check text-white text-sm"></i>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Info Alert -->
                        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-info-circle text-blue-500 mr-3"></i>
                                <p class="text-sm text-blue-700">Pastikan Anda memilih tipe yang sesuai. Tipe tidak dapat diubah setelah pendaftaran.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Data Pribadi -->
                    <div x-show="currentStep === 2" class="space-y-6">
                        <div class="text-center mb-8">
                            <h2 class="text-2xl font-bold text-primary-500 mb-2">Data Pribadi</h2>
                            <p class="text-gray-600">Isi data pribadi Anda dengan lengkap dan benar</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nama Lengkap -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-user mr-2 text-primary-500"></i>Nama Lengkap *
                                </label>
                                <input type="text" x-model="formData.full_name" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                       placeholder="Masukkan nama lengkap sesuai KTP/Akta">
                                <p class="text-xs text-gray-500 mt-1">Nama harus sesuai dengan dokumen resmi</p>
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-envelope mr-2 text-primary-500"></i>Alamat Email *
                                </label>
                                <div class="relative">
                                    <input type="email" x-model="formData.email" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                           placeholder="contoh@email.com">
                                    <div class="absolute right-3 top-1/2 transform -translate-y-1/2">
                                        <i x-show="formData.email && isValidEmail(formData.email)" 
                                           class="fas fa-check text-green-500"></i>
                                        <i x-show="formData.email && !isValidEmail(formData.email)" 
                                           class="fas fa-times text-red-500"></i>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Email akan digunakan untuk login dan verifikasi</p>
                            </div>

                            <!-- Phone -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-phone mr-2 text-primary-500"></i>Nomor HP/WhatsApp *
                                </label>
                                <input type="tel" x-model="formData.phone" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                       placeholder="08xxxxxxxxxx">
                                <p class="text-xs text-gray-500 mt-1">Nomor aktif WhatsApp untuk verifikasi</p>
                            </div>

                            <!-- NIK -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-id-card mr-2 text-primary-500"></i>NIK (Nomor Induk Kependudukan)
                                </label>
                                <input type="text" x-model="formData.nik" maxlength="16"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                       placeholder="16 digit NIK KTP">
                                <p class="text-xs text-gray-500 mt-1">NIK sesuai KTP untuk verifikasi identitas</p>
                            </div>

                            <!-- Birth Place -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-map-marker-alt mr-2 text-primary-500"></i>Tempat Lahir
                                </label>
                                <input type="text" x-model="formData.birth_place"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                       placeholder="Contoh: Jakarta">
                            </div>

                            <!-- Birth Date -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-calendar mr-2 text-primary-500"></i>Tanggal Lahir *
                                </label>
                                <input type="date" x-model="formData.birth_date" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                <p x-show="formData.birth_date" class="text-xs text-gray-500 mt-1">
                                    Usia: <span x-text="calculateAge(formData.birth_date)"></span> tahun
                                </p>
                            </div>

                            <!-- Gender -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-3">Jenis Kelamin *</label>
                                <div class="flex space-x-6">
                                    <label class="flex items-center cursor-pointer">
                                        <input type="radio" name="gender" value="L" x-model="formData.gender" required
                                               class="hidden">
                                        <div class="flex items-center p-4 border-2 rounded-lg transition-all duration-200"
                                             :class="formData.gender === 'L' ? 'border-blue-500 bg-blue-50' : 'border-gray-300 hover:border-blue-400'">
                                            <i class="fas fa-mars text-2xl text-blue-500 mr-3"></i>
                                            <span class="font-medium">Laki-laki</span>
                                        </div>
                                    </label>
                                    <label class="flex items-center cursor-pointer">
                                        <input type="radio" name="gender" value="P" x-model="formData.gender" required
                                               class="hidden">
                                        <div class="flex items-center p-4 border-2 rounded-lg transition-all duration-200"
                                             :class="formData.gender === 'P' ? 'border-pink-500 bg-pink-50' : 'border-gray-300 hover:border-pink-400'">
                                            <i class="fas fa-venus text-2xl text-pink-500 mr-3"></i>
                                            <span class="font-medium">Perempuan</span>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Address -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-home mr-2 text-primary-500"></i>Alamat Lengkap *
                                </label>
                                <textarea x-model="formData.address" required rows="3"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                          placeholder="Jalan, RT/RW, Kelurahan, Kecamatan"></textarea>
                                <p class="text-xs text-gray-500 mt-1">
                                    <span x-text="formData.address ? formData.address.length : 0"></span>/500 karakter
                                </p>
                            </div>

                            <!-- City -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-building mr-2 text-primary-500"></i>Kota/Kabupaten *
                                </label>
                                <input type="text" x-model="formData.city" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                       placeholder="Pilih atau ketik kota">
                            </div>

                            <!-- Province -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-map mr-2 text-primary-500"></i>Provinsi *
                                </label>
                                <select x-model="formData.province" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                    <option value="">Pilih provinsi</option>
                                    <option value="DKI Jakarta">DKI Jakarta</option>
                                    <option value="Jawa Barat">Jawa Barat</option>
                                    <option value="Jawa Tengah">Jawa Tengah</option>
                                    <option value="Jawa Timur">Jawa Timur</option>
                                    <option value="Banten">Banten</option>
                                    <option value="Yogyakarta">Yogyakarta</option>
                                    <!-- Add more provinces -->
                                </select>
                            </div>

                            <!-- Postal Code -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Kode Pos</label>
                                <input type="text" x-model="formData.postal_code" maxlength="5"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                       placeholder="12345">
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Data Tambahan -->
                    <div x-show="currentStep === 3" class="space-y-6">
                        <div class="text-center mb-8">
                            <h2 class="text-2xl font-bold text-primary-500 mb-2">Data Tambahan</h2>
                            <p class="text-gray-600" x-text="formData.registration_type === 'student' ? 'Informasi Pendidikan Anda' : 'Informasi Orang Tua/Wali'"></p>
                        </div>

                        <!-- Student Fields -->
                        <div x-show="formData.registration_type === 'student'" class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- NISN -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-id-badge mr-2 text-primary-500"></i>NISN (Nomor Induk Siswa Nasional)
                                    </label>
                                    <input type="text" x-model="formData.nisn" maxlength="10"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                           placeholder="10 digit NISN">
                                    <p class="text-xs text-gray-500 mt-1">NISN dari sekolah sebelumnya</p>
                                </div>

                                <!-- School Origin -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-school mr-2 text-primary-500"></i>Asal Sekolah *
                                    </label>
                                    <input type="text" x-model="formData.school_origin" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                           placeholder="Nama sekolah terakhir">
                                </div>

                                <!-- Last Education -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-graduation-cap mr-2 text-primary-500"></i>Pendidikan Terakhir *
                                    </label>
                                    <select x-model="formData.last_education" required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                        <option value="">Pilih pendidikan</option>
                                        <option value="SD/MI">SD/MI</option>
                                        <option value="SMP/MTs">SMP/MTs</option>
                                        <option value="SMA/SMK/MA">SMA/SMK/MA</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                </div>

                                <!-- Graduation Year -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-calendar mr-2 text-primary-500"></i>Tahun Lulus *
                                    </label>
                                    <select x-model="formData.graduation_year" required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                        <option value="">Pilih tahun</option>
                                        <template x-for="year in getYears()" :key="year">
                                            <option :value="year" x-text="year"></option>
                                        </template>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Parent Fields -->
                        <div x-show="formData.registration_type === 'parent'" class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Relation Type -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-user-friends mr-2 text-primary-500"></i>Hubungan dengan Siswa *
                                    </label>
                                    <select x-model="formData.relation_type" required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                        <option value="">Pilih hubungan</option>
                                        <option value="ayah">Ayah Kandung</option>
                                        <option value="ibu">Ibu Kandung</option>
                                        <option value="wali">Wali</option>
                                    </select>
                                </div>

                                <!-- Occupation -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-briefcase mr-2 text-primary-500"></i>Pekerjaan *
                                    </label>
                                    <input type="text" x-model="formData.occupation" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                           placeholder="Contoh: Pegawai Swasta">
                                </div>

                                <!-- Student Name -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-user-graduate mr-2 text-primary-500"></i>Nama Lengkap Siswa *
                                    </label>
                                    <input type="text" x-model="formData.student_name" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                           placeholder="Nama siswa yang akan dipantau">
                                    <p class="text-xs text-gray-500 mt-1">Masukkan nama siswa yang terdaftar di sekolah</p>
                                </div>

                                <!-- Student NIS -->
        <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-id-card mr-2 text-primary-500"></i>NIS Siswa
                                    </label>
                                    <input type="text" x-model="formData.student_nis"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                           placeholder="Jika sudah tahu NIS siswa">
                                    <p class="text-xs text-gray-500 mt-1">Untuk mempermudah pencocokan data</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 4: Keamanan -->
                    <div x-show="currentStep === 4" class="space-y-6">
                        <div class="text-center mb-8">
                            <h2 class="text-2xl font-bold text-primary-500 mb-2">Keamanan Akun</h2>
                            <p class="text-gray-600">Buat password yang kuat untuk mengamankan akun Anda</p>
        </div>

                        <!-- Security Tips -->
                        <div class="bg-yellow-50 border border-yellow-300 rounded-xl p-5 mb-6">
                            <div class="flex items-start">
                                <i class="fas fa-shield-alt text-2xl text-yellow-600 mr-4 mt-1"></i>
        <div>
                                    <h3 class="font-semibold text-yellow-800 mb-2">Tips Password Aman</h3>
                                    <ul class="text-sm text-yellow-700 space-y-1">
                                        <li>• Minimal 8 karakter</li>
                                        <li>• Kombinasi huruf besar dan kecil</li>
                                        <li>• Mengandung angka</li>
                                        <li>• Mengandung simbol (@, #, $, dll)</li>
                                        <li>• Tidak menggunakan informasi pribadi</li>
                                    </ul>
                                </div>
                            </div>
        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Password -->
        <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-lock mr-2 text-primary-500"></i>Password *
                                </label>
                                <div class="relative">
                                    <input :type="showPassword ? 'text' : 'password'" x-model="formData.password" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                           placeholder="Minimal 8 karakter">
                                    <button type="button" @click="showPassword = !showPassword"
                                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                                        <i :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                                    </button>
                                </div>
                                
                                <!-- Password Strength Meter -->
                                <div class="mt-2">
                                    <div class="flex space-x-1">
                                        <div class="h-1 flex-1 bg-gray-200 rounded"
                                             :class="getPasswordStrength() >= 1 ? 'bg-red-500' : ''"></div>
                                        <div class="h-1 flex-1 bg-gray-200 rounded"
                                             :class="getPasswordStrength() >= 2 ? 'bg-orange-500' : ''"></div>
                                        <div class="h-1 flex-1 bg-gray-200 rounded"
                                             :class="getPasswordStrength() >= 3 ? 'bg-yellow-500' : ''"></div>
                                        <div class="h-1 flex-1 bg-gray-200 rounded"
                                             :class="getPasswordStrength() >= 4 ? 'bg-green-500' : ''"></div>
                                    </div>
                                    <p class="text-xs mt-1" :class="getPasswordStrengthText().color" x-text="getPasswordStrengthText().text"></p>
                                </div>

                                <!-- Requirements Checklist -->
                                <div class="mt-3 space-y-1">
                                    <div class="flex items-center text-xs" :class="formData.password.length >= 8 ? 'text-green-600' : 'text-gray-400'">
                                        <i :class="formData.password.length >= 8 ? 'fas fa-check' : 'fas fa-times'" class="mr-2"></i>
                                        Minimal 8 karakter
                                    </div>
                                    <div class="flex items-center text-xs" :class="hasUppercase(formData.password) ? 'text-green-600' : 'text-gray-400'">
                                        <i :class="hasUppercase(formData.password) ? 'fas fa-check' : 'fas fa-times'" class="mr-2"></i>
                                        Huruf besar (A-Z)
                                    </div>
                                    <div class="flex items-center text-xs" :class="hasLowercase(formData.password) ? 'text-green-600' : 'text-gray-400'">
                                        <i :class="hasLowercase(formData.password) ? 'fas fa-check' : 'fas fa-times'" class="mr-2"></i>
                                        Huruf kecil (a-z)
                                    </div>
                                    <div class="flex items-center text-xs" :class="hasNumber(formData.password) ? 'text-green-600' : 'text-gray-400'">
                                        <i :class="hasNumber(formData.password) ? 'fas fa-check' : 'fas fa-times'" class="mr-2"></i>
                                        Angka (0-9)
                                    </div>
                                    <div class="flex items-center text-xs" :class="hasSpecialChar(formData.password) ? 'text-green-600' : 'text-gray-400'">
                                        <i :class="hasSpecialChar(formData.password) ? 'fas fa-check' : 'fas fa-times'" class="mr-2"></i>
                                        Simbol (@, #, $, dll)
                                    </div>
                                </div>
        </div>

        <!-- Confirm Password -->
        <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-lock mr-2 text-primary-500"></i>Konfirmasi Password *
                                </label>
                                <div class="relative">
                                    <input :type="showConfirmPassword ? 'text' : 'password'" x-model="formData.password_confirmation" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                           placeholder="Ketik ulang password">
                                    <button type="button" @click="showConfirmPassword = !showConfirmPassword"
                                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                                        <i :class="showConfirmPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                                    </button>
        </div>

                                <!-- Match Indicator -->
                                <div x-show="formData.password_confirmation" class="mt-2 flex items-center">
                                    <i :class="formData.password === formData.password_confirmation ? 'fas fa-check-circle text-green-500' : 'fas fa-times-circle text-red-500'" class="mr-2"></i>
                                    <span :class="formData.password === formData.password_confirmation ? 'text-green-600' : 'text-red-600'" class="text-sm">
                                        <span x-show="formData.password === formData.password_confirmation">Password cocok</span>
                                        <span x-show="formData.password !== formData.password_confirmation">Password tidak cocok</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 5: Verifikasi & Persetujuan -->
                    <div x-show="currentStep === 5" class="space-y-6">
                        <div class="text-center mb-8">
                            <h2 class="text-2xl font-bold text-primary-500 mb-2">Verifikasi & Persetujuan</h2>
                            <p class="text-gray-600">Langkah terakhir sebelum menyelesaikan pendaftaran</p>
                        </div>

                        <!-- Review Section -->
                        <div class="bg-gray-50 rounded-xl p-6 mb-8">
                            <h3 class="font-semibold text-lg mb-4">Ringkasan Data Pendaftaran</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <span class="text-sm text-gray-600 font-medium">Tipe Registrasi:</span>
                                    <p class="text-base text-gray-900" x-text="formData.registration_type === 'student' ? 'Siswa' : 'Orang Tua/Wali'"></p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-600 font-medium">Nama Lengkap:</span>
                                    <p class="text-base text-gray-900" x-text="formData.full_name"></p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-600 font-medium">Email:</span>
                                    <p class="text-base text-gray-900" x-text="formData.email"></p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-600 font-medium">No. Telepon:</span>
                                    <p class="text-base text-gray-900" x-text="formData.phone"></p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-600 font-medium">Tanggal Lahir:</span>
                                    <p class="text-base text-gray-900" x-text="formData.birth_date ? formatDate(formData.birth_date) + ' (' + calculateAge(formData.birth_date) + ' tahun)' : '-'"></p>
                                </div>
        <div>
                                    <span class="text-sm text-gray-600 font-medium">Alamat:</span>
                                    <p class="text-base text-gray-900" x-text="formData.address"></p>
                                </div>
                            </div>
                        </div>

                        <!-- Email Verification -->
                        <div class="bg-white border-2 border-primary-500 rounded-xl p-6 mb-6">
                            <div class="flex items-center mb-4">
                                <i class="fas fa-envelope text-2xl text-primary-500 mr-3"></i>
                                <h4 class="font-semibold text-lg">Verifikasi Email</h4>
                            </div>
                            <p class="text-gray-600 mb-4">Kami akan mengirim kode verifikasi ke email Anda:</p>
                            <p class="text-lg font-bold text-primary-500 mb-4" x-text="formData.email"></p>
                            <div class="flex items-center">
                                <input type="checkbox" id="send_email_verification" checked
                                       class="w-5 h-5 text-primary-600 rounded focus:ring-primary-500">
                                <label for="send_email_verification" class="ml-2 text-sm text-gray-700">
                                    Kirim kode verifikasi ke email saya
                                </label>
                            </div>
                            <p class="text-sm text-gray-600 mt-2">Kode verifikasi akan dikirim setelah Anda klik Daftar</p>
                        </div>

                        <!-- Terms & Conditions -->
                        <div class="space-y-4">
                            <!-- Terms of Service -->
                            <div class="flex items-start space-x-3 p-4 border border-gray-300 rounded-lg">
                                <input type="checkbox" name="agreed_to_terms" id="agreed_to_terms" required
                                       class="w-5 h-5 text-primary-600 rounded focus:ring-primary-500 mt-1">
                                <label for="agreed_to_terms" class="text-sm text-gray-700">
                                    Saya telah membaca dan menyetujui 
                                    <a href="/terms" target="_blank" class="text-primary-600 hover:underline font-semibold">
                                        Syarat dan Ketentuan
                                    </a> 
                                    yang berlaku
                                    <span class="text-red-500">*</span>
                                </label>
        </div>

                            <!-- Privacy Policy -->
                            <div class="flex items-start space-x-3 p-4 border border-gray-300 rounded-lg">
                                <input type="checkbox" name="agreed_to_privacy" id="agreed_to_privacy" required
                                       class="w-5 h-5 text-primary-600 rounded focus:ring-primary-500 mt-1">
                                <label for="agreed_to_privacy" class="text-sm text-gray-700">
                                    Saya telah membaca dan menyetujui 
                                    <a href="/privacy" target="_blank" class="text-primary-600 hover:underline font-semibold">
                                        Kebijakan Privasi
                                    </a>
                                    <span class="text-red-500">*</span>
                                </label>
                            </div>

                            <!-- Newsletter (Optional) -->
                            <div class="flex items-start space-x-3 p-4 border border-gray-300 rounded-lg">
                                <input type="checkbox" name="subscribe_newsletter" id="subscribe_newsletter"
                                       class="w-5 h-5 text-primary-600 rounded focus:ring-primary-500 mt-1">
                                <label for="subscribe_newsletter" class="text-sm text-gray-700">
                                    Saya ingin menerima informasi dan update terbaru melalui email
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="flex justify-between items-center pt-8 border-t border-gray-200">
                        <button type="button" @click="previousStep()" 
                                x-show="currentStep > 1"
                                class="flex items-center px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-lg hover:border-gray-400 transition-colors duration-200">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali
                        </button>
                        <div x-show="currentStep === 1" class="w-full"></div>

                        <button type="button" @click="nextStep()" 
                                x-show="currentStep < 5"
                                class="ml-auto flex items-center px-8 py-3 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors duration-200 font-semibold">
                            Selanjutnya
                            <i class="fas fa-arrow-right ml-2"></i>
                        </button>

                        <button type="submit" 
                                x-show="currentStep === 5"
                                class="ml-auto flex items-center px-8 py-3 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors duration-200 font-semibold">
                            <i class="fas fa-user-plus mr-2"></i>
                            Daftar Sekarang
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('registrationForm', () => ({
                currentStep: 1,
                showPassword: false,
                showConfirmPassword: false,
                steps: [
                    { name: 'Pilih Tipe' },
                    { name: 'Data Pribadi' },
                    { name: 'Data Tambahan' },
                    { name: 'Keamanan' },
                    { name: 'Verifikasi' }
                ],
                formData: {
                    registration_type: '',
                    full_name: '',
                    email: '',
                    phone: '',
                    nik: '',
                    birth_place: '',
                    birth_date: '',
                    gender: '',
                    address: '',
                    city: '',
                    province: '',
                    postal_code: '',
                    school_origin: '',
                    last_education: '',
                    graduation_year: '',
                    nisn: '',
                    relation_type: '',
                    occupation: '',
                    student_name: '',
                    student_nis: '',
                    password: '',
                    password_confirmation: ''
                },

                nextStep() {
                    if (this.validateCurrentStep()) {
                        this.currentStep++;
                    }
                },

                previousStep() {
                    if (this.currentStep > 1) {
                        this.currentStep--;
                    }
                },

                validateCurrentStep() {
                    switch (this.currentStep) {
                        case 1:
                            return this.formData.registration_type !== '';
                        case 2:
                            return this.formData.full_name && this.formData.email && this.formData.phone && 
                                   this.formData.birth_date && this.formData.gender && this.formData.address && 
                                   this.formData.city && this.formData.province;
                        case 3:
                            if (this.formData.registration_type === 'student') {
                                return this.formData.school_origin && this.formData.last_education && this.formData.graduation_year;
                            } else if (this.formData.registration_type === 'parent') {
                                return this.formData.relation_type && this.formData.occupation && this.formData.student_name;
                            }
                            return true;
                        case 4:
                            return this.formData.password && this.formData.password_confirmation && 
                                   this.formData.password === this.formData.password_confirmation;
                        case 5:
                            return document.getElementById('agreed_to_terms').checked && 
                                   document.getElementById('agreed_to_privacy').checked;
                        default:
                            return true;
                    }
                },

                submitForm() {
                    if (this.validateCurrentStep()) {
                        // Submit form via AJAX
                        fetch('/register', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify(this.formData)
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                window.location.href = data.redirect_url;
                            } else {
                                alert(data.message || 'Terjadi kesalahan saat mendaftar.');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Terjadi kesalahan saat mendaftar.');
                        });
                    }
                },

                isValidEmail(email) {
                    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    return re.test(email);
                },

                calculateAge(birthDate) {
                    if (!birthDate) return 0;
                    const today = new Date();
                    const birth = new Date(birthDate);
                    let age = today.getFullYear() - birth.getFullYear();
                    const monthDiff = today.getMonth() - birth.getMonth();
                    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birth.getDate())) {
                        age--;
                    }
                    return age;
                },

                formatDate(dateString) {
                    if (!dateString) return '';
                    const date = new Date(dateString);
                    return date.toLocaleDateString('id-ID', {
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric'
                    });
                },

                getYears() {
                    const currentYear = new Date().getFullYear();
                    const years = [];
                    for (let i = currentYear; i >= currentYear - 10; i--) {
                        years.push(i);
                    }
                    return years;
                },

                getPasswordStrength() {
                    let strength = 0;
                    const password = this.formData.password;
                    
                    if (password.length >= 8) strength++;
                    if (this.hasUppercase(password)) strength++;
                    if (this.hasLowercase(password)) strength++;
                    if (this.hasNumber(password)) strength++;
                    if (this.hasSpecialChar(password)) strength++;
                    
                    return strength;
                },

                getPasswordStrengthText() {
                    const strength = this.getPasswordStrength();
                    if (strength <= 1) return { text: 'Lemah', color: 'text-red-600' };
                    if (strength <= 2) return { text: 'Cukup', color: 'text-orange-600' };
                    if (strength <= 3) return { text: 'Baik', color: 'text-yellow-600' };
                    return { text: 'Kuat', color: 'text-green-600' };
                },

                hasUppercase(str) {
                    return /[A-Z]/.test(str);
                },

                hasLowercase(str) {
                    return /[a-z]/.test(str);
                },

                hasNumber(str) {
                    return /[0-9]/.test(str);
                },

                hasSpecialChar(str) {
                    return /[!@#$%^&*(),.?":{}|<>]/.test(str);
                }
            }));
        });
    </script>
</body>
</html>