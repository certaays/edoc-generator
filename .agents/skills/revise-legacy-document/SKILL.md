---
name: revise-legacy-document
description: Melakukan revisi pada dokumen eDoc lama (legacy eDoc yang belum memiliki hook generator) baik melalui Jalur Mayor (upgrade engine/bridging dengan pilihan rebuild UI atau mempertahankan UI lama) maupun Jalur Minor (surgical patch) tanpa merusak kompatibilitas key JSON database SIMRS dan tetap mematuhi 100% aturan bridging-docs, templates, serta components.
---

# REVISE LEGACY EDOCUMENT

Skill ini bertugas memandu proses **revisi dokumen eDoc lama (legacy)** yang dibuat sebelum adanya sistem generator atau belum memiliki hook komentar standar (`// === [...] ===`).

Tujuan utama skill ini adalah memastikan **siapapun yang melakukan revisi dokumen lama menghasilkan struktur kode yang 100% SAMA dan KONSISTEN** dengan seseorang yang membuat dokumen dari nol menggunakan `templates/index.html`, `.agents/skills/bridging-docs/*.md`, dan `components/`.

---

## 1. ATURAN EMAS (GOLDEN RULES)

1. **DILARANG BERIMPROVISASI (Zero Improvisation Rule) — WAJIB IKUTI `bridging-docs`, `templates/`, & `components/`:**
   - Saat menambahkan atau meng-upgrade fitur (Bridging Lab, Rad, Fisio, Resep, Data Pasien, TTD, Validasi Hapus, Check All, dll.), **DILARANG KERAS** mengarang method, tombol, atau modal sendiri!
   - **WAJIB** membaca dan menyalin seluruh langkah (Step 1 s/d Step 10) secara **VERBATIM (persis tanpa dikurangi atau diubah logikanya)** dari panduan di `.agents/skills/bridging-docs/*.md`, `templates/index.html`, dan `components/`:
     - **Fungsi Bridging (`Step 8`)**: Alur filter (seperti `status_obat_pulang !== "Tidak"`), pengambilan item order (`reverse()[0]`), regex pembersih string, format output, dan penanganan `telaahResep` harus disalin persis. Jangan menulis perulangan atau penomoran kustom sendiri.
     - **Tombol Modal (`Step 10`)**: Kondisi `v-if` (misal `v-if="external_link?.fisioterapi_list_data?.length > 1"` atau `v-if="external_link?.prescription_data_list && external_link.prescription_data_list.length > 1"`), teks tombol (misal `"Pilih Hasil Fisioterapi"`), judul, dan class tombol harus disalin persis. Dilarang berasumsi mengubah logika kondisi (misal mengubah `> 1` menjadi `> 0`) atau menyederhanakan teks tombol.
   - **Satu-satunya penyesuaian yang diizinkan** pada potongan kode `bridging-docs` adalah mengganti **nama variabel target penyimpanan JSON** (contoh: mengubah `this.laboratorium_freetext = ...` menjadi `this.hal_2.diberikan_kepada.lab = ...`) agar sesuai dengan key JSON dokumen lama. Selain target variabel JSON tersebut, nama fungsi (`bridgingListLaboratorium`, `saveLab`, `setupIndexExpand`, `checkAllBridgingList`), struktur `external_link`, kondisi tombol, dan struktur HTML Modal **TIDAK BOLEH DIUBAH**.

2. **Integritas JSON (Backward-Compatibility SIMRS & No Redundant Root Keys) — HARGA MATI:**
   - Nama variabel dan key struktur data utama pada `json.js` **WAJIB DIPERTAHANKAN 100% PERSIS** dengan dokumen lama.
   - **Alasan:** Data rekam medis pasien yang sudah tersimpan di database SIMRS menggunakan key lama. Jika nama key diubah, data pasien historis akan hilang saat dokumen lama dibuka atau dicetak.
   - **Gunakan Struktur Dokumen Eksisting:** Jika dokumen lama sudah memiliki field/properti penampung data (misalnya data lab, rad, dan fis disimpan di `hal_2.diberikan_kepada.lab`, `hal_2.diberikan_kepada.rad`, `hal_2.diberikan_kepada.fis`), **DILARANG MENAMBAH KEY `*_freetext` BARU DI LEVEL ROOT** `output/json.js` maupun `output/schema.json`. Cukup arahkan target penyimpanan kode bridging langsung ke variabel eksisting tersebut.
   - Penambahan key baru hanya boleh dilakukan untuk:
     - Data dummy `external_link` sesuai Step 3 pada masing-masing `bridging-docs` (`laboratorium_data_list`, `radiologi_list_data`, `fisioterapi_list_data`, `prescription_data_list`, dll.).
     - Menyimpan properti baru yang diinstruksikan (misal: `*_stroke` untuk komponen `ttd-section` baru, atau field baru yang memang diminta eksplisit oleh user).

