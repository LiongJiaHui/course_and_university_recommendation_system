<head>
    <title>Course and University Recommendation System: Course Category List</title>
</head>

<body>
    <x-header title="Course Category List"/>
    <div>
        <div id="create">
            <form action="{{ route('') }}" method="GET" class="create">
                <input type="text" name="search" class="search" placeholder="Search Course Category" value="{{ request('search') }}"></input>
                <button type="submit">New Course Category</button>
            </form>
        </div>

        <div>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Course Category</th>
                        <th>Course Aspect</th>

                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($categories -> $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->course_category }}</td>
                        <td>{{ $category->course_aspect }}</td>
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