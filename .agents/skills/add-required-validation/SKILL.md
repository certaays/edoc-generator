---
name: add-required-validation
description: Menambahkan validasi field wajib (required) pada form eDoc (index.html) untuk input/textarea freetext selain checkbox, field identitas pasien non-required, serta autocomplete nakes/dokter (Select2) dan TTD dengan urutan scroll top-to-bottom.
---

# ADD REQUIRED VALIDATION

Skill ini bertugas menambahkan validasi field wajib (`required`) secara konsisten pada file `index.html` eDoc (`output/index.html` atau `history-documents/<DOC_CODE>/index.html`).

---

# ATURAN CAKUPAN FIELD

## 1. Field yang Wajib (`required`)
- Semua input/textarea freetext di dalam `#formadd` (`<input type="text">`, `<input type="date">`, `<input type="time">`, `<textarea>`).
- Autocomplete nakes/dokter berbasis Select2 (`dokter_auto*`, `nakes_auto*`, `dpjp_auto*`, `dokter_spesialis_auto*`) dan komponen `<ttd-section>`.
- Field tanggal & jam pada bagian TTD (`drawer_ttd_tanggal`, `drawer_ttd_jam`).

## 2. Field yang TIDAK Diwajibkan
- Semua `<input type="checkbox">` dan `<input type="radio">`.
- Bagian **Data Identitas Pasien** header (`pasien.nama`, `pasien.kelamin`, `pasien.alamat`, `pasien.no_rm`, `pasien.tanggal_lahir`, `pasien.tempat_lahir`).
- Kontrol UI non-isian form (seperti `<input type="color">`, `<input type="range">` pada canvas drawing, dan input di dalam modal).

## 3. Field Kondisional (`:disabled`)
- Field detail atau Select2 yang hanya aktif jika checkbox tertentu dicentang (contoh: `diastema_detail`, `rs_rujukan`, `dpjp_auto1`, `dokter_spesialis_auto1`):
  - Tetap diberi `required` pada `<input>`/`<textarea>` (HTML5 `:invalid` otomatis melewati elemen `:disabled`).
  - Untuk Select2 kondisional, validasi di `saveDoc()` hanya dijalankan jika checkbox parent-nya aktif.
  - Tanda bintang `*` pada label menggunakan `v-if="<kondisi_aktif>"` agar hanya tampil saat field aktif.

---

# IMPLEMENTASI

## 1. Script: Inisialisasi State (`init_doc`)
Pastikan `data.is_submitted = false;` sudah dideklarasikan di dalam `init_doc(doc_id, data, operation)`.

## 2. Script: Validasi & Scroll Top-to-Bottom di `saveDoc()`
Letakkan validasi ini di paling atas `saveDoc()` sebelum `saveAsImageDrawer`, `combineDiagnoses`, atau `save_emr_data`:

```js
this.is_submitted = true;
const form = document.getElementById("formadd");
const filled = (v) => !!(v && String(v).trim());

// 1. Validasi native (input/textarea freetext selain checkbox & identitas pasien)
const isFormValid = form ? form.checkValidity() : true;

// 2. Validasi custom (Select2 nakes/dokter dan tanda tangan)
// Sesuaikan daftar field dengan Select2/TTD yang ada pada dokumen
const isDokterValid = filled(this.ttd_data && this.ttd_data.dokter);
// Contoh kondisional:
// const isDpjpValid = !this.checkbox_dpjp_ranap || filled(this.dpjp_ranap);

if (!isFormValid || !isDokterValid) {
    if (form) form.classList.add("was-validated");

    // Kumpulkan semua field yang bermasalah, lalu arahkan ke yang paling atas
    const candidates = [];
    const add = (box, action) => { if (box) candidates.push({ box, action }); };
    // Select2 menyembunyikan <select> aslinya, jadi scroll ke container-nya
    const s2box = (el) => $(el).next(".select2-container")[0] || el;

    if (!isDokterValid) {
        const el = document.getElementById("dokter_auto1");
        add(el && s2box(el), () => $(el).select2("open"));
    }

    // Jika ada <select required> yang sudah ditangani di atas, hindari duplikasi via id check
    const firstInvalid = form ? form.querySelector(":invalid") : null;
    if (firstInvalid) {
        add(s2box(firstInvalid), () => firstInvalid.focus({ preventScroll: true }));
    }

    candidates.sort((a, b) => a.box.getBoundingClientRect().top - b.box.getBoundingClientRect().top);
    const target = candidates[0];
    if (target) {
        target.box.scrollIntoView({ behavior: "smooth", block: "center" });
        if (target.action) setTimeout(target.action, 400);
    }
    return; // Batalkan proses simpan
}
```

