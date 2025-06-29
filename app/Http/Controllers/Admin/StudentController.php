<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\StudentImport;
use App\Models\HotsActivity;
use App\Models\ReadingMaterial;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class StudentController extends Controller
{
    /**
     * Menampilkan daftar semua siswa dengan progress mereka.
     */
    public function index()
    {
        // Ambil total semua aktivitas yang ada di sistem
        $totalActivities = HotsActivity::count();

        // PERBAIKAN: Menggunakan withCount untuk menghindari N+1 query
        // Ini akan mengambil jumlah jawaban benar untuk setiap siswa dalam satu query efisien.
        $students = User::where('role', 'student')
            ->withCount(['answers as completed_activities_count' => function ($query) {
                $query->where('is_correct', true);
            }])
            ->latest()
            ->paginate(15); // Ganti get() dengan paginate() untuk performa

        // Loop untuk menghitung persentase progress
        foreach ($students as $student) {
            if ($totalActivities > 0) {
                $student->progress = round(($student->completed_activities_count / $totalActivities) * 100);
            } else {
                // Default 0% jika tidak ada aktivitas sama sekali
                $student->progress = 0;
            }
        }

        return view('admin.students.index', compact('students'));
    }

    /**
     * Menampilkan halaman detail untuk memonitor progres seorang siswa.
     */
    public function show(User $student)
    {
        // Pastikan hanya role siswa yang bisa diakses
        if ($student->role !== 'student') {
            abort(404);
        }

        // Ambil semua jawaban siswa, diindeks berdasarkan ID aktivitas untuk pencarian cepat di view
        $studentAnswers = $student->answers()->get()->keyBy('hots_activity_id');

        // Ambil semua materi beserta aktivitasnya
        $materials = ReadingMaterial::with('activities')->latest()->get();

        return view('admin.students.show', compact('student', 'studentAnswers', 'materials'));
    }

    /**
     * Menampilkan form untuk menambah siswa baru.
     */
    public function create()
    {
        return view('admin.students.create');
    }

    /**
     * Menyimpan siswa baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'student', // Otomatis set role sebagai siswa
        ]);

        return redirect()->route('admin.students.index')->with('success', 'Siswa baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit data siswa.
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
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class.',email,'.$student->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        $student->name = $request->name;
        $student->email = $request->email;

        // Hanya update password jika diisi
        if ($request->filled('password')) {
            $student->password = Hash::make($request->password);
        }

        $student->save();

        return redirect()->route('admin.students.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    /**
     * Menghapus siswa dari database.
     */
    public function destroy(User $student)
    {
        // Tambahkan proteksi agar tidak bisa menghapus diri sendiri atau admin lain jika logikanya diperluas
        if ($student->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $student->delete();

        return redirect()->route('admin.students.index')->with('success', 'Siswa berhasil dihapus.');
    }

    /**
     * Menampilkan form untuk import siswa dari spreadsheet.
     */
    public function importForm()
    {
        return view('admin.students.import');
    }

    /**
     * Memproses file spreadsheet untuk import siswa.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new StudentImport, $request->file('file'));
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
             $failures = $e->failures();
             $errorMessages = [];
             foreach ($failures as $failure) {
                 $errorMessages[] = 'Baris ' . $failure->row() . ': ' . implode(', ', $failure->errors());
             }
             return back()->with('error', 'Gagal mengimpor data. Silakan periksa kesalahan berikut: <br>' . implode('<br>', $errorMessages));
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat mengimpor file: ' . $e->getMessage());
        }

        return redirect()->route('admin.students.index')->with('success', 'Data siswa berhasil diimpor.');
    }

    /**
     * Menghasilkan dan mengunduh file template CSV untuk import siswa.
     */
    public function downloadTemplate()
    {
        $filename = "template_import_siswa.csv";
        $headers = ['Content-Type' => 'text/csv'];
        $content = "nama,email\nJohn Doe,john.doe@example.com\nJane Doe,jane.doe@example.com";

        return response($content, 200, $headers)->header('Content-Disposition', "attachment; filename={$filename}");
    }

    
}