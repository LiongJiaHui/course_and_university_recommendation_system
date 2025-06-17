<head>
    <title>Course And University Recommendation System: Student Information</title>

</head>

<body>
    <div>
        <x-header title="Student Information" />
        <div>
            <div>
                <form method="POST">
                    @csrf

                    <div>
                        <label>Name: </label>
                        <input type="text" name="name" id="name"  value="{{ old('name') }}" required></input>
                        <br>
                    </div>

                    <div>
                        <label>Address: </label>
                        <input type="text" name="address" id="address" value="{{ old('address') }}" required></input>
                        <br>
                    </div>

                    <div>
                        <label>State: </label>
                        <select name="state" id="state-dropdown" required>
                            <option value="">---Select State---</option>
                            <option value="Perlis">Perlis</option>
                            <option value="Kuala Lumpur">Kuala Lumpur</option>
                            <option value="Selangor">Selangor</option>
                            <option value="Perak">Perak</option>
                            <option value="Pahang">Pahang</option>
                            <option value="Sarawak">Sarawak</option>
                            <option value="Sabah">Sabah</option>
                            <option value="Melaka">Melaka</option>
                            <option value="Kedah">Kedah</option>
                            <option value="Negeri Sembilan">Negeri Sembilan</option>
                            <option value="Terengganu">Terengganu</option>
                            <option value="Pahang">Pahang</option>
                            <option value="Kelantan">Kelantan</option>
                            <option value="Johor">Johor</option>
                        </select>
                        <br>
                    </div>

                    <div>
                        <label>City/Town: </label>
                        <select name="city" id="city-dropdown" required>
                            <option value="">---Select City Or Town ---</option>
                        </select>
                        <br>
                    </div>

                    <div>
                        <label>PostCode: </label>
                        <input></input>
                        <br>
                    </div>
                </form>
                <div>
                    <button type="submit">Submit</button>
                </div>
            </div>
            <div>
                <a href="subjectinformation">
                    <button>Next</button>
                </a>
            </div>
        </div>
        <x-footer />
    </div>
</body>