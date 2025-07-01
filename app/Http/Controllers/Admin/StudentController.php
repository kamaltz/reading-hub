<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Imports\StudentImport;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    /**
     * Menampilkan daftar semua siswa dengan paginasi.
     */
    public function index()
    {
        $students = User::where('role', 'student')->latest()->paginate(15);
        return view('admin.students.index', compact('students'));
    }

    /**
     * Menampilkan formulir untuk membuat siswa baru secara manual.
     */
    public function create()
    {
        return view('admin.students.create');
    }

    /**
     * Menyimpan satu siswa baru dari formulir.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
        ]);

        // Generator ID otomatis
        $year = date('y');
        $lastStudent = User::where('student_id', 'like', $year.'%')->orderBy('student_id', 'desc')->first();
        
        $newNumber = 1;
        if ($lastStudent) {
            $lastIdNumber = (int)substr($lastStudent->student_id, 2);
            $newNumber = $lastIdNumber + 1;
        }
        
        $studentId = $year . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
        
        User::create([
            'name' => $request->name,
            'student_id' => $studentId,
            'email' => $request->email,
            'password' => Hash::make('password'),
            'role' => 'student',
        ]);

        return redirect()->route('admin.students.index')->with('success', 'Siswa baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail satu siswa.
     */
    public function show(User $student)
    {
        return view('admin.students.show', compact('student'));
    }

    /**
     * Menampilkan formulir untuk mengedit data siswa.
     */
    public function edit(User $student)
    {
        return view('admin.students.edit', compact('student'));
    }

    /**
     * Memperbarui data siswa di database.
     */
    public function update(Request $request, User $student)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($student->id)],
            'student_id' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($student->id)],
        ]);

        $student->update($request->all());

        return redirect()->route('admin.students.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    /**
     * Menghapus data siswa dari database.
     */
    public function destroy(User $student)
    {
        $student->delete();
        return redirect()->route('admin.students.index')->with('success', 'Siswa berhasil dihapus.');
    }

    /**
     * Menampilkan halaman generator akun siswa dengan rentang ID.
     */
    public function showGenerateForm()
    {
        return view('admin.students.generate');
    }

    /**
     * Membuat banyak akun siswa berdasarkan rentang ID.
     */
    public function storeGenerated(Request $request)
    {
        $validated = $request->validate([
            'id_prefix' => ['required', 'string', 'max:20'],
            'range_start' => ['required', 'integer', 'min:1'],
            'range_end' => ['required', 'integer', 'gte:range_start'],
        ]);

        $prefix = $validated['id_prefix'];
        $start = $validated['range_start'];
        $end = $validated['range_end'];
        $createdCount = 0;

        for ($i = $start; $i <= $end; $i++) {
            $paddedNumber = str_pad($i, 3, '0', STR_PAD_LEFT);
            $studentId = $prefix . $paddedNumber;
            $email = $studentId . '@readhub.my.id';

            User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => 'Siswa ' . $studentId,
                    'student_id' => $studentId,
                    'password' => Hash::make('password'),
                    'role' => 'student',
                ]
            );
            $createdCount++;
        }

        return redirect()->route('admin.students.index')->with('success', $createdCount . ' akun siswa berhasil dibuat.');
    }

    /**
     * Menampilkan halaman untuk mengunggah file import.
     */
    public function importForm()
    {
        return view('admin.students.import');
    }
    
    /**
     * Memproses file import siswa dari spreadsheet.
     */
    public function import(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls,csv']);

        try {
            Excel::import(new StudentImport, $request->file('file'));
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
             $failures = $e->failures();
             $errorMessages = [];
             foreach ($failures as $failure) {
                 $errorMessages[] = 'Baris ' . $failure->row() . ': ' . implode(', ', $failure->errors());
             }
             return back()->with('error', 'Gagal mengimpor data: <br>' . implode('<br>', $errorMessages));
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat mengimpor file: ' . $e->getMessage());
        }

        return redirect()->route('admin.students.index')->with('success', 'Data siswa berhasil diimpor.');
    }

    /**
     * Mengunduh file template untuk import.
     */
    public function downloadTemplate()
    {
        $filename = "template_import_siswa.csv";
        $headers = ['Content-Type' => 'text/csv'];
        $content = "nama,email\nJohn Doe,john.doe@example.com\nJane Smith,jane.smith@example.com";

        return response($content, 200, $headers)->header('Content-Disposition', "attachment; filename={$filename}");
    }
}