3. **Jangan Merusak File Sandbox / Vendor (`actual-file/` & `vendor/`):**
   - Jangan mengubah cara kerja `actual-file/index.html` atau `vendor/cutomLib.js` kecuali diminta secara eksplisit oleh user.
   - Seluruh hasil revisi ditempatkan di folder `output/` (`output/config.json`, `output/json.js`, `output/schema.json`, `output/index.html`, `output/print.php` atau `output/print.xml`).

---

## 2. POHON KEPUTUSAN: JALUR REVISI

Sebelum menulis atau mengedit kode, identifikasi jalur revisi yang diminta user:

```
                      [DOKUMEN LAMA TERSEDIA]
                                 │
                   Apakah ada upgrade arsitektur?
          (Upgrade bridging modern, perombakan sistem TTD,
                   atau standardisasi engine)
                                 │
                 ┌───────────────┴───────────────┐
                 ▼                               ▼
          [JALUR MAYOR]                   [JALUR MINOR]
       (Upgrade Engine)                 (Surgical Patch)
                 │                               │
       Pilihan Tampilan UI:                      │
      ┌──────────┴──────────┐                    │
      ▼                     ▼                    │
[OPSI A: REBUILD UI]   [OPSI B: KEEP UI]         │
(Gaya Baru Modern)    (Lift & Shift Asli)        │
      │                     │                    │
      ▼                     ▼                    ▼
   [EKSEKUSI JALUR MAYOR A]  [EKSEKUSI JALUR MAYOR B]  [EKSEKUSI JALUR MINOR]
```

---

## 3. STANDAR BAKU REPO UNTUK REVISI (WAJIB DIIKUTI)

Ketika melakukan revisi (khususnya Jalur Mayor), setiap komponen dan fitur **HARUS** mengacu pada file standar berikut:

### A. Pemasangan / Upgrade Bridging (`.agents/skills/bridging-docs/*.md`)
Setiap kali user meminta penambahan atau pembaruan tombol bridging (misal: Lab, Rad, Fisio, Resep, Diagnosa, Vital Sign):
1. **Baca file panduan yang relevan di `.agents/skills/bridging-docs/`:**
   - Lab List: `.agents/skills/bridging-docs/list_laboratorium.md`
   - Radiologi List: `.agents/skills/bridging-docs/list_radiologi.md`
   - Fisioterapi List: `.agents/skills/bridging-docs/list_fisioterapi.md`
   - Resep / Obat List: `.agents/skills/bridging-docs/list_prescription.md`
   - Data Pasien: `.agents/skills/bridging-docs/patient_data.md`
