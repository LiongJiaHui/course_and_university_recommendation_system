<head>
    <title>Course and University Recommendation System: Update the Course Category</title>


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

                <div>
                    <label>Course Category: </label>
                    <input type="text" value="{{ old('course_category', $category->course_category) }}"></input>
                </div>

                <div>
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

                <div>
                    <label>Admin Id: </label>
                    <input value="{{ old('admin_id', $category->admin_id) }}"></input>
                </div>
                
                <div class="container">
                    <button>Submit</button>
                </div>
            </form>
        </div>
        <div>
            <a href="{{ route('coursecategory.list') }}">
                <button>Back</button>
            </a>
        </div>
    </div>
    <x-footer />
</body>