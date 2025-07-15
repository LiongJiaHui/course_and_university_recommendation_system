<head>
    <title>Course and University Recommendation System: Creation of the course</title>


</head>

<body>
    <x-header title="Creation of the Course"/>
    <div>
        <div>
            <form method="POST">
            @csrf

                <div class="container">
                    <label>Course Honour Name: </label>
                    <input type="text"></input>
                </div>

                <div class="container">
                    <label>Total Tuition Fees: </label>
                    <input type="number" min="0"></input>
                </div>

                <div>
                    <label>Credit Hour: </label>
                    <input type="number"></input>
                </div>

                <div>
                    <label>Duration: </label>
                    <input type="number"></input>
                </div>

                <div>
                    <label>Minimum Grade: </label>
                    <input type=""></input>
                </div>

                <div>
                    <label>Specific Subjects: </label>
                    <input type="text"></input>
                </div>

                <div>
                    <label>Merit Mark: </label>
                    <input type="number"></input>
                </div>

                <div>
                    <label>English Requirement Skill (MUET Marks):</label>
                    <input type="number"></input>
                </div>

                <div>
                    <label>QS Ranking By Subject: <label>
                    <input type="number"></input>
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
                    <!--This is for the course category-->
                </div>

                <div>
                    <!--This is for the selection of the university-->
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
            <a href="">
                <button>Back</button>
            </a>
        </div>
    </div>
    <x-footer />
</body>