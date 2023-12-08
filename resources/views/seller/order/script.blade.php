<script>
    $('.toggle-items').click(function () {
        const orderId = $(this).data('order-id');
        $('.ordered-items[data-order-id="' + orderId + '"]').toggleClass('hidden');
    });
</script>
<script>
    $(document).ready(function () {
        const totalOrders = {!! json_encode($totalOrders) !!};
        const totalRevenue = {!! json_encode($totalRevenue) !!};

        const ctxOrders = document.getElementById('ordersChart').getContext('2d');
        const ordersChart = new Chart(ctxOrders, {
            type: 'bar',
            data: {
                labels: ['تعداد فروش'],
                datasets: [{
                    label: 'تعداد فروش',
                    data: [totalOrders],
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        const ctxRevenue = document.getElementById('revenueChart').getContext('2d');
        const revenueChart = new Chart(ctxRevenue, {
            type: 'bar',
            data: {
                labels: ['جمع فروش'],
                datasets: [{
                    label: 'جمع فروش',
                    data: [totalRevenue],
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
{{--<script>--}}
{{--    $(document).ready(function () {--}}
{{--        const ctxOrders = document.getElementById('ordersChart').getContext('2d');--}}
{{--        const ctxRevenue = document.getElementById('revenueChart').getContext('2d');--}}

{{--        let weekFilter = false;--}}
{{--        let monthFilter = false;--}}

{{--        const ordersChart = new Chart(ctxOrders, { /* ... */});--}}
{{--        const revenueChart = new Chart(ctxRevenue, { /* ... */});--}}

{{--        $('#filterButton').click(function () {--}}
{{--            updateCharts();--}}
{{--        });--}}

{{--        $('#weekFilter').change(function () {--}}
{{--            weekFilter = $(this).is(':checked');--}}
{{--            updateCharts();--}}
{{--        });--}}

{{--        $('#monthFilter').change(function () {--}}
{{--            monthFilter = $(this).is(':checked');--}}
{{--            updateCharts();--}}
{{--        });--}}

{{--        function updateCharts() {--}}
{{--            $.ajax({--}}
{{--                type: 'GET',--}}
{{--                url: '/orders/archived',--}}
{{--                data: {--}}
{{--                    week_filter: weekFilter,--}}
{{--                    month_filter: monthFilter,--}}
{{--                },--}}
{{--                success: function (data) {--}}
{{--                    ordersChart.data = data.ordersChartData;--}}
{{--                    revenueChart.data = data.revenueChartData;--}}
{{--                    ordersChart.update();--}}
{{--                    revenueChart.update();--}}
{{--                },--}}
{{--                error: function () {--}}
{{--                    console.error('Error fetching data');--}}
{{--                }--}}
{{--            });--}}
{{--        }--}}
{{--    });--}}

{{--</script>--}}

<script>
    $(document).ready(function () {
        $('#filterButton').click(function () {
            var weekFilter = $('#weekFilter').prop('checked');
            var monthFilter = $('#monthFilter').prop('checked');

            var timeFilter = '';
            if (weekFilter && monthFilter) {
                timeFilter = 'day';
            } else if (weekFilter) {
                timeFilter = 'week';
            } else if (monthFilter) {
                timeFilter = 'month';
            }

            // Make an AJAX request
            $.ajax({
                url: '{{ route("seller.orders.archived") }}',
                method: 'get',
                data: { 'time_filter': timeFilter },
                success: function (data) {
                    // Assuming data is returned with updated HTML
                    $('#archivedOrdersContainer').html(data);
                },
                error: function (error) {
                    console.error(error);
                }
            });
        });
    });
</script>
