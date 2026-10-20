# Wireframe & User Flow — SIMPUS-Mini

> **Status:** Dokumen rancangan UI/UX untuk fitur yang belum dibangun. Wireframe di bawah adalah sketsa teks, bukan implementasi HTML/CSS. Halaman yang sudah ada dari Jobsheet 1–3 tidak perlu diubah pada tahap ini.

## Tujuan dan cakupan

Dokumen ini merancang lima fitur yang akan diimplementasikan berikutnya:

1. Login Petugas
2. Dashboard Petugas
3. Peminjaman Buku
4. Pengembalian Buku
5. Riwayat Peminjaman

Wireframe menggunakan ASCII art di dalam blok kode agar struktur halaman mudah dibaca dan diubah. Rancangan sengaja tidak menentukan warna, font, atau ukuran final. Saat implementasi, tampilan mengikuti pola navbar, tipografi, aksen, tabel, dan kartu yang sudah ada di `assets/css/style.css`.

## Aktor dan otorisasi

- **Tamu:** dapat mengakses Beranda dan Daftar Buku tanpa login. Tamu tidak dapat melakukan transaksi peminjaman atau pengembalian.
- **Petugas:** harus login untuk mengakses Dashboard Petugas, Peminjaman, Pengembalian, dan Riwayat. Petugas dapat melakukan transaksi sesuai alur di dokumen ini.
- **Sesi petugas:** halaman petugas menampilkan nama petugas dan tombol Logout. Setelah logout, pengguna kembali ke halaman Login.

---

## 1. Wireframe: Login Petugas

```text
+--------------------------------------+
|              SIMPUS-Mini             |
|--------------------------------------|
|                                      |
|             Login Petugas            |
|                                      |
|  Username : [____________________]   |
|                                      |
|  Password : [____________________]   |
|                                      |
|              [ Masuk ]               |
|                                      |
|  Belum punya akun? Daftar di sini    |
|                                      |
+--------------------------------------+
```

**Elemen dan perilaku**
- Username berupa input teks.
- Password berupa input bertipe password agar karakter tidak terlihat.
- Tombol **Masuk** mengirim form login.
- Jika kredensial valid, petugas diarahkan ke Dashboard.
- Jika kredensial tidak valid atau kolom wajib kosong, tampilkan pesan kesalahan dan tetap di halaman Login.
- Tautan pendaftaran hanya ditampilkan sesuai rancangan awal; ketersediaan pendaftaran petugas perlu mengikuti kebijakan aplikasi.

### User flow: Login

```text
[Mulai]
   |
   v
[Halaman Login]
   |
   v
[Isi username dan password]
   |
   v
[Tekan "Masuk"]
   |
   v
{Kredensial valid?}
   | Ya                         | Tidak
   v                            v
[Buat sesi petugas]       [Tampilkan pesan error]
   |                            |
   v                            +----> [Kembali ke Login]
[Dashboard Petugas]
```

**Aturan alur**
- Kolom username dan password wajib diisi.
- Login gagal tidak membuka halaman petugas.
- Halaman petugas hanya bisa diakses dengan sesi login yang valid.

---

## 2. Wireframe: Dashboard Petugas

```text
+-------------------------------------------------------------------+
| SIMPUS-Mini | Beranda | Buku | Anggota | Peminjaman | (Nama Petugas) Logout |
|-------------------------------------------------------------------|
|                                                                   |
|  Dashboard Petugas                                                |
|                                                                   |
|  [ Total Buku ]    [ Total Anggota ]    [ Sedang Dipinjam ]       |
|                                                                   |
|  Aksi Cepat:                                                       |
|  [ + Peminjaman Baru ]             [ + Pengembalian ]             |
|                                                                   |
|  Transaksi Terbaru                                                 |
|  ---------------------------------------------------------------- |
|  | Anggota       | Buku             | Tgl Pinjam | Status        | |
|  |---------------|------------------|------------|---------------| |
|  | ...           | ...              | ...        | ...           | |
|  | ...           | ...              | ...        | ...           | |
|  ---------------------------------------------------------------- |
|                                                                   |
+-------------------------------------------------------------------+
```

**Elemen dan perilaku**
- Navbar meneruskan pola navigasi yang sudah ada dan menambahkan menu **Peminjaman**, identitas petugas, serta **Logout**.
- Kartu statistik menampilkan total buku, total anggota, dan jumlah peminjaman yang masih berlangsung.
- **Peminjaman Baru** membuka form peminjaman.
- **Pengembalian** membuka halaman pencarian transaksi aktif.
- Tabel Transaksi Terbaru memberi ringkasan transaksi, termasuk anggota, buku, tanggal pinjam, dan status.

