<head>
    <title>Course And University Recommendation System: Administrator Login Page</title>


</head>

<body>
    <div>
        <x-header title="Administrator Login Page" />
        <div>
            <div>
                <form method="POST" action="{{ url('/adminLogin') }}">
                    @csrf
                    <div>
                        <label>Name: </label>
                        <input type="text" name="admin_name"></input>
                        <br>
                    </div>

                    <div>
                        <label>Password: </label>
                        <input type="password" name="password"></input>
                        <br>
                    </div>

                    <div>
                        <button type="submit">Login</button>
                    </div>
                </form>
            </div>
            <div >
                <a href="/">
                    <button>Back</button>
                </a>
            </div>
        </div>
        <x-footer />
    </div>
</body>    