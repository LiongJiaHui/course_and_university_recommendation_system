<head>
    <title>Course and University Recommendation System: Update the Adminsitrator Details</title>

</head>

<body>
    <x-header title="Update the Administrator"/>
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
            <form action="{{ route('admin.update', $admin->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="container">
                    <label>Admin Name: </label>
                    <input name="admin_name" type="text" value="{{ old('admin_name', $admin->admin_name) }}" required></input>
                    <br>
                </div>

                <div class="container">
                    <label>Password: </label>
                    <input name="password" type="password" value="{{ old('password') }}" required></input>
                    <br>
                </div>

                <div>
                    <button type="submit">Submit</button>
                </div>
            </form>
        </div>
        <div id="back_button">
            <a href="{{ route('admin.list') }}">
                <button id="back_button">Back</button>
            </a>
        </div>
    </div>
    <x-footer />
</body>