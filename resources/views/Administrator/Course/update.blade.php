<head>
    <title>Course and University Recommendation System: Update the course</title>
    <link rel="stylesheet" href="{{ asset('css/admin_create.css') }}">
</head>

<body>
    <x-header title="Update the Course" />
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
            <form action="{{ route('course.update', $course->id) }}" method="POST">
            @csrf
            @method('PUT')

                <div class="container">
                    <label>Course Honour Name: </label>
                    <input type="text" name="course_honour_name" value="{{ old('course_honour_name', $course->course_honour_name) }}"></input>
                </div>

                <div class="container">
                    <label>Total Tuition Fees: </label>
                    <input type="number" min="0" name="tuition_fees" value="{{ old('tuition_fees', $course->tuition_fees) }}"></input>
                </div>

                <div class="container">
                    <label>Credit Hour: </label>
                    <input type="number" name="credit_hours" value="{{ old('credit_hours', $course->credit_hours) }}"></input>
                </div>

                <div class="container">
                    <label>Duration: </label>
                    <input type="number" name="duration" value="{{ old('duration', $course->duration) }}"></input>
                </div>

                <div class="container">
                    <label>Minimum Grade: </label>
                    <input type="number" name="minimum_grade" value="{{ old('minimum_grade', $course->minimum_grade) }}"></input>
                </div>

                <div class="container">
                    <label>Specific Subjects: </label>
                    <input type="text" name="specific_subjects" value="{{ old('specific_subjects', $course->specific_subjects) }}"></input>
                </div>

                <div class="container" >
                    <label>Merit Mark: </label>
                    <input type="number" name="merit_mark" value="{{ old('merit_mark', $course->merit_mark) }}"></input>
                </div>

                <div class="container">
                    <label>English Requirement Skill (MUET Marks):</label>
                    <input type="number" name="english_requirement_skill" value="{{ old('english_requirement_skill', $course->english_requirement_skill) }}"></input>
                </div>

                <div class="container">
                    <label>QS Ranking By Subject: <label>
                    <input type="number" name="ranking_qs_no_start_by_subject" value="{{ old('ranking_qs_no_start_by_subject', $course->ranking_qs_no_start_by_subject) }}"></input>
                    <label>to<label>
                    <input type="number" name="ranking_qs_no_end_by_subject" value="{{ old('ranking_qs_no_end_by_subject', $course->ranking_qs_no_end_by_subject) }}"></input>
                    <label>( </label>
                    <input type="number" id="year" name="ranking_qs_year_by_subject" min="2000" max="2500" value="{{ old('ranking_qs_year_by_subject', $course->ranking_qs_year_by_subject) }}"></input>
                    <label> )</label>
                </div>

                <div class="container">
                    <label>THE Ranking By Subject: <label>
                    <input type="number" name="ranking_the_no_start_by_subject" value="{{ old('ranking_the_no_start_by_subject', $course->ranking_the_no_start_by_subject ) }}"></input>
                    <label>to<label>
                    <input type="number" name="ranking_the_no_end_by_subject" value="{{ old('ranking_the_no_end_by_subject', $course->ranking_the_no_end_by_subject) }}"></input>
                    <label>( </label>
                    <input type="number" id="year" name="ranking_the_year_by_subject" min="2000" max="2500" value="{{ old('ranking_the_year_by_subject', $course->ranking_the_year_by_subject) }}"></input>
                    <label> )</label>
                </div>

                <div class="container">
                    <label>Course Website: </label>
                    <input type="url" name="course_website" value="{{ old('course_website', $course->course_website) }}"></input>
                </div>

                <div class="container">
                    <label>Course Qualification (MQA Certification required): </label>
                    <input type="radio" name="course_qualification" value="1" {{ old('course_qualification', $course->course_qualification) == '1' ? 'checked' : '' }}>Yes</input>
                    <input type="radio" name="course_qualification" value="0" {{ old('course_qualification', $course->course_qualification) == '0' ? 'checked' : ''}}>No</input>
                </div>

                <div class="container">
                    <label>University & Campus:</label>
                    <select name="university_id">
                        <option value="">--- Select University & Campus ---</option>
                        @foreach ($universities as $university)
                            <option value="{{ $university->id }}"
                                {{ old('university_id', $course->university_id) == $university->id ? 'selected' : '' }}>
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
                             <option value="{{ $admin->id }}"
                                {{ old('admin_id', $course->admin_id) == $admin->id ? 'selected' : '' }}>
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
                             <option value="{{ $category->id }}"
                                {{ old('course_id', $course->course_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->course_aspect }} - {{ $category->course_category }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <button type="submit" id="submit">Update Course</button>
                </div>
            </form>
        </div>
        <div class="back-button">
            <a href="{{ route('course.list') }}">
                <button id="back">Back</button>
            </a>
        </div>
    </div>
    <x-footer />
</body>