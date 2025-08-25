<head>
    <title>Course And University Recommendation System: Administrator Login Page</title>

     <link rel="stylesheet" href="{{ asset('css/admin_login.css') }}">
</head>

<body>
    <div>
        <x-header title="Administrator Login Page" />
        <div>
            <div id="form">
                <form method="POST" action="{{ url('/adminLogin') }}">
                    @csrf
                    <div class="options">
                        <label>Name: </label>
                        <input type="text" name="admin_name"></input>
                        <br>
                    </div>

                    <div class="options">
                        <label>Password: </label>
                        <input type="password" name="password"></input>
                        <br>
                    </div>

                    <div>
                        <button type="submit">Login</button>
                    </div>
                </form>
            </div>

            <div class="button-row">
                <div id="back-btn">
                    <a href="/" id="back-btn">
                        <button id="back-btn">Back</button>
                    </a>
                </div>
            </div>
        <x-footer />
    </div>
</body>    