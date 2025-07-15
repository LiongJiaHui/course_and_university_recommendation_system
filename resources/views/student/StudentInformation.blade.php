<head>
    <title>Course And University Recommendation System: Student Information</title>
    <link rel="stylesheet" href="{{ asset('css/student.css') }}">

</head>

<body>
    <div>
        <x-header title="Student Information" />
        <div>
            <div>
                <form action="http://127.0.0.1:5000/student-information" method="POST">
                    @csrf

                    <div>
                        <label>Name: </label>
                        <input type="text" name="name" id="name" placeholder="" value="{{ old('name') }}" required></input>
                        <br>
                    </div>

                    <div>
                        <label>Address: </label>
                        <input type="text" name="address" id="address" placeholder="" value="{{ old('address') }}" required></input>
                        <br>
                    </div>

                    <div>
                        <label>Postcode:</label>
                        <select id="postcode-dropdown" name="postcode" required>
                            <option value="">--- Select Postcode ---</option>
                        </select>
                    </div>

                    <div>
                        <label>Area: </label>
                        <select name="area" id="area-dropdown" required>
                            <option value="">--- Select Area ---</option>
                        </select>
                        <br>
                    </div>

                    <div>
                        <label>State: </label>
                        <select name="state" id="state-dropdown" required>
                            <option value="">---Select State---</option>
                            @foreach ($states as $state)
                                <option value="{{ $state->id }}">{{ $state->state_name }}</option>
                            @endforeach
                        </select>
                        <br>
                    </div>

                    <button type="submit">Submit</button>
                    <br>
                </form>
            </div>
            
            <div class="button-row">
                <div id="back-btn">
                    <a href="/" id="back-btn">
                        <button id="back-btn">Back</button>
                    </a>
                </div>
                <div id="back-btn">
                    <a href="subjectinformation" id="back-btn">
                        <button id="back-btn">Next</button>
                    </a>
                </div>
            </div>
        </div>
        <x-footer />
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        document.getElementById('state-dropdown').addEventListener('change', function() {
            const stateId = this.value;
            const areaDropdown = document.getElementById('area-dropdown');
            const postcodeDropdown = document.getElementById('postcode-dropdown');

            areaDropdown.innerHTML = '<option value="">Loading...</option>';
            postcodeDropdown.innerHTML = '<option value="">Loading...</option>';

            if (stateId) {
                axios.get(`/get-areas/${stateId}`)
                    .then(response => {
                        areaDropdown.innerHTML = '<option value="">--- Select Area ---</option>';
                        response.data.forEach(areaName => {
                            areaDropdown.innerHTML += `<option value="${areaName}">${areaName}</option>`;
                        });
                    });
            }
        });

        document.getElementById('area-dropdown').addEventListener('change', function() {
            const areaName = this.value;
            const postcodeDropdown = document.getElementById('postcode-dropdown');

            postcodeDropdown.innerHTML = '<option value="">Loading...</option>';

            if (areaName) {
                axios.get(`/get-postcodes/${areaName}`)
                    .then(response => {
                        postcodeDropdown.innerHTML = '<option value="">--- Select Postcode ---</option>';
                        response.data.forEach(postcode => {
                            postcodeDropdown.innerHTML += `<option value="${postcode}">${postcode}</option>`;
                        });
                    });
            }
        });

        

    </script>
</body>