<head>
    <title>Course and University Recommendation System: University List</title>


</head>

<body>
    <x-header title="University List"/>
    <div>
        <div id="create">
            <form action="{{ route('') }}" method="GET" class="create">
                <input type="text" name="search" class="search" placeholder="Search Course" value="{{ request('search') }}"></input>
                <button type="submit">New Course</button>
            </form>
        </div>

        <div>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>University Name</th>
                        <th>Campus</th>
                        <th>Ranking QS</th>
                        <th>Ranking THE</th>
                        <th>Website</th>
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
                        <td>{{ $university->website }}</td>
                        <td>{{ $university->admin_id }}</td>

                        <td>
                            <a href="{{ route('') }}">
                                <button class="Detail">Detail</button>
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('') }}">
                                <button class="update">Update</button>
                            </a>
                        </td>
                        <td>
                            <form action="{{ route('') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div id="">
            <a href="" id="">
                <button id="">Back</button>
            </a>
        </div>
    </div>
    <x-footer />
</body>