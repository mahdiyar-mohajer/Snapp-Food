@extends('admin.layout.app')
@section('title', 'ادمین پنل')

@section('content')
    <div class="container mx-auto mt-8">
        <h1 class="text-3xl font-semibold mb-4">Delete Requests</h1>

        @if(session('success'))
            <div class="bg-green-200 text-green-700 p-3 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full border">
            <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">Comment ID</th>
                <th class="border p-2">User</th>
                <th class="border p-2">Comment</th> <!-- Added column for comment text -->
                <th class="border p-2">Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($deleteRequests as $request)
                <tr>
                    <td class="border p-2">{{ $request->id }}</td>
                    <td class="border p-2">{{ $request->user->name }}</td>
                    <td class="border p-2">{{ $request->comment }}</td> <!-- Display the comment text -->
                    <td class="border p-2">
                        <!-- Add options for the admin to take action on the delete request -->
                        <a href="{{ route('admin.comments.approve-delete-request', ['id' => $request->id]) }}"
                           class="text-green-500 hover:underline mr-2">Approve</a>
                        <a href="{{ route('admin.comments.reject-delete-request', ['id' => $request->id]) }}"
                           class="text-red-500 hover:underline">Reject</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="border p-4 text-center">No delete requests found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
