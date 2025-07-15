<head>
    <title>Course and University Recommendation System: Administrator List</title>

</head>

<body>
    <x-header title="Administrator List" />
    <div>
        <div id="create">
            <form action="{{ route('') }}" method="GET" class="create">
                <input type="text" name="search" class="search" placeholder="Search Admin" value="{{ request('search') }}"></input>
                <button type="submit">New Admin</button>
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
                            <a href="{{ route('') }}">
                                <button class="Detail">Detail</button>
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('') }}">
                                <button class="update">Update</button>
                            </a>
                        </td>
                        <td>
                            <form action="{{ route('') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div id="">
            <a href="" id="">
                <button id="">Back</button>
            </a>
        </div>
    </div>
    <x-footer />
</body>