<head>
    <title>Course And University Recommendation System: Administrator Login Page</title>


</head>

<body>
    <div>
        <x-header title="Administrator Login Page" />
        <div>
            <div>


                <form>
                    @csrf
                    <div>
                        <label>Name: </label>
                        <input type="text"></input>
                        <br>
                    </div>

                    <div>
                        <label>Password: </label>
                        <input type="text"></input>
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