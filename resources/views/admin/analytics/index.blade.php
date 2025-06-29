{{-- resources/views/admin/analytics/index.blade.php --}}
<x-app-layout>
    {{-- ... header ... --}}
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="p-6 bg-white rounded-lg shadow-sm">
                <h3 class="text-lg font-semibold">Aktivitas Siswa Teratas</h3>
                <canvas id="studentActivityChart"></canvas>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('studentActivityChart');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($studentActivity->pluck('name')) !!},
                datasets: [{
                    label: '# of Activities Answered',
                    data: {!! json_encode($studentActivity->pluck('answers_count')) !!},
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: { scales: { y: { beginAtZero: true } } }
        });
    </script>
    @endpush
</x-app-layout>