<head>
    <title>Course and University Recommendation System: Subject Information</title>
    <link rel="stylesheet" href="{{ asset('css/SelectionInStudent.css') }}">
    
</head>

<body>
    <div>
        <x-header title="Subject Information" />
        <div>
            <div>
                <form action="{{ route('subjectinformations.submit') }}" method="POST">

                    @csrf
                    <div class="container">
                        <label>Number of subjects</label>
                        <div class="option">
                            <input type="radio" name="subjects" value="4" onclick="toggleSubjects(4)" >4 subjects</input>
                            <input type="radio" name="subjects" value="5" onclick="toggleSubjects(5)">5 subjects</input>
                            <input type='hidden' id='subjectCount' name="subjectCount" value="5"></input>
                        </div>
                    </div>

                    <!-- must have the Pengajian Am -->
                    <div class="container">
                        <div id="subjectSection1">
                            <label>Subject 1: </label>
                            <select name="subject1">
                                <option value="Pengajian Am">Pengajian Am</option>
                            </select>
                            <input type="text" name="subject1marks" placeholder="4.00" value="{{ old("subject1marks") }}"></input>
                        </div>
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
                            "Pengajian Perniagaan",
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
                        @for ($i = 2; $i <= 5; $i++)
                        <div class="container">
                            <div id="subjectSection{{ $i }}">
                                <label>Subject {{ $i }}</label>
                                <select name="subject{{ $i }}">
                                    <option value="">--- Select Subject ---</option>
                                    @foreach ($subjects as $subject)
                                        <option value="{{ $subject }}">{{ $subject }}</option>
                                    @endforeach
                                </select>
                                <input type="text" name="subject{{ $i }}marks" placeholder="4.00" value="{{ old("subject{$i}marks") }}"></input>
                                <br>
                            </div>
                        </div>
                        @endfor
                    
                    <!-- MUET and Cocurricular -->
                    <div class="container">
                        <label>MUET Score: Band </label>
                        <input type="text" name="MUETmarks" placeholder="1.0 until 5.0" value="{{ old('MUETmarks') }}"></input>
                        <br>
                    </div>
                    
                    <div class="container">
                        <label>Cocuriculum Marks: </label>
                        <input type="number" name="cocuriculummarks" value="{{ old('cocuriculummarks') }}"></input>
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
            </div>
        </div>
    </div>
    <x-footer />


    <script>
        function toggleSubjects(count){
            for (let i = 2; i <= 5; i++){
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