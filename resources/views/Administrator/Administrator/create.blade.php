<head>
    <title>Course And University Recommendation System: Creation of the Administrator</title>
    <link rel="stylesheet" href="{{ asset('css/admin_create.css') }}">
</head>

<body>
    <x-header title="Creation of the Administrator"/>

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
            <form action="{{ route('admin.store') }}" method="POST">
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
                    <button type="submit" id="submit">Create admin</button>
                    <br>
                </div>
            </form>
        </div>
        <div>
            <a href="{{ route('admin.list') }}">
                <button id="back">Back</button>
            </a>
        </div>
    </div>
    <x-footer />
</body>