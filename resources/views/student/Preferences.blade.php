<head>
    <title>Course and University Recommendation System: Student Preferences</title>

</head>

<body>
    <div>
        <x-header title="Student Preferences" />
        <div>
            <div>
                <form>
                    <div>
                        <label>University Type: </label>
                        <input type="radio">Public Universities</input>
                        <input type="radio">Private Universities</input>
                    </div>
                    <div>
                        <input type="checkbox"></input>
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
                        <input type="checkbox"></input>
                        <label>Shortest Distance</label>
                    </div>
                    <div>
                        <input type="checkbox"></input>
                        <label>Area of Interest: </label>
                        <select>
                            <option></option>
                        </select>
                    </div>
                    <div>
                        <input type="checkbox"></input>
                        <label></label>
                    </div>
                </form>
                <div>
                    <button type="submit">Submit</button>
                </div>
            </div>
            <div>
                    
            </div>
        </div>
        <x-footer />
    </div>
</body>