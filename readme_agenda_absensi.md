# PRD — Aplikasi Agenda & Absensi QR Code (Versi dengan COP OPD di PDF)

## 1. Ringkasan Produk

Aplikasi Agenda & Absensi QR Code adalah sistem digital untuk mengelola agenda kegiatan dan mencatat kehadiran peserta menggunakan pemindaian QR Code. Sistem ini mempermudah admin dalam membuat agenda, menghasilkan QR Code unik, serta memudahkan tamu dalam melakukan absensi tanpa login. Sistem juga menghasilkan laporan rekap kehadiran dalam format PDF, dengan COP (kop surat) yang disesuaikan secara otomatis berdasarkan OPD penyelenggara.

---

## 2. Target Pengguna

**Admin OPD / Panitia**

-   Membuat agenda
-   Mengunduh & mencetak QR Code
-   Menghasilkan PDF rekap absensi dengan COP OPD
-   Melihat statistik kehadiran

**Tamu Undangan**

-   Scan QR Code
-   Mengisi form absensi
-   Memberikan tanda tangan digital

---

## 3. Tujuan Produk

-   Menghilangkan sistem absensi manual
-   Mempermudah pengelolaan agenda
-   Menyediakan laporan PDF berkualitas resmi dengan COP OPD
-   Mempercepat proses registrasi acara
-   Menyimpan data kehadiran secara rapi, akurat, dan aman

---

## 4. Fitur Utama

### 4.1 Dashboard Admin

-   Ringkasan agenda aktif dan selesai
-   Total kehadiran
-   Statistik berdasarkan OPD

### 4.2 Manajemen Agenda

-   CRUD agenda
-   Memilih OPD penyelenggara (memengaruhi COP PDF)
-   Generate QR Code otomatis
-   Detail agenda + QR Code siap cetak

### 4.3 Form Absensi (Tamu)

-   Akses tanpa login melalui QR
-   Form berisi:
    -   NIP/NIK
    -   Nama
    -   Asal daerah (dalam kota / luar kota)
    -   OPD (jika dalam kota)
    -   Instansi (jika luar kota)
    -   Tanda tangan digital
-   Submit otomatis tersimpan

### 4.4 Tanda Tangan Digital

-   Menggunakan SignaturePad
-   Disimpan sebagai file PNG di storage

### 4.5 Rekap Absensi Lengkap

Admin dapat:

-   Melihat daftar hadir
-   Memfilter berdasarkan asal daerah, OPD, instansi
-   Mengekspor ke PDF dengan format resmi

### 4.6 PDF Rekap Absensi dengan COP OPD

Setiap PDF memiliki elemen berikut:

-   Logo Pemerintah Kota
-   Logo OPD penyelenggara
-   Nama OPD
-   Alamat OPD
-   Nomor telepon OPD
-   Garis resmi kop surat
-   Detail Agenda
-   Tabel daftar hadir
-   Catatan tambahan

COP berbeda tergantung OPD yang dipilih saat admin membuat agenda.

### 4.7 Manajemen OPD

-   CRUD OPD
-   Menyimpan:
    -   Nama OPD
    -   Singkatan
    -   Alamat OPD
    -   Nomor telp
    -   Logo OPD

---

## 5. Alur Pengguna

### Admin

1. Login
2. Membuat agenda & memilih OPD
3. Cetak QR Code
4. Acara berlangsung
5. Lihat rekap
6. Export PDF dengan COP OPD

### Tamu

1. Scan QR
2. Isi absensi
3. TTD digital
4. Submit

---

## 6. Struktur Database (Final)

### tb_agenda

-   id
-   opd_id
-   name
-   slug
-   date
-   jam_mulai
-   jam_selesai
-   link_paparan
-   link_zoom
-   barcode
-   catatan
-   deleted_at
-   timestamps

### tb_absensi

-   id
-   agenda_id
-   nip_nik
-   name
-   asal_daerah
-   opd_id (nullable)
-   instansi (nullable)
-   ttd (path file)
-   deleted_at
-   timestamps

### tb_opd

-   id
-   name
-   singkatan
-   alamat
-   telp
-   logo (path file)
-   timestamps

---

## 7. Keamanan

-   Validasi QR Code terikat agenda aktif
-   CSRF protection
-   Soft delete pada seluruh tabel
-   Path file TTD aman (public or private disk)
-   Slug agenda unik

---

## 8. Teknologi

-   Laravel 12
-   Livewire 3
-   DisyUI
-   MySQL
-   Simple QrCode
-   DomPDF / SnappyPDF
-   SignaturePad

---

## 9. Non-Functional Requirements

-   Akses cepat melalui mobile
-   PDF rapi, siap print
-   Database scalable hingga 5000+ entri per agenda
-   UX sederhana untuk tamu

---

## 10. Halaman yang Dibutuhkan

### Admin

-   Dashboard
-   Agenda list
-   Add/edit agenda
-   Detail agenda + QR
-   Rekap absensi + Export PDF
-   OPD list + add/edit OPD

### Public

-   Halaman scan → form absensi
-   Halaman sukses

---

## 11. Roadmap

### Fase 1

-   CRUD agenda dan OPD
-   QR Code
-   Absensi + TTD

### Fase 2

-   Rekap + Export PDF dengan COP OPD
-   Statistik dashboard

### Fase 3

-   Integrasi WA/Email
-   Import peserta
-   Mode offline (opsional)
