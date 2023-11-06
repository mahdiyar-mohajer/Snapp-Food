@extends('admin.layout.app')
@section('title', 'ادمین پنل')

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-8">
        <table class="min-w-full bg-white border divide-y divide-gray-300 rounded-lg">
            <thead>
            <tr class="bg-gray-100">
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">ایمیل</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">نام</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">تلفن</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">وظعیت</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-300">
            @foreach($users as $user)
                <tr>
                    <td class="px-6 py-4">{{ $user['email'] }}</td>
                    <td class="px-6 py-4">{{ $user['name'] }}</td>
                    <td class="px-6 py-4">{{ $user['phone'] }}</td>
                    <td class="px-6 py-4">
                        @if ($user->status === 'active')
                            <form method="POST" action="{{ route('users.toggleStatus', $user->id) }}">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="inactive">
                                <button type="submit"
                                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                    غیر فعال
                                </button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('users.toggleStatus', $user->id) }}">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="active">
                                <button type="submit"
                                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                    فعال
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $users->links('custom-pagination') }}
    </div>
@endsection
