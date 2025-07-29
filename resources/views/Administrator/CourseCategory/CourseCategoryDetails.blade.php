<head>
    <title>Course and University Recommendation System: Details of the Course Category</title>

</head>

<body>
    <x-header title="Course Category Detail"/>
    <div>
        <div>
            <h3>Showing Course Category ID: {{ $category->id }}</h3>
        </div>

        <div>
            <table>
                <tr>
                    <td>ID: </td>
                    <td>{{ $category->id }}</td>
                </tr>

                <tr>
                    <td>Course Category: </td>
                    <td>{{ $category->course_category }}</td>
                </tr>

                <tr>
                    <td>Course Aspect:</td>
                    <td>{{ $category->course_aspect }}</td>
                </tr>

                <tr>
                    <td>Admin: </td>
                    <td>{{ $category->admin->admin_name }} ({{ $category->admin_id }})</td>
                </tr>

                <tr>
                    <td>
                        <a href="{{ route('coursecategory.edit', $category->id) }}">
                                <button class="update" >Update</button>
                            </a>
                    </td>
                </tr>
            </table>
        </div>

        <div id="">
            <a href="{{ route('coursecategory.list') }}" id="">
                <button id="">Back</button>
            </a>
        </div>
    </div>
    <x-footer />
</body>