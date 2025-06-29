import React from "react";
import { router, Head, Link, usePage } from "@inertiajs/react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from "@/components/ui/table";
import { Button } from "@/components/ui/button";
import { Badge } from "@/components/ui/badge";
import { PlusCircle, Edit, Trash2 } from "lucide-react";

// Komponen untuk menangani link pagination dari Laravel
const Pagination = ({ links }) => {
    return (
        <div className="flex justify-center mt-6">
            {links.map((link, index) => (
                <Link
                    key={index}
                    href={link.url || "#"}
                    preserveScroll
                    className={`px-4 py-2 mx-1 text-sm rounded-md ${
                        link.active
                            ? "bg-blue-600 text-white"
                            : "bg-white text-gray-700"
                    } ${
                        !link.url
                            ? "text-gray-400 cursor-not-allowed"
                            : "hover:bg-gray-100"
                    }`}
                    dangerouslySetInnerHTML={{ __html: link.label }}
                />
            ))}
        </div>
    );
};

export default function Index({ auth, activities }) {
    const { flash } = usePage().props;

    // Fungsi untuk menangani penghapusan aktivitas
    const handleDelete = (activity) => {
        if (
            confirm(
                `Apakah Anda yakin ingin menghapus aktivitas "${activity.title}"? Aksi ini tidak bisa dibatalkan.`
            )
        ) {
            router.delete(route("admin.activities.destroy", activity.id), {
                preserveScroll: true, // Agar halaman tidak scroll ke atas setelah aksi
            });
        }
    };

    return (
        <AuthenticatedLayout user={auth.user}>
            <Head title="Manajemen Aktivitas" />

            <div className="p-4 sm:p-6 lg:p-8">
                <div className="flex justify-between items-center mb-6">
                    <h1 className="text-2xl font-bold">Daftar Aktivitas</h1>
                    <Link href={route("admin.activities.create")}>
                        <Button>
                            <PlusCircle className="mr-2 w-4 h-4" />
                            Tambah Aktivitas
                        </Button>
                    </Link>
                </div>

                {flash.success && (
                    <div className="p-4 mb-4 text-green-800 bg-green-100 rounded-lg shadow-sm">
                        {flash.success}
                    </div>
                )}

                <div className="bg-white rounded-lg shadow-md">
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>Judul Aktivitas</TableHead>
                                <TableHead>Chapter</TableHead>
                                <TableHead>Jumlah Soal</TableHead>
                                <TableHead className="text-right">
                                    Aksi
                                </TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {activities.data.length > 0 ? (
                                activities.data.map((activity) => (
                                    <TableRow key={activity.id}>
                                        <TableCell className="font-medium">
                                            {activity.title}
                                        </TableCell>
                                        <TableCell>
                                            <Badge variant="outline">
                                                {activity.chapter.title}
                                            </Badge>
                                        </TableCell>
                                        <TableCell>
                                            {activity.questions_count} Soal
                                        </TableCell>
                                        <TableCell className="space-x-2 text-right">
                                            <Link
                                                href={route(
                                                    "admin.activities.edit",
                                                    activity.id
                                                )}
                                            >
                                                <Button
                                                    variant="outline"
                                                    size="icon"
                                                >
                                                    <Edit className="w-4 h-4" />
                                                </Button>
                                            </Link>
                                            <Button
                                                variant="destructive"
                                                size="icon"
                                                onClick={() =>
                                                    handleDelete(activity)
                                                }
                                            >
                                                <Trash2 className="w-4 h-4" />
                                            </Button>
                                        </TableCell>
                                    </TableRow>
                                ))
                            ) : (
                                <TableRow>
                                    <TableCell
                                        colSpan="4"
                                        className="py-8 text-center text-gray-500"
                                    >
                                        Belum ada aktivitas yang dibuat.
                                    </TableCell>
                                </TableRow>
                            )}
                        </TableBody>
                    </Table>
                </div>

                {/* Menampilkan komponen pagination jika ada data */}
                {activities.data.length > 0 && (
                    <Pagination links={activities.links} />
                )}
            </div>
        </AuthenticatedLayout>
    );
}
