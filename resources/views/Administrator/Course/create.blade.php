<head>
    <title>Course and University Recommendation System: Creation of the course</title>


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
                    <input type="number" min="0" name="tuition_fees" required></input>
                </div>

                <div>
                    <label>Credit Hour: </label>
                    <input type="number" name="credit_hours" required></input>
                </div>

                <div>
                    <label>Duration: </label>
                    <input type="number" name="duration" required></input>
                </div>

                <div>
                    <label>Minimum Grade: </label>
                    <input type="number" name="minimum_grade" required></input>
                </div>

                <div>
                    <label>Specific Subjects: </label>
                    <input type="text" name="specific_subjects" placeholder="if multiple subjects, must have comma to distinguish"></input>
                </div>

                <div>
                    <label>Merit Mark: </label>
                    <input type="number" name="merit_mark" required></input>
                </div>

                <div>
                    <label>English Requirement Skill (MUET Marks):</label>
                    <input type="number" name="english_requirement_skill" required></input>
                </div>

                <div>
                    <label>QS Ranking By Subject: <label>
                    <input type="number" name=""></input>
                    <label>to<label>
                    <label>( </label>
                    <input type="number"></input>
                    <input type="number" id="year" name="year" min="2000" max="2500"></input>
                    <label> )</label>
                </div>

                <div>
                    <label>THE Ranking By Subject: <label>
                    <input type="number"></input>
                    <label>to<label>
                    <label>( </label>
                    <input type="number"></input>
                    <input type="number" id="year" name="year" min="2000" max="2500"></input>
                    <label> )</label>
                </div>

                <div>
                    <label>Course Qualification (MQA Certification required): </label>
                    <input type="radio" name="course_qua" value="True">Yes</input>
                    <input type="radio" name="course_qua" value="False">No</input>
                </div>

                <div>
                    <label>Course Website: </label>
                    <input type="url" name="course_website" required></input>
                </div>

                <div>
                    <label>Course Category: </label>
                    <select>
                        <option>--- Select Course Category ---</option>
                    </select>
                </div>

                <div>
                    <label>Course Aspect: </label>
                    <select>
                        <option>--- Select Course Aspect ---</option>
                    </select>
                </div>

                <div>
                    <label>University: </label>
                    <select>
                        <option value="">--- Select University ---</option>
                    </select>
                </div>

                <div>
                    <label>Branch: </label>
                    <select>
                        <option>--- Select Branch ---</option>
                    </select>
                </div>

                <div>
                    <!--Show the admin_id and admin_name-->
                </div>

                <div>
                    <button type="submit">Submit</button>
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