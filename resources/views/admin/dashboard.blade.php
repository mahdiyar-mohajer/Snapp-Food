@extends('seller.layout.app')
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
                    <td class="px-6 py-4">{{ $user['status'] }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
