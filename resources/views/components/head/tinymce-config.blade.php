{{--
File: resources/views/components/head/quill-config.blade.php

Komponen ini berisi semua konfigurasi untuk editor Quill.js.
Cukup panggil komponen ini di <head> pada layout utama Anda.
--}}

<!-- Quill CSS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<!-- Quill JS -->
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Initialize all Quill editors
  document.querySelectorAll('.quill-editor').forEach(function(element) {
    const textarea = element.previousElementSibling;
    
    const quill = new Quill(element, {
      theme: 'snow',
      modules: {
        toolbar: [
          [{ 'header': [1, 2, 3, false] }],
          ['bold', 'italic', 'underline', 'strike'],
          [{ 'color': [] }, { 'background': [] }],
          [{ 'align': [] }],
          [{ 'list': 'ordered'}, { 'list': 'bullet' }],
          ['blockquote', 'code-block'],
          ['link', 'image'],
          ['clean']
        ]
      },
      placeholder: 'Tulis konten di sini...',
      readOnly: false
    });
    
    // Set initial content
    if (textarea.value) {
      quill.root.innerHTML = textarea.value;
    }
    
    // Update textarea on content change
    quill.on('text-change', function() {
      textarea.value = quill.root.innerHTML;
    });
    
    // Handle image paste from clipboard
    quill.getModule('toolbar').addHandler('image', function() {
      const input = document.createElement('input');
      input.setAttribute('type', 'file');
      input.setAttribute('accept', 'image/*');
      input.click();
      
      input.onchange = function() {
        const file = input.files[0];
        if (file) {
          uploadImage(file, quill);
        }
      };
    });
    
    // Handle paste events for images
    quill.root.addEventListener('paste', function(e) {
      const clipboardData = e.clipboardData || window.clipboardData;
      const items = clipboardData.items;
      
      for (let i = 0; i < items.length; i++) {
        if (items[i].type.indexOf('image') !== -1) {
          e.preventDefault();
          const file = items[i].getAsFile();
          uploadImage(file, quill);
          break;
        }
      }
    });
  });
  
  function uploadImage(file, quill) {
    const range = quill.getSelection(true);
    const index = range ? range.index : quill.getLength();
    
    // Insert loading placeholder
    quill.insertText(index, '[Uploading image...]', 'italic', true);
    
    const formData = new FormData();
    formData.append('file', file);
    
    fetch('{{ route("admin.materials.upload-image") }}', {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      if (data.location) {
        // Remove loading text
        quill.deleteText(index, '[Uploading image...]'.length);
        // Insert actual image
        quill.insertEmbed(index, 'image', data.location);
        quill.setSelection(index + 1);
      }
    })
    .catch(error => {
      console.error('Error uploading image:', error);
      // Remove loading text on error
      quill.deleteText(index, '[Uploading image...]'.length);
      quill.insertText(index, '[Image upload failed]', 'color', 'red');
    });
  }
});
</script>
