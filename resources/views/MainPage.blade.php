<DOCTYPE! html> 
<html>

<head>
    <title>Course and University Recommendation System</title>
    
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body>
    <div>
        <x-header title="Main Page"/>
        <div>
            <h2>Please choose your role: </h2>
        </div>
        <div>
            <div>
                <a href="studentinformation">
                    <button>Student</button>
                </a>
            </div>
            <div>
                <a href="adminLogin">
                    <button>Administrator</button>
                </a>
            </div>
        </div>
        <x-footer />
    </div>
</body>

</html>