2. **Jalankan SEMUA Step (Step 1 s/d Step 10) di panduan tersebut secara berurutan:**
   - **Step 1 (`output/config.json`):** Tambahkan objek endpoint bridging persis seperti di panduan (contoh: `"laboratorium_data_list"`, `"radiologi_list_data"`, `"fisioterapi_list_data"`, `"prescription_data_list"`).
   - **Step 2 & 3 (`output/json.js`):** Pertahankan key form lama di `sample` & `default`, lalu masukkan array dummy ke dalam `sample.external_link` persis sesuai panduan agar tombol modal (`length > 1`) bisa langsung diuji.
   - **Step 4 (`// === [SETUPINDEXEXPAND_HOOK] ===`):** Masukkan pemanggilan `setupIndexExpand(...)` atau `setupIndexExpandResep(data)` sesuai panduan persis di hook sebelum inisialisasi Vue (`new Vue`). Pastikan fungsi pembantu `setupIndexExpand` memiliki guard clause (`if (!data || !external_link_name || !indexExpand) return;`). DILARANG memanggil fungsi setup ini di dalam hook `mounted()`!
   - **Step 5 (`// === [METHOD_HOOK] ===`):** Masukkan method `saveLab`, `saveRad`, `saveFis`, `navResepCollapse`, `saveResep`, dll. **Catatan Mapping:** Arahkan penyimpanan hasil akhirnya ke variabel JSON lama dokumen tersebut:
     - Contoh jika targetnya textarea string: `this.hal_2.diberikan_kepada.lab = text;`
     - Contoh jika targetnya tabel/array (seperti tabel obat `this.hal_2.pengobatan`): pada `saveResep` (dan saat `prescription_data_list.length === 1` di `bridgingResep`), selain membentuk format standar atau jika diminta auto-tambah ke tabel, masukkan (`push`) item yang dipilih (`x.selected` pada `v.order` dan `y.selected` pada `v.resep`) ke dalam array tabel lama sesuai struktur objek barisnya (misal `{ nama_obat, dosis, jam, instruksi }`).
   - **Step 6 & 7 (`// === [BRIDGING_INIT_ADD_HOOK] ===` & `// === [BRIDGING_INIT_EDIT_HOOK] ===`):** Daftarkan fungsi bridging (`bridgingListLaboratorium`, `bridgingListRadiologi`, `bridgingListFisioterapi`, `bridgingResep`) ke dalam array `executeAllSafely([...])`.
   - **Step 8 (`// === [BRIDGING_FUNCTION_HOOK] ===`):** Masukkan deklarasi fungsi `function bridgingListLaboratorium(data)`, `function bridgingResep(data)`, dll. dengan menyalin persis logika dari panduan. Hanya variabel target penyimpanan yang diarahkan ke key JSON dokumen lama. **Hapus** kode bridging gaya lama di `init_doc_add` yang sebelumnya mengisi field yang sama agar tidak bentrok/duplikat.
   - **Step 9 (`// === [BRIDGING_MODALS_HOOK] ===`):** Tempelkan HTML Modal (`#hasilLaboratoriumModal`, `#hasilRadiologiModal`, `#hasilFisModal`, `#resepModal`) **100% tanpa diubah**.
   - **Step 10 (Tombol Pemicu Modal di `<form id="formadd">`):** Gunakan tombol standar dari Step 10 panduan persis tanpa mengubah logic kondisi `v-if` maupun teks tombolnya:
     ```html
     <button
       v-if="external_link?.laboratorium_data_list?.length > 1"
       type="button"
       title="Laboratorium"
       data-toggle="modal"
       data-target="#hasilLaboratoriumModal"
       class="btn btn-info btn-sm"
     >
       Pilih Hasil Laboratorium
     </button>
     ```

### B. Kartu Identitas Pasien & Bridging Data Pasien (`templates/index.html` & `bridging-docs/patient_data.md`)
1. **Bridging Data Pasien (`bridgingPatientData`)**:
   - Di dalam `init_doc_add(data)`, selalu panggil fungsi modul standar: `bridgingPatientData(data);` alih-alih menuliskan pemetaan inline manual.
   - Di dalam fungsi `bridgingPatientData(data)`, pastikan tanggal lahir Indonesia diparsing menggunakan `dateParse(new Date(ext_patient.tanggal_lahir || ""))`.
2. **Kartu Identitas Pasien (`card_data.html`)**:
   - Jika diminta meng-update tampilan identitas pasien ke card standar:
     - Gunakan struktur `#pasien-info` dan CSS `.patient-card` dari `templates/index.html` (baris 1236–1271 & 1361–1430):
       - `<div id="pasien-info" class="card patient-card mb-4 shadow-sm">`
       - `<div class="card-header bg-light"><h5 class="mb-0">Informasi Pasien</h5></div>`
       - Layout 2 kolom (`col-md-6 border-right` dan `col-md-6`) dengan `.data-label` dan `.data-value`.
       - Pastikan `v-model` tetap mengikat ke key pasien di JSON lama (misal: `pasien.nama`, `pasien.kelamin`, `pasien.alamat`, `pasien.no_rm`, `pasien.tanggal_lahir`).

