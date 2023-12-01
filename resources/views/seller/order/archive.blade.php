@extends('seller.layout.app')
@section('title', 'صفحه فروشنده')
@section('content')
    <div class="container mx-auto">
        <h1 class="text-3xl font-bold mb-8">Archived Orders</h1>
        <div>
            <label for="weekFilter">Filter by Week:</label>
            <input type="checkbox" id="weekFilter" name="week" value="1">

            <label for="monthFilter">Filter by Month:</label>
            <input type="checkbox" id="monthFilter" name="month" value="1">

            <button id="filterButton" type="button">Apply Filter</button>

        </div>

        <div class="flex">
            <div class="w-400 h-200 mb-4">
                <canvas id="ordersChart" class="w-full h-full"></canvas>
            </div>
            <div class="w-400 h-200">
                <canvas id="revenueChart" class="w-full h-full"></canvas>
            </div>
        </div>

        <form action="{{ route('orders.exportToExcel') }}" method="post" class="mb-4">
            @csrf
            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">
                Export to Excel
            </button>
        </form>

        @foreach ($archivedOrders as $archivedOrder)
            <div class="border rounded-md p-6 mb-8">
                <div class="flex justify-between mb-4">
                    <h2 class="text-xl font-bold cursor-pointer toggle-items" data-order-id="{{ $archivedOrder->id }}">
                        Order ID: {{ $archivedOrder->id }} - {{ $archivedOrder->user->name }}
                    </h2>

                    <div>
                        <p class="font-bold">Status: {{ $archivedOrder->status }}</p>
                        <p class="font-bold">Total Price: ${{ $archivedOrder->total_price }}</p>
                        <p class="font-bold">Order Date: {{ $archivedOrder->created_at->format('Y-m-d H:i:s') }}</p>
                    </div>
                </div>

                <div class="hidden ordered-items" data-order-id="{{ $archivedOrder->id }}">
                    <h3 class="text-lg font-bold mb-2">Ordered Items</h3>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Food
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Unit Price
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Quantity
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Subtotal
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($archivedOrder->orderItems as $orderItem)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $orderItem->food->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">${{ $orderItem->price }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $orderItem->count }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    ${{ $orderItem->price * $orderItem->count }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    </div>

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
    <script>
        $(document).ready(function () {
            const ctxOrders = document.getElementById('ordersChart').getContext('2d');
            const ctxRevenue = document.getElementById('revenueChart').getContext('2d');

            let weekFilter = false;
            let monthFilter = false;

            const ordersChart = new Chart(ctxOrders, { /* ... */});
            const revenueChart = new Chart(ctxRevenue, { /* ... */});

            $('#filterButton').click(function () {
                updateCharts();
            });

            $('#weekFilter').change(function () {
                weekFilter = $(this).is(':checked');
                updateCharts();
            });

            $('#monthFilter').change(function () {
                monthFilter = $(this).is(':checked');
                updateCharts();
            });

            function updateCharts() {
                $.ajax({
                    type: 'GET',
                    url: '/orders/archived',
                    data: {
                        week_filter: weekFilter,
                        month_filter: monthFilter,
                    },
                    success: function (data) {
                        ordersChart.data = data.ordersChartData;
                        revenueChart.data = data.revenueChartData;
                        ordersChart.update();
                        revenueChart.update();
                    },
                    error: function () {
                        console.error('Error fetching data');
                    }
                });
            }
        });


    </script>
@endsection
