<head>
    <title>Course and University Recommendation System: Details of the Course</title>


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
                            @if($course->ranking_qs_no_start_by_subject $$ !$course->ranking_qs_no_end_by_subject )
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
                            @if($course->ranking_the_no_start_by_subject $$ !$course->ranking_the_no_end_by_subject )
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

                </table>
            </div>

            <div>
                <table>
                    <thead>
                        <th>

                        </th>
                    </thead>
                    <tbody>
                        <tr>

                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div>
            <table>
                <tbody>
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
                </tbody>
            </table>
        </div>

        <div>
            <a href="">
                <button>Back</button>
            </a>
        </div>
    </div>
    <x-footer />
</body>