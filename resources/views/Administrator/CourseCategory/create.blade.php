<head>
    <title>Course and University Recommendation System: Creation of the Course Category</title>
    <link rel="stylesheet" href="{{ asset('css/admin_create.css') }}">

</head>

<body>
    <x-header title="Create the Course Category"/>
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
            <form action="{{ route('coursecategory.store') }}" method="POST">
                @csrf

                <div class="container">
                    <label>Course Category: </label>
                    <input type="text" name="course_category" required></input>
                </div>

                <div class="container">
                    <label>Course Aspect: </label>
                    <select name="course_aspect" required>
                        <option value="">--- Select Course Aspect ---</option>
                        <option value="Engineering">Engineering</option>
                        <option value="Information Technology">Information Technology</option>
                        <option value="Business & Management">Business & Management</option>
                        <option value="Arts & Humanities">Arts & Humanities</option>
                        <option value="Medical">Medical</option>
                        <option value="Sciences">Sciences</option>
                        <option value="Legal">Legal</option>
                        <option value="Social Sciences">Social Sciences</option>
                    </select>
                </div>

                <div class="container">
                    <label>Created By: </label>
                    <input type="text" value="{{ session('admin_name') }}" readonly></input>
                    <input type="hidden" name="admin_id" value="{{ session('admin_id') }}"></input>
                </div>

                <div id="submit">
                    <button type="submit" id="submit">Submit</button>
                </div>
            </form>
        </div>

        <div id="back">
            <a href="{{ route('coursecategory.list') }}">
                <button id="back">Back</button>
            </a>
        </div>
    </div>
    <x-footer />

    <script>
        document.getElementById("year").value = new Date().getFullYear();

    </script>
</body>