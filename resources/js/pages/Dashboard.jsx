import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head } from "@inertiajs/react";
import { Card, CardHeader, CardTitle, CardContent } from "@/components/ui/card";
import { Progress } from "@/components/ui/progress";

export default function Dashboard({ auth, chapters }) {
    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    Dashboard
                </h2>
            }
        >
            <Head title="Dashboard" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            Progres Belajar Saya
                        </div>
                    </div>

                    <div className="grid gap-6 mt-6 md:grid-cols-2 lg:grid-cols-3">
                        {chapters.map((chapter) => (
                            <Card key={chapter.id}>
                                <CardHeader>
                                    <CardTitle>{chapter.title}</CardTitle>
                                </CardHeader>
                                <CardContent>
                                    <p className="mb-2 text-sm text-muted-foreground">
                                        {chapter.activities.length} Aktivitas
                                    </p>
                                    <Progress
                                        value={chapter.progress}
                                        className="w-full"
                                    />
                                    <span className="block mt-2 text-sm font-medium">
                                        {Math.round(chapter.progress)}% Selesai
                                    </span>
                                </CardContent>
                            </Card>
                        ))}
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
