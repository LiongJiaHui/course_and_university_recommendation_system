<head>
    <title>Course and University Recommendation System: Update the Course Category</title>
    <link rel="stylesheet" href="{{ asset('css/admin_create.css') }}">

</head>

<body>
    <x-header title="Update Course Category"/>
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
            <form action="{{ route('coursecategory.update', $category->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="container">
                    <label>Course Category: </label>
                    <input type="text" value="{{ old('course_category', $category->course_category) }}"></input>
                </div>

                <div class="container">
                    <label>Course Aspect: </label>
                    <select name="course_aspect">
                        <option value="">--- Select Course Aspect ---</option>
                        <option value="Engineering" {{ old('course_aspect', $category->course_aspect) == 'Engineering' ? 'selected' : '' }}>Engineering</option>
                        <option value="Information Technology" {{ old('course_aspect', $category->course_aspect) == 'Information Technology' ? 'selected' : '' }}>Information Technology</option>
                        <option value="Business & Management" {{ old('course_aspect', $category->course_aspect) == 'Business & Management' ? 'selected' : '' }}>Business & Management</option>
                        <option value="Arts & Humanities" {{ old('course_aspect', $category->course_aspect) == 'Arts & Humanities' ? 'selected' : '' }}>Arts & Humanities</option>
                        <option value="Medical" {{ old('course_aspect', $category->course_aspect) == 'Medical' ? 'selected' : '' }}>Medical</option>
                        <option value="Sciences" {{ old('course_aspect', $category->course_aspect) == 'Sciences' ? 'selected' : '' }}>Sciences</option>
                        <option value="Legal" {{ old('course_aspect', $category->course_aspect) == 'Legal' ? 'selected' : '' }}>Legal</option>
                    </select>
                </div>

                <div class="container">
                    <label>Admin: </label>
                    <select name="admin_id">
                        <option value="">--- Select Admin ---</option>
                        @foreach ($admins as $admin)
                             <option value="{{ $admin->id }}"
                                {{ old('admin_id', $category->admin_id) == $admin->id ? 'selected' : '' }}>
                                {{ $admin->admin_name }} ({{ $admin->id }})
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <button id="submit">Submit</button>
                </div>
            </form>
        </div>
        <div>
            <a href="{{ route('coursecategory.list') }}">
                <button id="back">Back</button>
            </a>
        </div>
    </div>
    <x-footer />
</body>