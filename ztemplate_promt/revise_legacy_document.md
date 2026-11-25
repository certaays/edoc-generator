# PROMPT TEMPLATE: REVISI DOKUMEN LAMA (LEGACY eDOC)

Gunakan template prompt ini saat ingin meminta AI merevisi dokumen eDoc lama menggunakan skill `revise-legacy-document`.

---

```markdown
Tolong lakukan revisi dokumen lama menggunakan skill `revise-legacy-document`.

### 1. Sumber Dokumen Lama
Folder / File Referensi: `history-documents/[NAMA_FOLDER_DOKUMEN]/`
(Pastikan ada `config.json`, `json.js`, `schema.json`, `index.html`, dan `print.php`)

---

### 2. Jalur Revisi
Pilih salah satu:
- [ ] JALUR MAYOR (Upgrade Engine & Bridging)
- [ ] JALUR MINOR (Surgical Patch)

---

### 3. Pilihan Tampilan UI (Khusus Jalur Mayor)
Pilih salah satu:
- [ ] Opsi A: Rebuild UI Baru (Modern look, patient-card, floating-nav)
- [ ] Opsi B: Keep Legacy UI (Pertahankan tata letak dan style form lama 100% via Lift & Shift)

---

### 4. Detail Permintaan Revisi / Fitur Tambahan
1. **Fitur Bridging Baru yang ingin dipasang:**
   - [Contoh: list_laboratorium / list_radiologi / vital_sign / N/A]
   - *Catatan Mapping:* Hasil simpan wajib diarahkan ke variabel JSON lama `[misal: this.data_lab]`.
2. **Penambahan Field Baru (jika ada):**
   - [Contoh: Tambah checkbox 'Edukasi Khusus' pada section penutup]
3. **Penyesuaian Print:**
   - [Contoh: Sesuaikan print.php agar menampilkan field baru / bridging baru]

---

### 5. Aturan Penting
- Pertahankan seluruh nama key pada `json.js` lama agar kompatibel dengan database pasien di SIMRS.
- Letakkan semua hasil akhir di folder `output/`.
```

