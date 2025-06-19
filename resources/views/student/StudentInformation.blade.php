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
                            <option value="PutraJaya">PutraJaya</option>
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
                        <label>Postcode:</label>
                        <input name="postcode" id="postcode" type="text" readonly>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // When user selects a state, load cities
        $('#state-dropdown').on('change', function () {
            var stateID = $(this).val();
            $('#city-dropdown').html('<option value="">Loading...</option>');
            $('#postcode').val('');

            if (stateID) {
                $.ajax({
                    url: "{{ route('getCities') }}",
                    type: "GET",
                    data: { state_id: stateID },
                    success: function (res) {
                        $('#city-dropdown').html('<option value="">-- Select City --</option>');
                        $.each(res, function (key, city) {
                            $('#city-dropdown').append(
                                '<option value="' + city.id + '" data-postcode="' + city.postcode + '">' + city.name + '</option>'
                            );
                        });
                    }
                });
            } else {
                $('#city-dropdown').html('<option value="">-- Select City --</option>');
                $('#postcode').val('');
            }
        });

        // When city is selected, show postcode
        $('#city-dropdown').on('change', function () {
            var postcode = $('option:selected', this).data('postcode');
            $('#postcode').val(postcode || '');
        });

    </script>
</body>