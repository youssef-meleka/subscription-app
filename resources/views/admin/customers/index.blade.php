<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Management</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Customer Management</h1>

        <!-- Search Form -->
        <form action="{{ route('admin.customers.index') }}" method="GET" class="mb-6">
            <div class="flex">
                <input type="text" name="search" placeholder="Search customers..." value="{{ request('search') }}" class="flex-1 p-2 border border-gray-300 rounded-l">
                <button type="submit" class="bg-blue-500 text-white p-2 rounded-r">Search</button>
            </div>
        </form>

        <!-- Customer List -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($customers as $customer)
                        <tr>
                            <td class="px-6 py-4">{{ $customer->name }}</td>
                            <td class="px-6 py-4">{{ $customer->email }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-sm rounded-full {{ $customer->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($customer->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.customers.edit', $customer->id) }}" class="text-blue-500 hover:text-blue-700">Edit</a>
                                @if ($customer->status === 'active')
                                    <form action="{{ route('admin.customers.deactivate', $customer->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-red-500 hover:text-red-700 ml-2">Deactivate</button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.customers.reactivate', $customer->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-green-500 hover:text-green-700 ml-2">Reactivate</button>
                                    </form>
                                @endif
                                <form action="{{ route('admin.customers.destroy', $customer->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 ml-2">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $customers->links() }}
        </div>
    </div>
</body>
</html>
