<head>
    <title>Course and University Recommendation System: Subject Information</title>
    <link rel="stylesheet" href="{{ asset('css/student.css') }}">
    
</head>

<body>
    <div>
        <x-header title="Subject Information" />
        <div>
            <div>
                <form action="" method="POST">

                    @csrf
                    <div>
                        <label>Number of subjects</label>
                        <input type="radio" name="subjects" value="4" onclick="toggleSubjects(4)" >4 subjects</input>
                        <input type="radio" name="subjects" value="5" onclick="toggleSubjects(5)">5 subjects</input>
                        <input type='hidden' id='subjectCount' name="subjectCount" value="5"></input>
                    </div>

                    @php
                        $subjects = [
                            "Bahasa Arab", 
                            "Bahasa Cina",
                            "Bahasa Melayu", 
                            "Bahasa Tamil", 
                            "Biology", 
                            "Chemistry", 
                            "Economics", 
                            "Further Mathematics", 
                            "Geografi", 
                            "Information and Communication Technology",
                            "Kesusasteraan Melayu Komunikatif", 
                            "Literature in English", 
                            "Mathematics (M)", 
                            "Mathematics (T)", 
                            "Pengajian Am", 
                            "Perakaunan", 
                            "Physics", 
                            "Sains Sukan", 
                            "Sejarah", 
                            "Seni Visual", 
                            "Syariah", 
                            "Tahfiz Al-Quran", 
                            "Usuluddin"
                        ]; 
                    @endphp

                    <!-- Subject Sections -->
                    @for ($i = 1; $i <= 5; $i++)
                        <div id="subjectSection{{ $i }}">
                            <label>Subject {{ $i }}</label>
                            <select name="subject{{ $i }}">
                                <option value="">--- Select Subject ---</option>
                                @foreach ($subjects as $subject)
                                    <option value="{{ $subject }}">{{ $subject }}</option>
                                @endforeach
                            </select>
                            <input type="text" name="subject{{ $i }}marks" placeholder="3.00" value="{{ old("subject{$i}marks") }}"></input>
                            <br>
                        </div>
                    @endfor
                    
                    <!-- MUET and Cocurricular -->
                    <div>
                        <label>MUET Score: Band </label>
                        <input type="text" name="MUETmarks" value="{{ old('MUETmarks') }}"></input>
                        <br>
                    </div>
                    <div>
                        <label>Cocuriculum Marks: </label>
                        <input type="text" name="cocuriculummarks" value="{{ old('cocuriculummarks') }}"></input>
                        <label>/100</label>
                        <br>
                    </div>

                    <button type="submit">Submit</button>
                </form>
            </div>

            <div class="button-row">
                <div id="back-btn">
                    <a href="studentinformation" id="back-btn">
                        <button id="back-btn">Back</button>
                    </a>
                </div>
                <div id="back-btn">
                    <a href="studentpreferences" id="back-btn">
                        <button id="back-btn">Next</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <x-footer />


    <script>
        function toggleSubjects(count){
            for (let i = 1; i <= 5; i++){
                const section = document.getElementById('subjectSection' + i);
                if (section){
                    section.style.display = (i <= count) ? 'block' : 'none';
                }
                document.getElementById('subjectCount').value = count;
            }
        }

        window.onload = function(){
            // Set default subject count to 4
            toggleSubjects(4);
        }
    </script>
</body>