### User flow: Dashboard dan navigasi petugas

```text
[Login berhasil]
      |
      v
[Dashboard Petugas]
      |
      +----> [Peminjaman Baru] ----> [Form Peminjaman]
      |
      +----> [Pengembalian] -------> [Cari Transaksi Aktif]
      |
      +----> [Riwayat] ------------> [Pilih Anggota / Lihat Riwayat]
      |
      +----> [Buku / Anggota] -----> [Halaman yang sudah tersedia]
      |
      +----> [Logout] -------------> [Hapus Sesi] -> [Login]
```

---

## 3. Wireframe: Form Peminjaman

```text
+----------------------------------------------+
| SIMPUS-Mini                                  |
|----------------------------------------------|
| Form Peminjaman Buku                         |
|----------------------------------------------|
|                                              |
| Anggota : [ dropdown pilih anggota       v ] |
|                                              |
| Buku    : [ dropdown, hanya stok > 0     v ] |
|                                              |
| Tanggal Pinjam : [ otomatis: hari ini     ]  |
|                                              |
|               [ Simpan Peminjaman ]          |
|                                              |
| [Kembali ke Dashboard]                       |
+----------------------------------------------+
```

**Elemen dan perilaku**
- Anggota dipilih dari data anggota yang tersedia.
- Pilihan buku hanya menampilkan buku dengan stok lebih dari 0.
- Tanggal pinjam terisi otomatis dengan tanggal hari ini.
- Tombol **Simpan Peminjaman** menyimpan transaksi baru.
- Jika data wajib belum dipilih atau buku sudah tidak tersedia, transaksi tidak disimpan dan pengguna mendapat pesan yang jelas.
- Setelah transaksi berhasil, stok buku berkurang 1 dan petugas kembali ke Dashboard.

### User flow: Peminjaman Buku

```text
[Petugas Login]
      |
      v
[Dashboard]
      |
      v
[Pilih "Peminjaman Baru"]
      |
      v
[Pilih Anggota]
      |
      v
[Pilih Buku dengan stok > 0]
      |
      v
[Tanggal pinjam terisi otomatis]
      |
      v
[Tekan "Simpan Peminjaman"]
      |
      v
{Data valid dan stok tersedia?}
      | Ya                              | Tidak
      v                                 v
[Simpan transaksi]               [Tampilkan pesan kesalahan]
      |                                 |
      v                                 +----> [Perbaiki pilihan]
[Stok buku berkurang 1]                         |
      |                                         +----> [Form Peminjaman]
      v
[Kembali ke Dashboard]
```

**Aturan bisnis**
- Buku dengan stok 0 tidak boleh dipilih atau dipinjam.
- Peminjaman harus terkait dengan anggota dan buku yang valid.
- Stok berkurang satu hanya setelah transaksi berhasil disimpan.

---

## 4. Wireframe: Pengembalian Buku

```text
+------------------------------------------------------+
| SIMPUS-Mini                                          |
|------------------------------------------------------|
| Pengembalian Buku                                    |
|------------------------------------------------------|
|                                                      |
| Cari transaksi aktif:                                |
| [ nama anggota / judul buku ____________________ ]   |
|                                                      |
| Transaksi yang belum dikembalikan                    |
| ---------------------------------------------------- |
| | Anggota | Buku | Tgl Pinjam | Aksi               | |
| |---------|------|------------|--------------------| |
| | ...     | ...  | ...        | [Kembalikan]       | |
| | ...     | ...  | ...        | [Kembalikan]       | |
| ---------------------------------------------------- |
|                                                      |
| [Kembali ke Dashboard]                               |
+------------------------------------------------------+
```

**Elemen dan perilaku**
- Kolom pencarian digunakan untuk mencari transaksi aktif berdasarkan nama anggota atau judul buku.
- Daftar hasil hanya memuat peminjaman yang belum dikembalikan.
- Tombol **Kembalikan** menandai transaksi terpilih sebagai sudah dikembalikan.
- Setelah pengembalian berhasil, stok buku bertambah 1 dan transaksi tidak lagi muncul sebagai transaksi aktif.
- Jika tidak ada hasil, tampilkan keterangan bahwa transaksi aktif tidak ditemukan.

### User flow: Pengembalian Buku

