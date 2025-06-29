{{-- resources/views/admin/activities/edit.blade.php --}}
<div x-data="{ type: '{{ old('type', $activity->type) }}' }">
    
    {{-- Selector Tipe Soal --}}
    <select name="type" x-model="type">
        <option value="multiple_choice">Pilihan Ganda</option>
        <option value="checkbox">Pilih Lebih dari Satu</option>
        <option value="essay">Esai</option>
        <option value="true_false">Benar/Salah</option>
        <option value="matching">Pencocokan</option>
        <option value="fill_in_blank">Isi Kata Kosong</option>
    </select>

    {{-- Input Pertanyaan Umum --}}
    <textarea name="question">{{ old('question', $activity->question) }}</textarea>

    {{-- Opsi untuk Pilihan Ganda & Checkbox --}}
    <div x-show="type === 'multiple_choice' || type === 'checkbox'">
        {{-- Logika untuk menambah/menghapus pilihan --}}
    </div>

    {{-- Opsi untuk Pencocokan --}}
    <div x-show="type === 'matching'">
        {{-- Logika untuk menambah/menghapus pasangan pencocokan --}}
    </div>

    {{-- Kunci Jawaban (berubah sesuai tipe) --}}
    <div x-show="type !== 'essay'">
        {{-- Input kunci jawaban dinamis --}}
    </div>
</div>