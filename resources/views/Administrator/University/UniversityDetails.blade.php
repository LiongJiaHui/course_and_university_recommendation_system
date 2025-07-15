<head>
    <title>Course and University Recommendation System: Details of the University</title>

</head>

<body>
    <x-header title="University Details" />
    <div>
        <div>
            <h3>Showing University ID: {{ $university->id }}</h3>
        </div>

        <div>
            <table>
                <tr>
                    <td>University ID: </td>
                    <td>{{ $university->id }}</td>
                </tr>

                <tr>
                    <td>University Name: </td>
                    <td>{{ $university->uni_name }}</td>
                </tr>

                <tr>
                    <td>University Address: </td>
                    <td>{{ $university->uni_address }}</td>
                </tr>

                <tr>
                    <td>Campus: </td>
                    <td>{{ $university->campus }}</td>
                </tr>

                <tr>
                    <td>Website: </td>
                    <td>{{ $university->website }}</td>
                </tr>

                <tr>
                    <td>University Type: </td>
                    <td>{{ $university->uni_type }}</td>
                </tr>

                <tr>
                    <td>Contact Number: </td>
                    <td>{{ $university->contact_no }}</td>
                </tr>

                <tr>
                    <td>Email: </td>
                    <td>{{ $university->email }}</td>
                </tr>

                <tr>
                    <td>Ranking QS: </td>
                    <td>
                        @if( $university->ranking_qs_no_start && !$university->ranking_qs_no_end )
                            {{ $university->ranking_qs_no_start }} ({{ $university->ranking_qs_year }})
                        @elseif( $university->ranking_qs_no_start && $university->ranking_qs_no_end )
                            {{ $university->ranking_qs_no_start }} to {{ $university->ranking_qs_no_end }} ({{ $university->ranking_qs_year }})
                        @else
                            None 
                        @endif
                    </td>
                </tr>

                <tr>
                    <td>Ranking THE: </td>
                    <td>
                        @if( $university->ranking_the_no_start && !$university->ranking_the_no_end )
                            {{ $university->ranking_the_no_start }} ({{ $university->ranking_the_year }})
                        @elseif( $university->ranking_the_no_start && $university->ranking_the_no_end )
                            {{ $university->ranking_the_no_start }} to {{ $university->ranking_the_no_end }} ({{ $university->ranking_the_year }})
                        @else
                            None 
                        @endif
                    </td>
                </tr>

                <tr>
                    <td>Admin: </td>
                    <td>{{ $university->admin_id }}</td>
                </tr>

                <tr>
                    <td>State: </td>
                    <td>{{ $university->state_id }}</td>
                </tr>

                <tr>
                    <td>Area: </td>
                    <td>{{ $university->area_id }}</td>
                </tr>

                <tr>
                    <td>
                        <form action="{{  }}" method="POST">
                            <button id="update">Update</button>
                        </form>
                    </td>
                    <td>
                        <form action="{{  }}" method="POST">
                            <button id="delete">Delete</button>
                        </form>
                    </td>
                </tr>
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