<head>
    <title>Course And University Recommendation System: Creation of the Administrator</title>

</head>

<body>
    <x-header title="Creation of the Administrator"/>
    <div>
        <div>
            <form action="{{ route('') }}" method="POST">
                @csrf

                <div class="container">
                    <label>Admin Name: </label>
                    <input name="admin_name" placeholder="" type="text" required></input>
                    <br>
                </div>

                <div class="container">
                    <label>Password: </label>
                    <input name="password" placeholder="" type="text" required></input>
                    <br>
                </div>

                <div>
                    <button type="submit">Submit</button>
                    <br>
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