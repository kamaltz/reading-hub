import React, { useState } from "react";
import { Head, useForm } from "@inertiajs/react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Button } from "@/components/ui/button";
import { Card, CardContent, CardHeader } from "@/components/ui/card";
// ... import komponen lain

// Ini akan menjadi komponen terpisah untuk setiap tipe soal
const QuestionEditor = ({ question, index, onQuestionChange }) => {
    // Logika untuk menampilkan form sesuai `question.type`
    return (
        <Card className="mb-4">
            <CardHeader>
                Soal #{index + 1} - {question.type}
            </CardHeader>
            <CardContent>
                {/* Form input untuk konten soal, pilihan, jawaban benar, dll. */}
            </CardContent>
        </Card>
    );
};

export default function EditActivity({ auth, activity }) {
    const [questions, setQuestions] = useState(activity.questions);

    const addQuestion = (type) => {
        const newQuestion = {
            id: `new_${Date.now()}`, // ID sementara
            content: "",
            type: type,
            options: [],
        };
        setQuestions([...questions, newQuestion]);
    };

    const handleSave = () => {
        // Gunakan Inertia.put() untuk mengirim data 'questions'
        // ke endpoint API baru yang perlu Anda buat untuk menyimpan/memperbarui soal.
        console.log("Saving questions:", questions);
    };

    return (
        <AuthenticatedLayout user={auth.user}>
            <Head title={`Edit Aktivitas: ${activity.title}`} />
            <div className="p-4 sm:p-6 lg:p-8">
                <h1 className="mb-4 text-2xl font-bold">Editor Aktivitas</h1>

                {questions.map((q, index) => (
                    <QuestionEditor
                        key={q.id}
                        question={q}
                        index={index}
                        // Teruskan fungsi untuk memperbarui state
                    />
                ))}

                <div className="mt-4 space-x-2">
                    <Button onClick={() => addQuestion("multiple_choice")}>
                        + Pilihan Ganda
                    </Button>
                    <Button onClick={() => addQuestion("essay")}>+ Esai</Button>
                    {/* ... tombol untuk tipe soal lain */}
                </div>

                <div className="mt-8">
                    <Button onClick={handleSave} size="lg">
                        Simpan Semua Perubahan
                    </Button>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