```text
[Petugas Login]
      |
      v
[Dashboard]
      |
      v
[Pilih menu "Pengembalian"]
      |
      v
[Cari transaksi aktif berdasarkan anggota/buku]
      |
      v
{Transaksi aktif ditemukan?}
      | Ya                              | Tidak
      v                                 v
[Tampilkan hasil transaksi]       [Tampilkan "Transaksi tidak ditemukan"]
      |                                 |
      v                                 +----> [Ubah kata kunci pencarian]
[Pilih "Kembalikan"]                         |
      |                                      +----> [Cari transaksi aktif]
      v
[Tandai transaksi sebagai dikembalikan]
      |
      v
[Stok buku bertambah 1]
      |
      v
[Perbarui daftar transaksi aktif]
      |
      v
[Kembali ke Dashboard]
```

**Aturan bisnis**
- Pengembalian dilakukan pada transaksi peminjaman yang masih aktif, bukan dengan membuat transaksi baru.
- Transaksi yang sudah dikembalikan tidak boleh diproses ulang.
- Stok bertambah satu setelah pengembalian berhasil dicatat.

---

## 5. Wireframe: Riwayat Peminjaman per Anggota

```text
+------------------------------------------------------+
| SIMPUS-Mini                                          |
|------------------------------------------------------|
| Riwayat Peminjaman                                   |
|------------------------------------------------------|
|                                                      |
| Anggota: [ dropdown pilih anggota               v ] |
|                                                      |
| Riwayat — [Nama Anggota]                             |
| ---------------------------------------------------- |
| | Buku          | Tgl Pinjam | Tgl Kembali | Status | |
| |---------------|------------|-------------|--------| |
| | Laskar Pelangi| 01/07      | 10/07       | Selesai| |
| | Bumi Manusia  | 15/07      | -           | Dipinjam| |
| ---------------------------------------------------- |
|                                                      |
| [Kembali ke Dashboard]                               |
+------------------------------------------------------+
```

**Elemen dan perilaku**
- Petugas memilih anggota untuk melihat daftar peminjaman milik anggota tersebut.
- Tabel menampilkan judul buku, tanggal pinjam, tanggal kembali, dan status.
- Tanggal kembali berisi tanda `-` jika buku belum dikembalikan.
- Status membedakan transaksi yang sudah selesai dan yang masih dipinjam.
- Jika anggota belum memiliki riwayat, tampilkan pesan bahwa belum ada data peminjaman.

### User flow: Melihat Riwayat Peminjaman

```text
[Petugas Login]
      |
      v
[Dashboard]
      |
      v
[Buka menu "Riwayat"]
      |
      v
[Pilih Anggota]
      |
      v
{Ada riwayat peminjaman?}
      | Ya                              | Tidak
      v                                 v
[Tampilkan tabel riwayat]         [Tampilkan pesan belum ada riwayat]
      |                                 |
      v                                 +----> [Pilih anggota lain]
[Lihat status dan tanggal]
      |
      v
[Kembali ke Dashboard]
```

---

## Konsistensi dengan halaman yang sudah ada

- Pertahankan pola navbar dan struktur halaman dari Jobsheet 1–3.
- Gunakan kembali `assets/css/style.css`; wireframe ini tidak menetapkan warna, font, atau ukuran final.
- Halaman yang sudah ada seperti Beranda, Daftar Buku, dan Daftar Anggota tetap dipertahankan. Dokumen ini hanya merancang fitur yang belum dibangun.
- Tampilkan identitas petugas dan tombol Logout pada halaman petugas setelah login.
- Navigasi transaksi harus konsisten: Dashboard → Peminjaman/Pengembalian/Riwayat → kembali ke Dashboard.

## Ringkasan alur utama

```text
[Login]
   |
   v
[Dashboard Petugas]
   |
   +----> [Peminjaman] ----> Validasi anggota dan stok ----> Simpan
   |                                                        |
   |                                                [Stok -1]
   |
   +----> [Pengembalian] --> Cari transaksi aktif --------> Kembalikan
   |                                                        |
   |                                                [Stok +1]
   |
   +----> [Riwayat] -------> Pilih anggota ---------------> Lihat riwayat
   |
   +----> [Logout] --------> [Login]
```

Dokumen ini merupakan rancangan awal untuk dibahas dan dirujuk saat implementasi. Validasi rinci dan aturan tambahan dapat ditetapkan ketika fitur mulai dikoding, tanpa mengubah prinsip utama alur di atas.
