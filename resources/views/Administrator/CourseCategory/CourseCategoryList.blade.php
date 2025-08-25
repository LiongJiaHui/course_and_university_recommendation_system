<head>
    <title>Course and University Recommendation System: Course Category List</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/admin_list.css') }}">
</head>

<body>
    <x-header title="Course Category List"/>
    <div>
        <div id="create">
            <form action="{{ route('coursecategory.list') }}" method="GET" class="create">
                <input type="text" name="search" class="search" placeholder="Search Course Category" value="{{ request('search') }}"></input>
                <button type="submit">Search</button>
            </form>
        </div>

         <div id="create">
            <form action="{{ route('coursecategory.create') }}" method="GET">
                <button type="submit" class="create">New Course</button>
            </form>
        </div>

        <div>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Course Category</th>
                        <th>Course Aspect</th>
                        <th>Admin</th>

                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->course_category }}</td>
                        <td>{{ $category->course_aspect }}</td>
                        <td>{{ $category->admin_id }}</td>
                        <td>
                            <a href="{{ route('coursecategory.show', $category->id) }}">
                                <button class="Detail">Detail</button>
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('coursecategory.edit', $category->id) }}">
                                <button class="update" >Update</button>
                            </a>
                        </td>
                        <td>
                            <form action="{{ route('coursecategory.destroy', $category->id) }}" method="POST">
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
            {{ $categories->appends(['search' => request('search')])->links('pagination::bootstrap-4')  }}
        </div>

        <div id="back">
            <a href="/adminMenu" id="back">
                <button id="back">Back</button>
            </a>
        </div>
    </div>
    <x-footer />
</body>