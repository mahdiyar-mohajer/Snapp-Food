@extends('seller.layout.app')
@section('title', 'صفحه فروشنده')
@section('content')
    <div class="container mx-auto">
        <h1 class="text-3xl font-bold mb-8">Orders</h1>

        {{-- Ajax filter --}}
        <div class="mb-4">
            <label class="block mb-2">Filter by Status:</label>
            <select id="statusFilter" class="border rounded p-2">
                <option value="">All</option>
                <option value="PENDING">Pending</option>
                <option value="ACCEPT">Accepted</option>
                <option value="PREPARING">Preparing</option>
                <option value="DONE">Done</option>
            </select>
        </div>

        @foreach ($orders as $order)
            <div class="border rounded-md p-6 mb-8 order-item" data-status="{{ $order->status }}">
                <div class="flex justify-between">
                    <h2 class="text-xl font-bold mb-4 cursor-pointer toggle-items" data-order-id="{{ $order->id }}">
                        Order ID: {{ $order->id }} - {{ $order->user->name }}
                    </h2>

                    <div>
                        <form method="post" action="{{ route('orders.update', $order->id) }}" class="mb-4">
                            @csrf
                            @method('put')

                            <label class="block mb-2">Update Status:</label>

                            <select name="status" class="mr-2 px-4 py-2 bg-blue-500 text-white rounded">
                                @foreach(['PENDING', 'ACCEPT', 'PREPARING', 'DONE'] as $status)
                                    <option value="{{ $status }}" {{ $order->status === $status ? 'selected' : '' }} {{ $order->status === $status ? 'disabled' : '' }}>
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>

                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded" {{ $order->status === 'DONE' ? 'disabled' : '' }}>
                                Update
                            </button>

                            @error('status')
                            @if($order->status !== old('status'))
                                <p class="text-red-500 mt-2">{{ $message }}</p>
                            @endif
                            @enderror
                        </form>
                    </div>
                </div>

                <div class="hidden ordered-items" data-order-id="{{ $order->id }}">
                    <h3 class="text-lg font-bold mb-2">Ordered Items</h3>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Food</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unit Price</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($order->orderItems as $orderItem)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $orderItem->food->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">${{ $orderItem->price }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $orderItem->count }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">${{ $orderItem->price * $orderItem->count }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div>
                    <p class="font-bold">Total Price: ${{ $order->total_price }}</p>
                </div>
            </div>
        @endforeach
    </div>

    <script>
        $('.toggle-items').click(function () {
            const orderId = $(this).data('order-id');
            $('.ordered-items[data-order-id="' + orderId + '"]').toggleClass('hidden');
        });

        $('#statusFilter').on('change', function () {
            const selectedStatus = $(this).val();
            $('.order-item').each(function () {
                const orderStatus = $(this).data('status');
                if (selectedStatus === '' || selectedStatus === orderStatus) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
    </script>
@endsection