> **Catatan Penting:**
> - **Jangan** memisahkan `if (firstInvalid) ... else if (!isDokterValid)` karena `querySelector(":invalid")` akan selalu mendahulukan field di bawah TTD. Mengurutkan seluruh `candidates` dengan `getBoundingClientRect().top` menjamin scroll selalu urut dari atas ke bawah.
> - **Selalu** bungkus `firstInvalid` dengan `s2box(firstInvalid)` agar `<select required>` yang disembunyikan Select2 tidak terbaca `top === 0`.

---

## 3. Style (`<style>`)
Tambahkan CSS berikut sebelum `</style>`:

```css
/* 1. Hilangkan efek border & centang hijau bawaan Bootstrap 4 agar form tetap bersih */
.was-validated .form-control:valid {
    border-color: #ced4da;
    background-image: none;
}

/* 2. Tanda bintang merah (*) otomatis untuk label TTD yang required */
.ttd-required p.mb-0::after {
    content: " *";
    color: #dc3545;
    font-weight: bold;
}

/* 3. Border merah pada Select2 & input TTD saat terjadi error validasi */
.has-ttd-error .select2-container--default .select2-selection--single,
.has-ttd-error .select2-selection,
.has-ttd-error input.form-control {
    border-color: #dc3545 !important;
}
```

---

## 4. HTML Form

### A. Input Teks / Textarea Standar
Tambahkan `<span class="text-danger">*</span>` pada label, atribut `required` pada input/textarea, dan `<div class="invalid-feedback">Field ini wajib diisi.</div>` tepat setelahnya:

```html
<div class="mb-3">
    <label for="keluhan_utama" class="form-check-label"><b>1. Keluhan Utama <span class="text-danger">*</span></b></label>
    <input id="keluhan_utama" type="text" class="form-control" v-model="vital_sign.keluhan_utama" required />
    <div class="invalid-feedback">Field ini wajib diisi.</div>
</div>
```

### B. Input Tanggal & Jam TTD (`input-group`)
Tambahkan `<span class="text-danger ml-1">*</span>` pada label Tanggal dan Jam, atribut `required`, dan pesan error dinamis di akhir `.input-group`:

```html
<div class="input-group col-md-12 mt-2">
    <div class="input-group-prepend">
        <span class="input-group-text">Tanggal <span class="text-danger ml-1">*</span></span>
    </div>
    <input id="drawer_ttd_tanggal" type="date" class="form-control" v-model="ttd_data.tanggal"
        @change="onChDateDynamic($event, 'ttd_data.tanggal_indo')" required />
    <div class="input-group-prepend">
        <span class="input-group-text">Jam <span class="text-danger ml-1">*</span></span>
    </div>
    <input id="drawer_ttd_jam" type="time" class="form-control" v-model="ttd_data.jam" required />
    <div class="invalid-feedback">
        {{ !ttd_data.tanggal && !ttd_data.jam ? 'Tanggal dan Jam wajib diisi.' : (!ttd_data.tanggal ? 'Tanggal wajib diisi.' : 'Jam wajib diisi.') }}
    </div>
</div>
```

### C. Autocomplete Nakes / Dokter & `<ttd-section>`
Bungkus `<ttd-section>` dengan class `ttd-required` dan `:class="{ 'has-ttd-error': ... }"` serta pesan error di bawahnya:

```html
<div class="col-md-6 ttd-required"
    :class="{ 'has-ttd-error': is_submitted && (!ttd_data.dokter || !ttd_data.dokter.trim()) }">
    <ttd-section mode="QRCODE" label="Dokter" select_id="dokter_auto1" name_input_type="DOKTER"
        v-model="ttd_data.dokter" path_name="ttd_data.dokter" :stroke="ttd_data.dokter_stroke"
        path_stroke="ttd_data.dokter_stroke" @update-stroke="ttd_data.dokter_stroke = $event"
        @open-ttd-modal="openTTDModalHandler" />
    <div v-if="is_submitted && (!ttd_data.dokter || !ttd_data.dokter.trim())"
        class="text-danger text-center small mt-1">
        Dokter wajib dipilih.
    </div>
</div>
```

