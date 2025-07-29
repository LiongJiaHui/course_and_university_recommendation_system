<head>
    <title>Course and University Recommendation System: Update the University</title>

</head>

<body>
    <x-header title="Update the University"/>
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
            <form action="{{ route('university.update', $university->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="container">
                    <label>University Name: </label>
                    <input type="text" name="uni_name" required></input>
                </div>

                <div class="container">
                    <label>University Address: </label>
                    <input type="text" name="uni_address" required></input>
                </div>

                <div class="container">
                    <label>Postcode:</label>
                    <select id="postcode-dropdown" name="postcode" required>
                            <option value="">--- Select Postcode ---</option>
                    </select>
                </div>

                <div class="container">
                    <label>Area: </label>
                    <select name="area" id="area-dropdown" required>
                        <option value="">--- Select Area ---</option>
                    </select>
                </div>

                <div class="container">
                    <label>State: </label>
                    <select name="state" id="state-dropdown" required>
                        <option value="">---Select State---</option>
                        @foreach ($states as $state)
                            <option value="{{ $state->id }}">{{ $state->state_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="container">
                    <label>Campus: </label>
                    <input type="text" name="campus" required></input>
                </div>

                <div class="container">
                    <label>Website: </label>
                    <input type="url" ></input>
                </div>

                <div class="container">
                    <label></label>
                    <input type="radio">Public University</input>
                    <input type="radio">Private University</input>
                </div>

                <div class="container">
                    <label>Contact Number: </label>
                    <input type="tel" id="contact_no" name="contact_no" pattern="[0-9]{3}-[0-9]{7,8}" placeholder="609-xxxxxxx or 609-xxxxxxxx" required></input>
                </div>

                <div class="container">
                    <label>QS Ranking: </label>
                    <input type="number"></input>
                    <label>to<label>
                    <label>( </label>
                    <input type="number"></input>
                    <input type="number" id="year" name="year" min="2000" max="2500"></input>
                    <label> )</label>
                </div>

                <div class="container">
                    <label>THE Ranking: </label>
                    <input type="number"></input>
                    <label>to<label>
                    <input type="number"></input>
                    <label>( </label>
                    <input type="number" id="year" name="year" min="2000" max="2500"></input>
                    <label> )</label>
                </div>

                <div>
                    <button type="submit">Update University Information</button>
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

        document.getElementById("year").value = new Date().getFullYear();

    </script>
</body>