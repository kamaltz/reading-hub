<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class StudentImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new User([
            'name'     => $row['nama'],
            'email'    => $row['email'],
            // Password default sama dengan email, siswa bisa mengubahnya nanti
            'password' => Hash::make($row['email']),
            'role'     => 'student',
        ]);
    }

    /**
     * Tentukan aturan validasi untuk setiap baris.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'nama' => 'required|string|max:255',
            
            // 'email' => 'required|email|unique:users,email'
            // Aturan validasi untuk email, pastikan unik di tabel users
            'email' => ['required', 'email', 'unique:users,email'],
        ];
    }

    /**
     * Pesan kustom untuk validasi.
     *
     * @return array
     */
    public function customValidationMessages()
    {
        return [
            'email.unique' => 'Email :input sudah terdaftar.',
            'email.required' => 'Kolom email wajib diisi.',
            'nama.required' => 'Kolom nama wajib diisi.',
        ];
    }
}