<head>
    <title>Course and University Recommendation System: Update the Course Category</title>


</head>

<body>
    <x-header title="Update Course Category"/>
    <div>
        <div>
            <form method="POST">
                @csrf
                @method('PUT')

                <div>
                    <label>Course Category: </label>
                    <input type="text"></input>
                </div>

                <div>
                    <label>Course Aspect: </label>
                    <select>
                        <option value="">--- Select Course Aspect ---</option>
                        <option value="">Information Technology</option>
                        <option value="">Health Sciences and Medicine</option>
                        <option value="">Engineering</option>
                        <option value="">Business and Economics</option>
                        <option value="">Arts and Humanities</option>
                    </select>
                </div>
                
                <div class="container">
                    <button>Submit</button>
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
</body>