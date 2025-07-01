{{--
File: resources/views/components/head/tinymce-config.blade.php

Komponen ini berisi semua konfigurasi untuk editor TinyMCE.
Cukup panggil komponen ini di <head> pada layout utama Anda.
--}}

<!-- 1. Script TinyMCE dengan API Key Anda -->
<script src="https://cdn.tiny.cloud/1/s8g1ywovz4xjhr19798dykj1tent5fneee0ydfku74hb88uu/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>

<!-- 2. Inisialisasi TinyMCE -->
<script>
  tinymce.init({
    // Selector ini akan menargetkan semua <textarea> dengan class="tinymce-editor"
    selector: 'textarea.tinymce-editor',
    
    // 3. Menambahkan plugin 'fullscreen' dan plugin berguna lainnya
    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount fullscreen',
    
    // 4. Menambahkan tombol 'fullscreen' ke toolbar
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | fullscreen | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
    
    // (Opsional) Mengatur tinggi default editor agar lebih luas
    height: 500,
  });
</script>