### C. Komponen Tanda Tangan Hybrid (`<ttd-section>` dari `templates/index.html`)
Jika diminta meng-upgrade tanda tangan ke standar baru (`CANVAS`, `QRCODE`, atau `HYBRID`):
- Gunakan sintaks komponen `<ttd-section>` yang ada di `templates/index.html` (baris 1451–1463) secara **persis**, lengkap dengan `v-model`, `:stroke`, dan `@update-stroke`:
  - **Mode Coretan (`mode="CANVAS"`):**
    ```html
    <ttd-section mode="CANVAS" label="Pihak Pasien" select_id="pasien_auto1" name_input_type="TEXT"
        v-model="hal_2.ttd.pihak_pasien" path_name="hal_2.ttd.pihak_pasien" :stroke="hal_2.ttd.pihak_pasien_stroke"
        path_stroke="hal_2.ttd.pihak_pasien_stroke" @update-stroke="hal_2.ttd.pihak_pasien_stroke = $event"
        @open-ttd-modal="openTTDModalHandler" />
    ```
  - **Mode QRCode (`mode="QRCODE"`):**
    ```html
    <ttd-section mode="QRCODE" label="Perawat yang menjelaskan" select_id="nakes_auto3" name_input_type="NAKES"
        v-model="hal_2.ttd.perawat" path_name="hal_2.ttd.perawat" :stroke="hal_2.ttd.perawat_stroke"
        path_stroke="hal_2.ttd.perawat_stroke" @update-stroke="hal_2.ttd.perawat_stroke = $event"
        @open-ttd-modal="openTTDModalHandler" />
    ```
- Tambahkan key `*_stroke` (misal `pihak_pasien_stroke: ""`, `perawat_stroke: ""`) ke dalam `output/json.js` (`sample` & `default`) dan `output/schema.json`.
- Hapus inisialisasi Select2 manual untuk `#nakes_auto3` di method `init` jika sudah digantikan oleh `<ttd-section select_id="nakes_auto3" name_input_type="NAKES">`, karena komponen `ttd-section` sudah menginisialisasi Select2 dan `allowClear` secara internal di `mounted()`-nya!

### D. Select2 `allowClear` (`templates/index.html` & `components/html/autocompleteToGenerateTTDImageMethod.html`)
Jika diminta menambahkan `allowClear` pada dropdown Select2 (Dokter / Nakes / Obat):
1. Tambahkan properti `allowClear: true` pada objek konfigurasi Select2 (`configDokter`, `configNakes`, `configObat`, dll.).
2. Di dalam method `init`, tambahkan event listener `select2:clearing` standar repo untuk mengosongkan model Vue saat tombol silang (`x`) diklik:
   ```javascript
   $('#dokter_auto').on('select2:clearing', function (e) {
       data.hal_2.jadwal_kontrol.dokter = "";
   });
   ```

### E. Validasi Hapus Baris Tabel (`components/js/functionDeleteValidation.js`)
Jika diminta menambahkan validasi hapus pada tabel:
- Gunakan kode **persis** dari `components/js/functionDeleteValidation.js`:
  ```javascript
  deleteRow: function (i) {
      Swal.fire({
          title: "Apa anda yakin?",
          text: "Data yang dihapus tidak dapat dikembalikan!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "red",
          cancelButtonColor: "grey",
          confirmButtonText: "Ya, hapus!"
      }).then((result) => {
          if (result.isConfirmed) {
              if (i > -1) {
                  this.nama_array.splice(i, 1);
              }
              Swal.fire({
                  icon: "success",
                  title: "Berhasil menghapus data",
                  showConfirmButton: false,
                  timer: 1000
              });
          }
      });
  },
  ```

### F. Tombol Check All Tabel & Styling Tab Navigasi (Konvensi Repo `history-documents/`)
- **Tombol Check All (Vue Reactive Computed):**
  Pada dokumen dengan tabel penilaian checklist (seperti poin 1 s/d 16 Ya/Tidak), gunakan **Vue Computed Property dengan Getter & Setter** agar kondisi tombol Check/Uncheck All selalu reaktif dan sinkron saat pengguna mencentang atau menghapus centang salah satu baris secara mandiri:
  ```javascript
  computed: {
      checkAllYa: {
          get: function () {
              const keys = ['satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas', 'duabelas', 'tigabelas', 'empatbelas', 'limabelas', 'enambelas'];
              return keys.every(k => this[k] && this[k].ya === true);
          },
          set: function (val) {
              // Ditangani melalui method toggleAllYa
          }
      }
  }
  ```
  HTML tombol:
  ```html
  <div class="text-center">
      <button type="button" class="btn btn-primary btn-sm" @click="toggleAllYa">
          <i class="fa" :class="checkAllYa ? 'fa-check-square-o' : 'fa-square-o'"></i>
          {{ checkAllYa ? 'Uncheck All' : 'Check All' }}
      </button>
  </div>
  ```
  *Catatan:* Selalu periksa penamaan key di schema JSON dokumen bersangkutan (misal memastikan apakah ejaan key menggunakan underscore atau tidak).
