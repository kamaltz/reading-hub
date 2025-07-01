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
    // ... (metode index, create, dll. tidak perlu diubah)

    /**
     * Simpan siswa baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Tambahkan validasi untuk email
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
        ]);

        // 2. Logika generator ID siswa tetap sama
        $year = date('y');
        $lastStudent = User::where('student_id', 'like', $year.'%')->orderBy('student_id', 'desc')->first();
        
        $newNumber = 1;
        if ($lastStudent) {
            $lastIdNumber = (int)substr($lastStudent->student_id, 2);
            $newNumber = $lastIdNumber + 1;
        }
        
        $studentId = $year . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
        
        // 3. Buat user dengan email dari input form
        User::create([
            'name' => $request->name,
            'student_id' => $studentId,
            'email' => $request->email, // Menggunakan email dari form
            'password' => Hash::make('password'),
            'role' => 'student',
        ]);

        return redirect()->route('admin.students.index')->with('success', 'Siswa baru berhasil ditambahkan.');
    }

    // ... (metode lainnya seperti show, edit, update, destroy, dll.)
    
    // Pastikan metode showGenerateForm dan storeGenerated sudah ada dari langkah sebelumnya
    public function showGenerateForm()
    {
        $lastStudent = User::whereNotNull('student_id')->orderBy('student_id', 'desc')->first();
        $lastStudentId = $lastStudent ? $lastStudent->student_id : null;

        return view('admin.students.generate', compact('lastStudentId'));
    }

    public function storeGenerated(Request $request)
    {
        $request->validate([
            'count' => ['required', 'integer', 'min:1', 'max:500'],
        ]);

        $count = $request->input('count');
        $year = date('y');
        
        $lastStudent = User::where('student_id', 'like', $year . '%')->orderBy('student_id', 'desc')->first();
        $lastNumber = $lastStudent ? (int)substr($lastStudent->student_id, 2) : 0;

        for ($i = 1; $i <= $count; $i++) {
            $newNumber = $lastNumber + $i;
            $studentId = $year . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
            $email = $studentId . '@readhub.my.id';

            User::create([
                'name' => 'Siswa ' . $studentId,
                'student_id' => $studentId,
                'email' => $email,
                'password' => Hash::make('password'),
                'role' => 'student',
            ]);
        }

        return redirect()->route('admin.students.index')->with('success', $count . ' siswa baru berhasil dibuat.');
    }

    public function importForm()
    {
        return view('admin.students.import');
    }
    
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        Excel::import(new StudentImport, $request->file('file'));

        return redirect()->route('admin.students.index')->with('success', 'Data siswa berhasil diimport.');
    }
}