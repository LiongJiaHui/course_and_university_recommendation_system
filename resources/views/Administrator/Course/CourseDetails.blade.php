<head>
    <title>Course and University Recommendation System: Details of the Course</title>
    <link rel="stylesheet" href="{{ asset('css/admin_details.css') }}">

</head>

<body>
    <x-header title="Course Detail"/>
    <div>

        <div>
            <div>
                <h3>Showing Course ID: {{ $course->id }}</h3>
            </div>

            <div>
                <table>
                    <tr>
                        <td>Course ID: </td>
                        <td>{{ $course->id }}</td>
                    </tr>

                    <tr>
                        <td>Course Honour Name: </td>
                        <td>{{ $course->course_honour_name }}</td>
                    </tr>

                    <tr>
                        <td>Tuition Fees: </td>
                        <td>{{ $course->tuition_fees }}</td>
                    </tr>

                    <tr>
                        <td>Credit Hours: </td>
                        <td>{{ $course->credit_hours }}</td>
                    </tr>

                    <tr>
                        <td>Duration: </td>
                        <td>{{ $course->duration }}</td>
                    </tr>

                    <tr>
                        <td>Minimum Grade: </td>
                        <td>{{ $course->minimum_grade }}</td>
                    </tr>

                    <tr>
                        <td>Specific Subjects: </td>
                        <td>{{ $course->specific_subjects }}</td>
                    </tr>

                    <tr>
                        <td>Merit Mark: </td>
                        <td>{{ $course->merit_mark }}</td>
                    </tr>

                    <tr>
                        <td>English Requirement Skill (MUET marks):</td>
                        <td>{{ $course->english_requirement_skill }}</td>
                    </tr>

                    <tr>
                        <td>Ranking QS By Subject: </td>
                        <td>
                            @if($course->ranking_qs_no_start_by_subject && !$course->ranking_qs_no_end_by_subject )
                                {{ $course->ranking_qs_no_start_by_subject }} ({{ $course->ranking_qs_year_by_subject }})
                            @elseif($course->ranking_qs_no_end_by_subject &&$course->ranking_qs_no_start_by_subject)
                                {{ $course->ranking_qs_no_start_by_subject }} to {{ $course->ranking_qs_no_end_by_subject }} ({{ $course->ranking_qs_year_by_subject }})
                            @else 
                                None
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <td>Ranking THE By Subject: </td>
                        <td>
                            @if($course->ranking_the_no_start_by_subject && !$course->ranking_the_no_end_by_subject )
                                {{ $course->ranking_the_no_start_by_subject }} ({{ $course->ranking_the_year_by_subject }})
                            @elseif($course->ranking_the_no_end_by_subject &&$course->ranking_the_no_start_by_subject)
                                {{ $course->ranking_the_no_start_by_subject }} to {{ $course->ranking_the_no_end_by_subject }} ({{ $course->ranking_the_year_by_subject }})
                            @else 
                                None
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <td>Course Qualification (MQA): </td>
                        <td>{{ $course->course_qualification }}</td>
                    </tr>

                    <tr>
                        <td>Course Website: </td>
                        <td>
                            <a href="{{ $course->course_website }}" target="_blank">
                                {{ $course->course_website }}
                            </a>
                        </td>
                    </tr>

                </table>
            </div>

            <!-- University section -->
            <div>
                <table>
                    <tr>
                        <td>University Name: </td>
                        <td>{{ $course->university->uni_name ?? 'N/A' }}</td>
                    </tr>

                    <tr>
                        <td>Campus: </td>
                        <td>{{ $course->university->campus ?? 'N/A' }}</td>
                    </tr>

                    <tr>
                        <td>Website: </td>
                        <td>
                            <a href="{{ $course->university->website }}" target="_blank">
                                {{ $course->university->website ?? 'N/A' }}
                            </a>
                        </td>
                    </tr>


                <!-- Admin -->
                    <tr>
                        <td>Admin: </td>
                        <td>{{ $course->admin->admin_name }}</td>
                    </tr>

                <!-- Course Category section -->
                    <tr>
                        <td>Course Category: </td>
                        <td>{{ $course->course->course_category }}</td>
                    </tr>

                    <tr>
                        <td>Course Aspect: </td>
                        <td>{{ $course->course->course_aspect }}</td>
                    </tr>

                     <tr>
                            <td>
                            </td>
                        </tr>
                </table>
            </div>
        </div>

        <div>
            <form action="{{ route('course.edit', $course->id) }}" method="POST">
                <button class="update">Update Course</button>
            </form>
        </div>

         <div id="back">
            <a href="{{ route('course.list') }}" id="back">
                <button id="back">Back</button>
            </a>
        </div>
    </div>
    <x-footer />
</body>