- **Tab Navigasi Berwarna:** Gunakan class `.nav-tabs-blue` standar repo (seperti di `Referensi Tindakan ICD 9 Tampil - ASESMEN AWAL MEDIS GIGI UMUM DAN PENYAKIT DALAM (Soelastri)/index.html`):
  ```css
  .nav-tabs-blue .nav-link.active {
      background-color: blue;
      color: #fff;
      font-weight: 500;
  }
  ```

---

## 4. PROSEDUR EKSEKUSI JALUR MAYOR (STEP-BY-STEP)

1. **Tahap 1: Persiapan `output/config.json`, `output/json.js`, & `output/schema.json`**
   - Salin `config.json` lama ke `output/config.json`, lalu tambahkan konfigurasi bridging dari Step 1 masing-masing file `bridging-docs` yang dibutuhkan.
   - Salin `json.js` lama ke `output/json.js`, pertahankan semua key lama di `sample` dan `default`, tambahkan key `*_stroke` untuk TTD baru, serta tambahkan data dummy `external_link` dari Step 3 masing-masing file `bridging-docs`.
   - Salin `schema.json` lama ke `output/schema.json` dan daftarkan field baru (seperti `*_stroke`) agar validasi schema sinkron.

2. **Tahap 2: Konstruksi `output/index.html` Berbasis `templates/index.html`**
   - Gunakan `templates/index.html` sebagai fondasi utama agar seluruh 16 hook (`// === [...] ===`), komponen `ttd-section`, modal TTD, fungsi `executeAllSafely`, `setupIndexExpand`, dan `checkAllBridgingList` tersedia secara utuh.
   - **Jika Opsi A (Rebuild UI):** Susun ulang form menggunakan skill `create-html-form` dengan tetap mengikat `v-model` ke key JSON lama.
   - **Jika Opsi B (Keep UI / Lift & Shift):**
     - Pindahkan `<style>` dan isi `<form id="formadd">` dari `index.html` lama ke dalam `output/index.html`.
     - Pindahkan custom `computed`, `methods`, dan logika `init` / `mounted` lama ke hook yang sesuai di `output/index.html`.
     - Terapkan seluruh item revisi menggunakan potongan kode standar dari `bridging-docs`, `templates/`, dan `components/` (lihat Bagian 3 di atas).

3. **Tahap 3: Penyelarasan File Cetak (`output/print.php` atau `output/print.xml`)**
   - Salin file cetak lama (`print.php` atau `print.xml`) ke folder `output/`.
   - Jika ada upgrade tanda tangan ke `ttd-section` (`*_stroke`), perbarui bagian tanda tangan pada file cetak agar menampilkan gambar coretan/QRCode dari field `*_stroke` yang baru (sebagaimana konvensi commit revisi di repo ini).

---

## 5. CHECKLIST VERIFIKASI SEBELUM SELESAI

- [ ] **Kepatuhan `bridging-docs` 100%:** Apakah semua Step 1–10 dari setiap dokumen di `.agents/skills/bridging-docs/` sudah dimasukkan secara verbatim tanpa mengubah logic alur kode (termasuk kondisi tombol modal Step 10 `length > 1` dan fungsi Step 8)?
- [ ] **Backward-Compatibility & Kebersihan JSON:** Apakah seluruh key JSON lama tetap ada dan namanya tidak berubah? Apakah tidak ada key `*_freetext` baru di root JSON jika penampung internal sudah ada?
- [ ] **Komponen TTD:** Apakah `<ttd-section>` menggunakan `v-model`, `:stroke`, dan `@update-stroke` persis sesuai `templates/index.html`?
- [ ] **Validasi Hapus & Select2:** Apakah validasi hapus memakai `components/js/functionDeleteValidation.js` dan Select2 memakai `allowClear: true` beserta listener `select2:clearing`?
- [ ] **Safeguard Setup:** Apakah pemanggilan `setupIndexExpand` berada di hook `SETUPINDEXEXPAND_HOOK` sebelum `new Vue` dan memiliki guard clause?
- [ ] **Sinkronisasi Cetak:** Apakah `output/print.php` atau `output/print.xml` sudah diselaraskan dengan field TTD/data yang diperbarui?
