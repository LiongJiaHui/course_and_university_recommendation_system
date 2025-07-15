<head>
    <title>Course and University Recommendation System: Student Preferences</title>
    <link rel="stylesheet" href="{{ asset('css/student.css') }}">

</head>

<body>
    <div>
        <x-header title="Student Preferences" />
        <div>
            <div>
                <form method="POST">
                    <div>
                        <label>University Type: </label>
                        <input type="radio" name="unitype" id="public_uni" value="public">Public Universities</input>
                        <input type="radio" name="unitype" id="private_uni">Private Universities</input>
                    </div>
                    <div>
                        <input type="radio" name="preference"></input>
                        <label>Location: </label>
                        <select>
                            <option>--- Select State ---</option>
                            <option value="Johor">Johor</option>
                            <option value="Kedah">Kedah</option>
                            <option>Kelantan</option>
                            <option>Melaka</option>
                            <option>Negeri Sembilan</option>
                            <option>Pahang</option>
                            <option>Pulau Pinang</option>
                            <option>Perak</option>
                            <option>Perlis</option>
                            <option>Sabah</option>
                            <option>Selangor</option>
                            <option>Terengganu</option>
                            <option>Wilayah Persekutuan Kuala Lumpur</option>
                            <option>Wilayah Persekutuan Labuan</option>
                            <option>Wilayah Persekutuan Putrajaya</option>
                        </select>
                    </div>
                    <div>
                        <input type="radio" name="preference"></input>
                        <label>Shortest Distance</label>
                    </div>
                    <div>
                        <input type="radio" name="preference"></input>
                        <label>Area of Interest: </label>
                        <select>
                            <option></option>
                        </select>
                    </div>
                    <div>
                        <input type="radio" name="preference" value="expected_fees"></input>
                        <label>Expected Total Tuition Fees (For whole study): </label>
                        <input type="number" min="0"></input>
                        <label> to </label>
                        <input type="number"></input>
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