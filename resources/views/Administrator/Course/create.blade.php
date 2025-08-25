<head>
    <title>Course and University Recommendation System: Creation of the course</title>
    <link rel="stylesheet" href="{{ asset('css/admin_create.css') }}">

</head>

<body>
    <x-header title="Creation of the Course"/>
    <div>
        <div>
        @if ($errors->any())
            <div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        </div>

        <div>
            <form action="{{ route('course.store') }}" method="POST">
                @csrf

                <div class="container">
                    <label>Course Honour Name: </label>
                    <input type="text" name="course_honour_name" required></input>
                </div>

                <div class="container">
                    <label>Total Tuition Fees: </label>
                    <input type="number" min="0" name="tuition_fees" step="0.01" required></input>
                </div>

                <div class="container">
                    <label>Credit Hour: </label>
                    <input type="number" name="credit_hours" required></input>
                </div>

                <div class="container">
                    <label>Duration: </label>
                    <input type="number" name="duration" step="0.01" required></input>
                </div>

                <div class="container">
                    <label>Minimum Grade: </label>
                    <input type="number" name="minimum_grade" step="0.01" required></input>
                </div>

                <div class="container">
                    <label>Specific Subjects: </label>
                    <input type="text" name="specific_subjects" placeholder="if multiple subjects, must have comma to distinguish"></input>
                </div>

                <div class="container">
                    <label>Merit Mark: </label>
                    <input type="number" name="merit_mark" step="0.01"></input>
                </div>

                <div class="container">
                    <label>English Requirement Skill (MUET Marks):</label>
                    <input type="number" name="english_requirement_skill" step="0.1" required></input>
                </div>

                <div class="container">
                    <label>QS Ranking By Subject: <label>
                    <input type="number" name="ranking_qs_no_start_by_subject"></input>
                    <label>to<label>
                    <input type="number" name="ranking_qs_no_end_by_subject"></input>
                    <label>( </label>
                    <input type="number" id="year" name="year" min="2000" max="2500" name="ranking_qs_year_by_subject"></input>
                    <label> )</label>
                </div>

                <div class="container">
                    <label>THE Ranking By Subject: <label>
                    <input type="number" name="ranking_the_no_start_by_subject"></input>
                    <label>to<label>
                    <input type="number" name="ranking_the_no_end_by_subject"></input>
                    <label>( </label>
                    <input type="number" id="year" name="year" min="2000" max="2500" name="ranking_the_year_by_subject"></input>
                    <label> )</label>
                </div>

                <div class="container">
                    <label>Course Qualification (MQA Certification required): </label>
                    <input type="radio" name="course_qualification" value="1">Yes</input>
                    <input type="radio" name="course_qualification" value="0">No</input>
                </div>

                <div class="container">
                    <label>Course Website: </label>
                    <input type="url" name="course_website" required></input>
                </div>

                <div class="container">
                    <label>University & Campus:</label>
                    <select name="university_id">
                        <option value="">--- Select University & Campus ---</option>
                        @foreach ($universities as $university)
                            <option value="{{ $university->id }}">
                                {{ $university->uni_name }} - {{ $university->campus }}
                            </option>
                        @endforeach
                    </select>
                </div>

                 <div class="container">
                    <label>Admin: </label>
                    <select name="admin_id">
                        <option value="">--- Select Admin ---</option>
                        @foreach ($admins as $admin)
                             <option value="{{ $admin->id }}">
                                {{ $admin->admin_name }} ({{ $admin->id }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="container">
                    <label>Course Aspect & Category: </label>
                    <select name="course_id">
                        <option value="">--- Select Course Aspect & ---</option>
                        @foreach ($categories as $category)
                             <option value="{{ $category->id }}">
                                {{ $category->course_aspect }} - {{ $category->course_category }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <button type="submit" id="submit">Create course</button>
                </div>
            </form>
        </div>
        <div>
            <a href="{{ route('course.list') }}">
                <button>Back</button>
            </a>
        </div>
    </div>
    <x-footer />
</body>