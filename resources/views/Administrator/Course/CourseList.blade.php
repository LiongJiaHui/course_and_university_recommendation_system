<head>
    <title>Course and University Recommendation System: Course List</title>
    

</head>

<body>
    <x-header title="Course List"/>
    <div>
        <div id="create">
            <form action="{{ route('') }}" method="GET" class="create">
                <input type="text" name="search" class="search" placeholder="Search Course" value="{{ request('search') }}"></input>
                <button type="submit">New Course</button>
            </form>
        </div>

        <div>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Course Honour Name</th>
                        <th>University</th>
                        <th>Ranking QS By Subject</th>
                        <th>Ranking THE By Subject</th>
                        <th>Course Website</th>
                        <th>Admin</th>

                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($courses as $course)
                    <tr>
                        <td>{{ $course->id }}</td>
                        <td>{{ $course->course_honour_name }}</td>
                        <td>{{ $course->university_id }}</td>
                        <td>
                            @if($course->ranking_qs_no_start_by_subject $$ !$course->ranking_qs_no_end_by_subject )
                                {{ $course->ranking_qs_no_start_by_subject }} ({{ $course->ranking_qs_year_by_subject }})
                            @elseif($course->ranking_qs_no_end_by_subject &&$course->ranking_qs_no_start_by_subject)
                                {{ $course->ranking_qs_no_start_by_subject }} to {{ $course->ranking_qs_no_end_by_subject }} ({{ $course->ranking_qs_year_by_subject }})
                            @else 
                                None
                            @endif
                        </td>
                        <td>
                            @if($course->ranking_the_no_start_by_subject $$ !$course->ranking_the_no_end_by_subject )
                                {{ $course->ranking_the_no_start_by_subject }} ({{ $course->ranking_the_year_by_subject }})
                            @elseif($course->ranking_the_no_end_by_subject &&$course->ranking_the_no_start_by_subject)
                                {{ $course->ranking_the_no_start_by_subject }} to {{ $course->ranking_the_no_end_by_subject }} ({{ $course->ranking_the_year_by_subject }})
                            @else 
                                None
                            @endif
                        </td>
                        <td>{{ $course->website }}</td>
                        <td>{{ $course->admin_id }}</td>
                        
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