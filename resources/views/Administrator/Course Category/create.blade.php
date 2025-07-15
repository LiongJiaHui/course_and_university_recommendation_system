<head>
    <title>Course and University Recommendation System: Creation of the Course Category</title>


</head>

<body>
    <x-header title="Create the Course Category"/>
    <div>
        <form action="{{  }}" method="POST">
            @csrf

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


        </form>
    </div>
    <x-footer />

    <script>
        document.getElementById("year").value = new Date().getFullYear();

    </script>
</body>