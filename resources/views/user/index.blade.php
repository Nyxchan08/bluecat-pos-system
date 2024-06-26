@extends('layout.main')
@section('content')


<div id="create-button">
    <a href="/user/create"><img src="{{ asset('img/user-add.png')}}" alt="user-add">add user</a>
</div>
<div class="content-list">
    <div class="table-responsive">
        <table class="table  table-sm table-hover">
            <thead id="table-heading">
                <tr>
                    <th>First name</th>
                    <th>Middle name</th>
                    <th>Last name</th>
                    <th>Suffix</th>
                    <th>Gender</th>
                    <th>Birthday</th>
                </tr>
            </thead>
            @include('include.message')
            <tbody class="table-group-divider">
                @foreach ($users as $user)
                <tr onclick="window.location='/user/show/{{$user->user_id}}';" style="cursor:pointer;">
                    <td>{{ $user->first_name }}</td>
                    <td>{{ $user->middle_name }}</td>
                    <td>{{ $user->last_name }}</td>
                    <td>{{ $user->suffix_name }}</td>
                    <td>{{ $user->gender->gender }}</td>
                    <td>{{ $user->birth_date }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination-container">
            {{ $users->links() }}
        </div>
    </div>
</div>

@endsection
