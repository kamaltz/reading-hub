import React from "react";
import { Head, Link, useForm } from "@inertiajs/react";
import AdminLayout from "@/Layouts/AdminLayout";
import { Button } from "@/components/ui/button";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Textarea } from "@/components/ui/textarea";

export default function Create({ auth, chapters }) {
    const { data, setData, post, processing, errors } = useForm({
        title: "",
        description: "",
        chapter_id: chapters.length > 0 ? chapters[0].id : "",
    });

    const submit = (e) => {
        e.preventDefault();
        post(route("admin.activities.store"));
    };

    return (
        <AdminLayout user={auth.user}>
            <Head title="Tambah Aktivitas Baru" />

            <div className="p-4 sm:p-6 lg:p-8">
                <Card className="mx-auto max-w-2xl">
                    <CardHeader>
                        <CardTitle>Formulir Aktivitas Baru</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <form onSubmit={submit} className="space-y-6">
                            <div>
                                <Label htmlFor="title">Judul Aktivitas</Label>
                                <Input
                                    id="title"
                                    name="title"
                                    value={data.title}
                                    onChange={(e) =>
                                        setData("title", e.target.value)
                                    }
                                    className="block mt-1 w-full"
                                    required
                                />
                                {errors.title && (
                                    <p className="mt-2 text-sm text-red-600">
                                        {errors.title}
                                    </p>
                                )}
                            </div>

                            <div>
                                <Label htmlFor="chapter_id">
                                    Pilih Chapter
                                </Label>
                                <select
                                    id="chapter_id"
                                    name="chapter_id"
                                    value={data.chapter_id}
                                    onChange={(e) =>
                                        setData("chapter_id", e.target.value)
                                    }
                                    className="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required
                                >
                                    {chapters.map((chapter) => (
                                        <option
                                            key={chapter.id}
                                            value={chapter.id}
                                        >
                                            {chapter.title}
                                        </option>
                                    ))}
                                </select>
                                {errors.chapter_id && (
                                    <p className="mt-2 text-sm text-red-600">
                                        {errors.chapter_id}
                                    </p>
                                )}
                            </div>

                            <div>
                                <Label htmlFor="description">
                                    Deskripsi (Opsional)
                                </Label>
                                <Textarea
                                    id="description"
                                    name="description"
                                    value={data.description}
                                    onChange={(e) =>
                                        setData("description", e.target.value)
                                    }
                                    className="block mt-1 w-full"
                                />
                            </div>

                            <div className="flex justify-end items-center space-x-4">
                                <Link
                                    href={route("admin.activities.index")}
                                    className="text-sm text-gray-600"
                                >
                                    Batal
                                </Link>
                                <Button type="submit" disabled={processing}>
                                    {processing
                                        ? "Menyimpan..."
                                        : "Buat & Lanjut Tambah Soal"}
                                </Button>
                            </div>
                        </form>
                    </CardContent>
                </Card>
            </div>
        </AdminLayout>
    );
}
