<div class="max-w-sm m-auto">
    <canvas id="myChart"></canvas>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('myChart');


        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Decisions with Contact Info', 'Decisions without Contact Info',
                    'No Decision with Contact Info'
                ],
                datasets: [{
                    label: 'Decisions',
                    data: [4, 5, 0],
                    borderWidth: 1
                }]
            },

        });
    </script>
@endpush
