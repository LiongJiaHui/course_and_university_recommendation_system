<head>
    <title>Course and University Recommendation System: Administrator List</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/admin_list.css') }}">
</head>

<body>
    <x-header title="Administrator List" />
    <div>
        <div id="search">
            <form action="{{ route('admin.list') }}" method="GET" class="search">
                <input type="text" name="search" class="search" placeholder="Search Admin" value="{{ request('search') }}"></input>
                <button type="submit" class="search">Search</button>
            </form>
        </div>

        <div id="create">
            <form action="{{ route('admin.create') }}" method="GET">
                <button type="submit" class="create">New Admin</button>
            </form>
        </div>

        <div>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Admin Name</th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($admins as $admin)
                    <tr>
                        <td>{{ $admin->id }}</td>
                        <td>{{ $admin->admin_name }}</td>
                        <td>
                            <a href="{{ route('admin.show', $admin->id) }}">
                                <button class="Detail">Detail</button>
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('admin.edit', $admin->id) }}">
                                <button class="update">Update</button>
                            </a>
                        </td>
                        <td>
                            <form action="{{ route('admin.destroy',  $admin->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="delete" onclick="return confirm('Confirm to delete?');">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div id="page_number">
            {{ $admins->appends(['search' => request('search')])->links('pagination::bootstrap-4')  }}
        </div>

        <div id="back">
            <a href="/adminMenu" id="back">
                <button id="back">Back</button>
            </a>
        </div>
    </div>
    <x-footer />
</body>