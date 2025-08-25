<head>
    <title>Course and University Recommendation System: Course and University Details from recommended list</title>
    <link rel="stylesheet" href="{{ asset('css/recommendationdetails.css') }}">
</head>

<body>
    <x-header title="Course and University Details from recommended list" />
    <div>
        <!-- Show the details of the course from the RecommendationList.blade.php -->
        <div class="form">
            <div>
                <h3>The Recommended Course Details</h3>
            </div>

            <div>
                <table>
                    <tr>
                        <td>Course Name</td>
                        <td>{{ $course->course_honour_name }}</td>
                    </tr>

                    <tr>
                        <td>Total Tuition Fees</td>
                        <td>{{ $course->tuition_fees }}</td>
                    </tr>

                    <tr>
                        <td>Credit Hours</td>
                        <td>{{ $course->credit_hours }}</td>
                    </tr>

                    <tr>
                        <td>Duration</td>
                        <td>{{ $course->duration }}</td>
                    </tr>

                    <tr>
                        <td>Ranking QS By Subject</td>
                        <td>
                            @if($course->ranking_qs_no_start_by_subject &&  !$course->ranking_qs_no_end_by_subject )
                                {{ $course->ranking_qs_no_start_by_subject }} ({{ $course->ranking_qs_year_by_subject }})
                            @elseif($course->ranking_qs_no_end_by_subject &&$course->ranking_qs_no_start_by_subject)
                                {{ $course->ranking_qs_no_start_by_subject }} to {{ $course->ranking_qs_no_end_by_subject }} ({{ $course->ranking_qs_year_by_subject }})
                            @else 
                                None
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <td>Ranking THE By Subject</td>
                        <td>
                            @if($course->ranking_the_no_start_by_subject &&  !$course->ranking_the_no_end_by_subject )
                                {{ $course->ranking_the_no_start_by_subject }} ({{ $course->ranking_the_year_by_subject }})
                            @elseif($course->ranking_the_no_end_by_subject &&$course->ranking_the_no_start_by_subject)
                                {{ $course->ranking_the_no_start_by_subject }} to {{ $course->ranking_the_no_end_by_subject }} ({{ $course->ranking_the_year_by_subject }})
                            @else 
                                None
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <td>Course Qualification</td>
                        <td>{{ $course->course_qualification ? 'True' : 'False' }}</td>
                    </tr>

                    <tr>
                        <td>Course Website</td>
                        <td>
                            <a href="{{ $course->course_website }}">
                                Course Website
                            </a>
                        </td>
                    </tr>
                        
                    <tr>
                        <td>Course Category</td>
                        <td>{{ $category->course_category }}</td>
                    </tr>

                    <tr>
                        <td>Course Aspect</td>
                        <td>{{ $category->course_aspect }}</td>
                    </tr>

                </table>
            </div>
        </div>

        <!-- Show the details of the relavent university from the RecommendationList.blade.php -->
        <div class="form">
            <div>
                <h3>The Details of the Relevant University</h3>
            </div>

            <div>
                <table>
                    <tr>
                        <td>University Name</td>
                        <td>{{ $university->uni_name }}</td>
                    </tr>

                    <tr>
                        <td>University Address</td>
                        <td>{{ $university->uni_address }}</td>
                    </tr>

                    <tr>
                        <td>Campus</td>
                        <td>{{ $university->campus }}</td>
                    </tr>

                    <tr>
                        <td>University Website</td>
                        <td>
                            <a href="{{ $university->website }}">
                                University Website
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td>University Type</td>
                        <td>{{ $university->uni_type }}</td>
                    </tr>

                    <tr>
                        <td>Contact Number</td>
                        <td>{{ $university->contact_no }}</td>
                    </tr>

                    <tr>
                        <td>Email</td>
                        <td>{{ $university->email }}</td>
                    </tr>

                    <tr>
                        <td>Ranking QS</td>
                        <td>
                            @if( $university->ranking_the_no_start && !$university->ranking_the_no_end )
                                {{ $university->ranking_the_no_start }} ({{ $university->ranking_the_year }})
                            @elseif( $university->ranking_the_no_start && $university->ranking_the_no_end )
                                {{ $university->ranking_the_no_start }} to {{ $university->ranking_the_no_end }} ({{ $university->ranking_the_year }})
                            @else
                                None 
                            @endif
                        </td>
                    </tr>
                    
                    <tr>
                        <td>Ranking THE</td>
                        <td>
                            @if( $university->ranking_the_no_start && !$university->ranking_the_no_end )
                                {{ $university->ranking_the_no_start }} ({{ $university->ranking_the_year }})
                            @elseif( $university->ranking_the_no_start && $university->ranking_the_no_end )
                                {{ $university->ranking_the_no_start }} to {{ $university->ranking_the_no_end }} ({{ $university->ranking_the_year }})
                            @else
                                None 
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <td>State</td>
                        <td>{{ $state->state_name }}</td>
                    </tr>

                    <tr>
                        <td>Area</td>
                        <td>{{ $area->area_name }}</td>
                    </tr>

                    <tr>
                        <td>Postcode</td>
                        <td>{{ $area->postcode }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div>
            <a href="{{ route('recommendation.list') }}">
                <button id="back">Back</button>
            </a>
        </div>
    </div>
    <x-footer />
</body>