<head>
    <title>Course and University Recommendation System: Creation of the University</title>

    <link rel="stylesheet" href="{{ asset('css/admin_create.css') }}">
</head>

<body>
    <x-header title="University Creation"/>
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
            <form action="{{ route('university.store') }}" method="POST">
                @csrf

                <div class="container">
                    <label>University Name: </label>
                    <textarea name="uni_name" required></textarea>
                </div>

                <div class="container">
                    <label>University Address: </label>
                    <textarea name="uni_address" required></textarea>
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
                    <select name="state_id" id="state-dropdown" required>
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
                    <input type="url" name="website" placeholder="https://example.com" required></input>
                </div>

                <div class="container">
                    <label>University Type: </label>
                    <input type="radio" name="uni_type" value="Public" {{ old('uni_type') == 'Public' ? 'checked' : '' }}> Public University</input>
                    <input type="radio" name="uni_type" value="Private" {{ old('uni_type') == 'Private' ? 'checked' : '' }}> Private University</input>
                </div>

                <div class="container">
                    <label>Contact Number: </label>
                    <input type="tel" id="contact_no" name="contact_no" pattern="[0-9]{3}-[0-9]{7,8}" placeholder="609-xxxxxxx or 609-xxxxxxxx" required></input>
                </div>

                <div class="container">
                    <label>Email: </label>
                    <input type="email" name="email" required></input>
                </div>

                <div class="container">
                    <label>QS Ranking: </label>
                    <input type="number" name="ranking_qs_no_start"></input>
                    <label>to<label>
                    <input type="number" name="ranking_qs_no_end"></input>
                    <label>( </label>
                    <input type="number" id="year" name="ranking_qs_year" min="2000" max="2500"></input>
                    <label> )</label>
                </div>

                <div class="container">
                    <label>THE Ranking: </label>
                    <input type="number" name="ranking_the_no_start"></input>
                    <label>to<label>
                    <input type="number" name="ranking_the_no_end"></input>
                    <label>( </label>
                    <input type="number" id="year" name="ranking_the_year" min="2000" max="2500"></input>
                    <label> )</label>
                </div>

                <div>
                    <label>Created By: </label>
                    <input type="text" value="{{ session('admin_name') }}" readonly></input>
                    <input type="hidden" name="admin_id" value="{{ session('admin_id') }}"></input>
                </div>

                <div id="submit">
                    <button type="submit" id="submit">Create University Information</button>
                </div>
            </form>
        </div>
        <div id="back">
            <a href="{{ route('university.list') }}">
                <button id="back">Back</button>
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