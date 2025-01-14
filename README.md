# Sambat Rakyat

**Sambat Rakyat** adalah sebuah platform pengaduan masyarakat yang dirancang untuk memudahkan warga dalam menyampaikan keluhan, masukan, atau aspirasi secara online. Dengan menggunakan teknologi modern dan antarmuka yang intuitif, Sambat Rakyat bertujuan untuk menjadi jembatan komunikasi antara masyarakat dan pihak terkait.

---

## Fitur Utama

1. **Pengaduan Masyarakat**  
   Pengguna dapat membuat laporan tentang permasalahan yang mereka hadapi di lingkungan sekitar.

2. **Sistem Login dan Keamanan**  
   Tersedia autentikasi pengguna untuk memastikan laporan hanya dibuat oleh pengguna terdaftar.

3. **Tanggapan Laporan**  
   Pihak terkait atau pengguna lain dapat memberikan tanggapan atas laporan yang dibuat.

4. **Statistik Laporan**  
   Informasi jumlah laporan total, laporan menunggu, dan laporan yang telah ditanggapi.

5. **Antarmuka Interaktif**  
   Menggunakan desain modern berbasis Tailwind CSS dan interaksi dinamis dengan JavaScript.

6. **Dukungan Media**  
   Pengguna dapat menyertakan gambar profil yang diambil langsung dari data akun mereka.

---

## Teknologi yang Digunakan

### 1. **HTML**  
   Digunakan untuk membangun struktur halaman web yang bersih dan terorganisir.

### 2. **CSS**  
   Membantu memperindah tampilan dengan penyesuaian tambahan di luar Tailwind CSS.

### 3. **Tailwind CSS**  
   Framework utility-first yang digunakan untuk membuat desain responsif dan modern dengan cepat.

### 4. **JavaScript**  
   Menyediakan interaktivitas pada platform seperti fitur upvote/downvote, toggle komentar, dan validasi form.

### 5. **PHP Native**  
   Digunakan untuk menangani logika backend, autentikasi, dan komunikasi dengan database.

### 6. **MySQL**  
   Sebagai sistem manajemen database untuk menyimpan data laporan, komentar, dan informasi pengguna.

---

## Cara Kerja

1. **Pengguna Baru:**  
   - Registrasi akun melalui halaman pendaftaran.
   - Login untuk mulai membuat laporan atau memberikan tanggapan.

2. **Membuat Laporan:**  
   - Masukkan judul, deskripsi, dan status laporan.
   - Simpan laporan yang akan langsung tercatat dalam database.

3. **Menanggapi Laporan:**  
   - Pengguna login dapat memberikan tanggapan tanpa perlu memasukkan nama karena otomatis diambil dari data akun mereka.

4. **Melihat Statistik:**  
   - Total laporan yang telah dibuat, laporan menunggu, dan laporan selesai ditampilkan pada dashboard.

---

## Keunggulan

- **Cepat dan Ringan:** Menggunakan PHP native tanpa framework besar, memastikan performa optimal.
- **Modern dan Responsif:** Tampilan menarik dan bisa digunakan di berbagai perangkat.
- **Mudah Dikustomisasi:** Kode berbasis Tailwind CSS dan JavaScript sederhana.
- **Aksesibilitas:** Desain ramah pengguna dengan antarmuka yang intuitif.

---

## Instalasi

1. Clone repository ini ke server lokal Anda:
   ```bash
   git clone https://github.com/username/sambat-rakyat.git
   ```

2. Buat database baru dengan nama `sambat_rakyat`.

3. Import file SQL yang disertakan:
   ```sql
   mysql -u root -p sambat_rakyat < database/sambat_rakyat.sql
   ```

4. Konfigurasikan file koneksi di `koneksi.php`:
   ```php
   $host = 'localhost';
   $user = 'root';
   $password = '';
   $database = 'sambat_rakyat';
   ```

5. Jalankan proyek pada server lokal Anda (misalnya, XAMPP atau WAMP).

6. Akses proyek melalui browser:
   ```
   http://localhost/sambat-rakyat
   ```

---

## Kontributor
- **Nadzare Kafah Alfatiha**  
  *H1D023014*
- **Sellyjuan Alya Rosalina**  
  *H1D023006*
- **Moreno Hilbran Glenardi**  
  *H1D023024*
- **Dimas Kendika Fazrulfalah**  
  *H1D023083*

---

## Lisensi
Proyek ini dilisensikan Mahasiswa Informatika UNSEOD.

---

Selamat menggunakan Sambat Rakyat untuk menjadikan komunikasi masyarakat lebih baik!