<head>
    <title>Course and University Recommendation System: Update the University</title>
    <link rel="stylesheet" href="{{ asset('css/admin_create.css') }}">
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
                    <input type="text" name="uni_name" value="{{ old('uni_name', $university->uni_name) }}" required></input>
                </div>

                <div class="container">
                    <label>University Address: </label>
                    <input type="text" name="uni_address" value="{{ old('uni_address', $university->uni_address) }}" required></input>
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
                            <option value="{{ $state->id }}" {{ old('state_id', $university->state_id) == $state->id ? 'selected' : '' }}> {{ $state->state_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="container">
                    <label>Campus: </label>
                    <input type="text" name="campus" value="{{ old('campus', $university->campus) }}" required></input>
                </div>

                <div class="container">
                    <label>Website: </label>
                    <input type="url" name="website" value="{{ old('website', $university->website) }}" required></input>
                </div>

                <div class="container">
                    <label>University Type: </label>
                    <input type="radio" name="uni_type" value="Public" {{ old('uni_type', $university->uni_type) == 'Public' ? 'checked' : '' }}> Public University</input>
                   <input type="radio" name="uni_type" value="Private" {{ old('uni_type', $university->uni_type) == 'Private' ? 'checked' : '' }}> Private University</input>
                </div>

                <div class="container">
                    <label>Contact Number: </label>
                    <input type="tel" id="contact_no" name="contact_no" pattern="[0-9]{3}-[0-9]{7,8}" placeholder="609-xxxxxxx or 609-xxxxxxxx" value="{{ old('contact_no', $university->contact_no) }}" required></input>
                </div>

                <div class="container">
                    <label>Email: </label>
                    <input type="email" name="email" value="{{ old('email', $university->email) }}" required></input>
                </div>

                <div class="container">
                    <label>QS Ranking: </label>
                    <input type="number" name="ranking_qs_no_start" value="{{ old('ranking_qs_no_start', $university->ranking_qs_no_start) }}"></input>
                    <label>to<label>
                    <input type="number" name="ranking_qs_no_end" value="{{ old('ranking_qs_no_end', $university->ranking_qs_no_end) }}"></input>
                    <label>( </label>
                    <input type="number" id="year" name="ranking_qs_year" min="2000" max="2500" value="{{ old('ranking_qs_year', $university->ranking_qs_year) }}"></input>
                    <label> )</label>
                </div>

                <div class="container">
                    <label>THE Ranking: </label>
                    <input type="number" name="ranking_the_no_start" value="{{ old('ranking_the_no_start', $university->ranking_the_no_start) }}" ></input>
                    <label>to<label>
                    <input type="number" name="ranking_the_no_end" value="{{ old('ranking_the_no_end', $university->ranking_the_no_end) }}"></input>
                    <label>( </label>
                    <input type="number" id="year" name="ranking_the_year" min="2000" max="2500" value="{{ old('ranking_the_year', $university->ranking_the_year) }}"></input>
                    <label> )</label>
                </div>

                <div class="container">
                    <label>Admin: </label>
                    <select name="admin_id">
                        <option value="">--- Select Admin ---</option>
                        @foreach ($admins as $admin)
                             <option value="{{ $admin->id }}"
                                {{ old('admin_id', $university->admin_id) == $admin->id ? 'selected' : '' }}>
                                {{ $admin->admin_name }} ({{ $admin->id }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <button type="submit" id="submit">Update University Information</button>
                </div>
            </form>
        </div>
        <div>
            <a href="{{ route('university.list') }}">
                <button id="back">Back</button>
            </a>
        </div>
    </div>
    <x-footer />

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        document.getElementById("year").value = new Date().getFullYear();

        const currentArea = @json($university->area->area_name);
        const currentPostcode = @json($university->area->postcode);
        const currentStateId = {{ $university->state_id }};

        window.addEventListener('load', function() {
            const stateDropdown = document.getElementById('state-dropdown');
            const areaDropdown = document.getElementById('area-dropdown');
            const postcodeDropdown = document.getElementById('postcode-dropdown');

            // state changes to load areas
            stateDropdown.value = currentStateId;
            const event = new Event('change');
            stateDropdown.dispatchEvent(event);

            // Delay to ensure areas loaded before selecting
            setTimeout(() => {
                axios.get(`/get-areas/${currentStateId}`).then(response => {
                    areaDropdown.innerHTML = '<option value="">--- Select Area ---</option>';
                    response.data.forEach(areaName => {
                        const selected = areaName === currentArea ? 'selected' : '';
                        areaDropdown.innerHTML += `<option value="${areaName}" ${selected}>${areaName}</option>`;
                    });

                    // Trigger area change to load postcodes
                    const areaChangeEvent = new Event('change');
                    areaDropdown.dispatchEvent(areaChangeEvent);

                    setTimeout(() => {
                        axios.get(`/get-postcodes/${currentArea}`).then(response => {
                            postcodeDropdown.innerHTML = '<option value="">--- Select Postcode ---</option>';
                            response.data.forEach(postcode => {
                                const selected = postcode == currentPostcode ? 'selected' : '';
                                postcodeDropdown.innerHTML += `<option value="${postcode}" ${selected}>${postcode}</option>`;
                            });
                        });
                    }, 500);
                });
            }, 500);
        });

    </script>
</body>