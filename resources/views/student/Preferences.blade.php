<head>
    <title>Course and University Recommendation System: Student Preferences</title>
    <link rel="stylesheet" href="{{ asset('css/SelectionInStudent.css') }}">

</head>

<body>
    <div>
        <x-header title="Student Preferences" />
        <div>
            <div>
                <form action="{{ route('studentpreferences.submit') }}" method="POST">
                    @csrf
                    <div class="container">
                        <div class="option">
                            <label>University Type: </label>
                            <input type="radio" name="unitype" id="public_uni" value="public" required>
                            <label>Public Universities</label>
                            <input type="radio" name="unitype" id="private_uni" value="private" required>
                            <label>Private Universities</label>
                        </div>
                    </div>
                    <div class="container">
                        <div class="options">
                            <div class="option-header">
                                <input type="checkbox" name="preference[]" value="location"></input>
                                <label>Location: </label>
                            </div>
                            <div class="select">
                                <ul style="list-style: none; padding: 0;">
                                    <li>
                                        <label>
                                            <input type="checkbox" name="location[]" value="Johor"> Johor </input>
                                        </label>
                                    </li>
                                    <li>
                                        <label>
                                            <input type="checkbox" name="location[]" value="Kedah"> Kedah</input>
                                        </label>
                                    </li>
                                    <li>
                                        <label>
                                            <input type="checkbox" name="location[]" value="Kelantan"> Kelantan</input>
                                        </label>
                                    </li>
                                    <li>
                                        <label>
                                            <input type="checkbox" name="location[]" value="Melaka"> Melaka</input>
                                        </label>
                                    </li>
                                    <li>
                                        <label>
                                            <input type="checkbox" name="location[]" value="Negeri Sembilan"> Negeri Sembilan</input>
                                        </label>
                                    </li>
                                    <li>
                                        <label>
                                            <input type="checkbox" name="location[]" value="Pahang"> Pahang</input>
                                        </label>
                                    </li>
                                    <li>
                                        <label>
                                            <input type="checkbox" name="location[]" value="Pulau Pinang"> Pulau Pinang</input>
                                        </label>
                                    </li>
                                    <li>
                                        <label>
                                            <input type="checkbox" name="location[]" value="Perak"> Perak</input>
                                        </label>
                                    </li>
                                    <li>
                                        <label>
                                            <input type="checkbox" name="location[]" value="Perlis"> Perlis</input>
                                        </label>
                                    </li>
                                    <li>
                                        <label>
                                            <input type="checkbox" name="location[]" value="Sabah"> Sabah</input>
                                        </label>
                                    </li>
                                    <li>
                                        <label>
                                            <input type="checkbox" name="location[]" value="Selangor"> Selangor</input>
                                        </label>
                                    </li>
                                    <li>
                                        <label>
                                            <input type="checkbox" name="location[]" value="Terengganu"> Terengganu</input>
                                        </label>
                                    </li>
                                    <li>
                                        <label>
                                            <input type="checkbox" name="location[]" value="Wilayah Persekutuan Kuala Lumpur"> Kuala Lumpur</input>
                                        </label>
                                    </li>
                                    <li>
                                        <label>
                                            <input type="checkbox" name="location[]" value="Wilayah Persekutuan Labuan"> Labuan</input>
                                        </label>
                                    </li>
                                    <li>
                                        <label>
                                            <input type="checkbox" name="location[]" value="Wilayah Persekutuan Putrajaya"> Putrajaya</input>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="options">
                            <div class="option-header">
                                <input type="checkbox" name="preference[]" value="shortest_distance"></input>
                                <label>Shortest Distance</label>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="options">
                            <div class="option-header">
                                <input type="checkbox" name="preference[]" value="area_of_interest"></input>
                                <label>Area of Interest: </label>
                            </div>
                            <div class="select">
                                <ul style="list-style: none; padding: 0;">
                                    <li>
                                        <label>
                                            <input type="checkbox" name="area_of_interest[]" value="Engineering">Engineering</input>
                                        </label>
                                    </li>
                                    <li>
                                        <label>
                                            <input type="checkbox" name="area_of_interest[]" value="Information Technology">Information Technology</input>
                                        </label>
                                    </li>
                                    <li>
                                        <label>
                                            <input type="checkbox" name="area_of_interest[]" value="Finance & Management">Finance & Management</input>
                                        </label>
                                    </li>
                                    <li>
                                        <label>
                                            <input type="checkbox" name="area_of_interest[]" value="Arts & Humanities">Arts & Humanities</input>
                                        </label>
                                    </li>
                                    <li>
                                        <label>
                                            <input type="checkbox" name="area_of_interest[]" value="Legal">Legal</input>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="options">
                            <div class="option-header">
                                <input type="checkbox" name="preference[]" value="expected_fees"></input>
                                <label>Expected Total Tuition Fees (For whole study): </label>
                                <input type="number" min="0" name="tuition_fees_start"></input>
                                <label> to </label>
                                <input type="number" name="tuition_fees_end"></input>
                            </div>
                        </div>
                    </div>
                    <div>
                        <button type="submit">Submit</button>
                    </div>
                </form>
            </div>

             <div class="button-row">
                <div id="back-btn">
                    <a href="subjectinformation" id="back-btn">
                        <button id="back-btn">Back</button>
                    </a>
                </div>
            </div>
        </div>
        <x-footer />
    </div>
</body>