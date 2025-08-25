<head>
    <title>Course And University Recommendation System: Administrator Menu Section</title>
    <link rel="stylesheet" href="{{ asset('css/MainPage.css') }}">
</head>

<body>
    <div>
        <x-header title="Administrator Menu Section" />
        <div>
            <div>
                <div>
                    <a href="/University">
                        <button>University Information</button>
                    </a>
                </div>

                <div>
                    <a href="/CourseCategory">
                        <button>Course Category</button>
                    </a>
                </div>

                <div>
                    <a href="/Course">
                        <button>Course Information</button>
                    </a>
                </div>

                <div>
                    <a href="{{ route('admin.list') }}">
                        <button>Administrator Management</button>
                    </a>
                </div>
            </div>
            <div>
                <a href="adminLogin">
                    <button>Log Out</button>
                </a>
            </div>
        </div>
        <x-footer />
    </div>
</body>