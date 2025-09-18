<DOCTYPE! html> 
<html>

<head>
    <title>Course and University Recommendation System</title>
    
    <link rel="stylesheet" href="{{ asset('css/MainPage.css') }}">
</head>
<body>
    <div>
        <x-header title="Main Page"/>
        <div style="text-align: center; margin-top: 50px; margin-bottom: 50px;">
            <h2>Please choose your role: </h2>
        </div>
        <div>
            <div>
                <a href="studentinformation">
                    <button style="background-color: Fuchsia;">Student</button>
                </a>
            </div>
            <div>
                <a href="adminLogin">
                    <button style="background-color: DeepSkyBlue;">Administrator</button>
                </a>
            </div>
        </div>
        <x-footer />
    </div>
</body>

</html>