@extends('admin.layout.app')
@section('title', 'ادمین پنل')

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-8">
        <table class="min-w-full bg-white border divide-y divide-gray-300 rounded-lg">
            <thead>
            <tr class="bg-gray-100">
                <th class="px-6 py-3 text-xs font-medium text-gray-600 text-right uppercase">ایمیل</th>
                <th class="px-6 py-3 text-xs font-medium text-gray-600 text-right uppercase">نام</th>
                <th class="px-6 py-3 text-xs font-medium text-gray-600 text-right uppercase">تلفن</th>
                <th class="px-6 py-3 text-xs font-medium text-gray-600 text-center uppercase">وظعیت</th>
                <th class="px-6 py-3 text-xs font-medium text-gray-600 text-center uppercase">ارتقا</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-300">
            @foreach($users as $user)
                <tr>
                    <td class="px-6 py-4 text-right">{{ $user['email'] }}</td>
                    <td class="px-6 py-4 text-right">{{ $user['name'] }}</td>
                    <td class="px-6 py-4 text-right">{{ $user['phone'] }}</td>
                    <td class="px-6 py-4 text-center">
                        @if ($user->email !== 'mahdiyar@gmail.com') {{-- Add this condition --}}
                        @if ($user->status === 'active')
                            <form method="POST" action="{{ route('users.toggleStatus', $user->id) }}">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="inactive">
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                    غیر فعال
                                </button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('users.toggleStatus', $user->id) }}">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="active">
                                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                    فعال
                                </button>
                            </form>
                        @endif
                        @else
                            <span class="text-gray-500 font-bold">سوپر ادمین</span>
                        @endif

                    </td>
                    <td class="px-6 py-4 text-center">
                        @if (!$user->hasRole('admin'))
                            <form method="POST" action="{{ route('users.promoteToAdmin', $user->id) }}">
                                @csrf
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                    ترفیع به ادمین
                                </button>
                            </form>
                        @else
                            <span class="text-green-500 font-bold">ادمین</span>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $users->links('custom-pagination') }}
    </div>
@endsection
