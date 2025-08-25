<head>
    <title>Course and University Recommendation System: Recommendation List</title>
    <link rel="stylesheet" href="{{ asset('css/recommendationlist.css') }}">
</head>

<body>
    <x-header title="Recommendation List" />

    <div>
        <div>
                @foreach ($data as $row)
                    <div class="container">
                        <p class="course">Course Name: {{ $row['course_honour_name'] ?? 'N/A' }}</p>
                        <p>University: {{ $row['uni_name'] ?? 'N/A' }}</p>
                        <p>Duration: {{ $row['duration'] ?? 'N/A' }}</p>
                        <p>Tuition Fees: {{ $row['tuition_fees'] ?? 'N/A' }}</p>
                        @if(isset($row['distance']))
                            <p>
                                Distance: {{ $row['distance']  }} 
                            </p>
                        @endif
                        <div id="Details" >
                            <a href="{{ route('recommendation.details', $row['id']) }}">
                                <button id="detail">More Details</button>
                            </a>
                        </div>
                    </div>
                @endforeach
        </div>

        <div>
            <a href="studentinformation">
                <button>Back to Main Page</button>
            </a>
        </div>
    </div>

    <x-footer />
</body>