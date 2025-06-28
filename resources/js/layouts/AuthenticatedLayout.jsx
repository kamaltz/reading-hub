import { Link } from "@inertiajs/react";
import NavLink from "@/Components/NavLink"; // Kita akan gunakan ini untuk link sidebar
// Impor ikon jika perlu, misal: import { LayoutDashboard, BookOpen } from 'lucide-react';

export default function AuthenticatedLayout({ user, children }) {
    return (
        <div className="flex">
            {/* ====== Sidebar ====== */}
            <aside className="p-4 w-64 min-h-screen text-white bg-gray-800">
                <div className="p-4 mb-4 text-xl font-bold">Reading Hub</div>
                <nav className="space-y-2">
                    {/* Menggunakan komponen NavLink dari Breeze, atau bisa juga Link biasa */}
                    <Link
                        href={route("admin.dashboard")}
                        className={`block p-3 rounded-lg hover:bg-gray-700 ${
                            route().current("admin.dashboard")
                                ? "bg-gray-700"
                                : ""
                        }`}
                    >
                        Dashboard
                    </Link>

                    {/* Contoh link lain yang sudah Anda buat */}
                    <Link
                        href={route("admin.genres.index")}
                        className={`block p-3 rounded-lg hover:bg-gray-700 ${
                            route().current("admin.genres.index")
                                ? "bg-gray-700"
                                : ""
                        }`}
                    >
                        Manajemen Genre
                    </Link>

                    {/* Di sini Anda akan menambahkan link untuk halaman Aktivitas (React) */}
                    <Link
                        href={route("admin.activities.index")}
                        className={`block p-3 rounded-lg hover:bg-gray-700 ${
                            route().current("admin.activities.index")
                                ? "bg-gray-700"
                                : ""
                        }`}
                    >
                        Manajemen Aktivitas
                    </Link>

                    {/* ... Tambahkan link-link lain dari sidebar Blade Anda di sini ... */}
                </nav>
            </aside>

            {/* ====== Main Content ====== */}
            <div className="flex-1">
                {/* Header Utama bisa diletakkan di sini jika ada */}
                {/* Contoh header sederhana */}
                <header className="flex justify-end p-4 bg-white shadow-sm">
                    <div className="font-medium text-gray-700">{user.name}</div>
                </header>

                {/* Konten Halaman (children) */}
                <main className="p-6">{children}</main>
            </div>
        </div>
    );
}
