<head>
    <title>Course and University Recommendation System: University List</title>

    <style>
        .pagination {
            margin-top: 20px;
            text-align: center;
        }

        .pagination nav > div {
            display: inline-block;
        }
    </style>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>
    <x-header title="University List"/>
    <div>
        <div id="create">
            <form action="{{ route('university.list') }}" method="GET" class="create">
                <input type="text" name="search" class="search" placeholder="Search University" value="{{ request('search') }}"></input>
                <button type="submit">Search</button>
            </form>
        </div>

        <div id="create">
            <form action="{{ route('university.create') }}" method="GET">
                <button type="submit" class="create">New University</button>
            </form>
        </div>

        <div>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>University Name</th>
                        <th>Campus</th>
                        <th>University Type</th>
                        <th>Ranking QS</th>
                        <th>Ranking THE</th>
                        <th>Admin</th>

                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ( $universities as $university)
                    <tr>
                        <td>{{ $university->id }}</td>
                        <td>{{ $university->uni_name }}</td>
                        <td>{{ $university->campus }}</td>
                        <td>{{ $university->uni_type }}</td>
                        <td>
                            @if( $university->ranking_qs_no_start && !$university->ranking_qs_no_end )
                                {{ $university->ranking_qs_no_start }} ({{ $university->ranking_qs_year }})
                            @elseif( $university->ranking_qs_no_start && $university->ranking_qs_no_end )
                                {{ $university->ranking_qs_no_start }} to {{ $university->ranking_qs_no_end }} ({{ $university->ranking_qs_year }})
                            @else  
                                None 
                            @endif
                        </td>
                        <td>
                            @if( $university->ranking_the_no_start && !$university->ranking_the_no_end )
                                {{ $university->ranking_the_no_start }} ({{ $university->ranking_the_year }})
                            @elseif( $university->ranking_the_no_start && $university->ranking_the_no_end )
                                {{ $university->ranking_the_no_start }} to {{ $university->ranking_the_no_end }} ({{ $university->ranking_the_year }})
                            @else
                                None 
                            @endif
                        </td>
                        <td>{{ $university->admin_id }}</td>

                        <td>
                            <a href="{{ route('university.show', $university->id) }}">
                                <button class="Detail">Detail</button>
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('university.edit', $university->id) }}">
                                <button class="update">Update</button>
                            </a>
                        </td>
                        <td>
                            <form action="{{ route('university.destroy', $university->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="delete" onclick="return confirm('Comfirm to delete?');">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div>
            {{ $universities->appends(['search' => request('search')])->links('pagination::bootstrap-4')  }}
        </div>

        <div id="">
            <a href="/adminMenu" id="">
                <button id="">Back</button>
            </a>
        </div>
    </div>
    <x-footer />
</body>