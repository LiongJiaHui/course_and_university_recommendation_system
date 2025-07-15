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
                    <td>
                        <form action="{{  }}" method="POST">
                            <button id="update">Update</button>
                        </form>
                    </td>
                    <td>
                            <form action="{{  }}" method="POST">
                                <button id="delete">Delete</button>
                            </form>
                        </td>
                    </tr>
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