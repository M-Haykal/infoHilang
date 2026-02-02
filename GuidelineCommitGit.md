## <a name="commit"></a> Pedoman Commit Message

Kami memiliki aturan yang sangat tepat tentang bagaimana **pesan** git commit kami dapat diformat. Ini mengarah ke pesan yang **lebih mudah dibaca** yang mudah diikuti ketika melihat melalui history proyek. Dan juga, kami menggunakan pesan git commit untuk **menghasilkan log perubahan pada Angular**.

### Format Commit Message
Setiap pesan komit terdiri dari **header**, **konten**, dan **catatan kaki**. Judul memiliki format khusus yang mencakup **jenis**, **cakupan**, dan **subjek**:

```
<type>(<scope>): <subject>
<BLANK LINE>
<body>
<BLANK LINE>
<footer>
```

**Header** adalah wajib namun cakupan (scope) header adalah opsional.

Setiap baris pesan komit tidak boleh lebih dari 100 karakter! Ini memungkinkan pesan menjadi lebih mudah dibaca di GitHub serta di berbagai alat git.

Footer harus berisi [referensi penutup untuk issue](https://help.github.com/articles/closing-issues-via-commit-messages/) jika ada.

Contoh:
```
docs(changelog): update changelog to beta.5
```
```
fix(release): need to depend on latest rxjs and zone.js

The version in our package.json gets copied to the one we publish, and users need the latest of these.
```

### Revert (Kembali)
Jika komit mengembalikan komit sebelumnya, komit itu harus dimulai dengan `revert`: diikuti oleh header komit yang dikembalikan. Di dalam konten seharusnya berbunyi: `This reverts commit <hash>.` , di mana hash adalah SHA dari komit yang dikembalikan.

### Tipe
Harus salah satu dari yang berikut:

* **build**: Perubahan yang memengaruhi sistem build atau dependensi eksternal (contoh cakupan (scope): gulp, broccoli, npm)
* **ci**: Perubahan pada file konfigurasi dan skrip CI kami (contoh cakupan: Circle, BrowserStack, SauceLabs)
* **docs**: perubahan Dokumentasi
* **feat**: Fitur baru
* **fix**: Perbaikan bug
* **perf**: Perubahan kode yang meningkatkan kinerja
* **refactor**: Perubahan kode yang tidak memperbaiki bug atau menambahkan fitur
* **style**: Perubahan yang tidak memengaruhi makna kode (white-space, pemformatan, tidak ada titik koma, etc)
* **test**: Menambahkan tes yang hilang atau mengoreksi tes yang ada

### Cakupan (Scope)
Cakupannya haruslah nama paket `npm` yang terpengaruh (seperti yang dirasakan oleh orang yang membaca changelog yang dihasilkan dari pesan komit).

Berikut ini adalah daftar cakupan yang didukung:

* **animations**
* **common**
* **compiler**
* **compiler-cli**
* **core**
* **elements**
* **forms**
* **http**
* **language-service**
* **platform-browser**
* **platform-browser-dynamic**
* **platform-server**
* **platform-webworker**
* **platform-webworker-dynamic**
* **router**
* **service-worker**
* **upgrade**
* **zone.js**

Saat ini ada beberapa pengecualian untuk aturan "use package name":

* **packaging**: digunakan untuk perubahan yang mengubah tata letak paket npm di semua paket kami, misalnya perubahan path, perubahan package.json dilakukan untuk semua paket, perubahan file / format d.ts, perubahan ke bundel, dll.
* **changelog**: digunakan untuk memperbarui catatan rilis di CHANGELOG.md
* **docs-infra**: digunakan untuk perubahan terkait docs-app (angular.io) dalam direktori /aio repo
* **ivy**: digunakan untuk perubahan [Ivy renderer](https://github.com/angular/angular/issues/21706).
* **ngcc**: digunakan untuk perubahan [Angular Compatibility Compiler](./packages/compiler-cli/ngcc/README.md)
* none/empty string: berguna untuk perubahan `style` , `test` dan `refactor` yang dilakukan di semua paket (misalnya `style: add missing semicolons` ) dan untuk perubahan dokumen yang tidak terkait dengan paket tertentu (misalnya `docs: fix typo in tutorial` ).

### Subyek
Subjek berisi deskripsi perubahan yang singkat:

* gunakan imperatif, present tense: "change" bukan "changed" atau "changes"
* jangan menggunakan huruf besar untuk huruf pertama
* tidak ada titik (.) di akhir

### Konten
Sama seperti dalam **subjek** , gunakan imperatif, present tense: "change" bukan "changed" atau "changes". Konten harus memasukkan motivasi untuk perubahan dan membandingkannya dengan perilaku sebelumnya.

### Catatan Kaki (Footer)
Footer harus berisi informasi apa pun tentang **Melanggar Perubahan** dan juga merupakan tempat untuk merujuk masalah GitHub yang dilakukan **diakhir** pesan komit.

**Breaking Changes** harus dimulai dengan kata `BREAKING CHANGE:` dengan spasi atau dua baris baru. Sisa pesan komit kemudian digunakan untuk ini.

Penjelasan terperinci dapat ditemukan dalam [dokumen][https://github.com/angular/angular/blob/master/CONTRIBUTING.md#commit].