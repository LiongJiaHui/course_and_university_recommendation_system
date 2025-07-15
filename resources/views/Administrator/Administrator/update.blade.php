<head>
    <title>Course and University Recommendation System: Update the Adminsitrator Details</title>

</head>

<body>
    <x-header title="Update the Administrator"/>
    <div>
        <div>
            <form method="POST">
                @csrf

                <div class="container">
                    <label>Admin Name: </label>
                    <input name="admin_name" type="text" value="{{ old('admin_name'), $admin->admin_name }}" required></input>
                    <br>
                </div>

                <div class="container">
                    <label>Password: </label>
                    <input name="password" type="text" value="{{ old('password'), $admin->password }}" required></input>
                    <br>
                </div>

                <div>
                    <button type="submit">Submit</button>
                </div>
            </form>
        </div>
        <div id="">
            <a href="">
                <button >Back</button>
            </a>
        </div>
    </div>
    <x-footer />
</body>