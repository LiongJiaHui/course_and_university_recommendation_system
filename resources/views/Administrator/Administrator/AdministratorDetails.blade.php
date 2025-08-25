<head>
    <title>Course and University Recommendation System: Details of the administrator</title>
    <link rel="stylesheet" href="{{ asset('css/admin_details.css') }}">
</head>

<body>
    <x-header title="Details of the Administrator" />
    <div>
        <div>
            <div>
                <h3>Showing Admin ID: {{ $admin->id }}</h3>
            </div>

            <div>
                <table>
                    <tr>
                        <td>Admin ID: </td>
                        <td>{{ $admin->id }}</td>
                    </tr>

                    <tr>
                        <td>Password: </td>
                        <td>{{ $admin->password }}</td>
                    </tr>

                    <tr>
                        <td>
                            <a href="{{ route('admin.edit', $admin->id) }}">
                                <button class="update">Update</button>
                            </a>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div>
            <a href="{{ route('admin.list') }}">
                <button id="back">Back</button>
            </a>
        </div>
    </div>
    <x-footer />
</body>