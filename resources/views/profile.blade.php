@extends('layouts.main')
@section('content')
    <div class="container product_section_container" style="padding: 30px;">
        <div class="row">
            <div class="col-md-12">
                    @foreach($userDetails as $userDetail)
                        <tr>
                            <td>Name :<br></td>
                            <td>{{ $userDetail->user->name }} {{ $userDetail->user->surname }} <br><br></td>
                            <td>Email :<br></td>
                            <td>{{ $userDetail->user->email }} <br><br></td>
                            <td>Address :<br></td>
                            <td>{{ $userDetail->phone }} <br><br></td>
                            <td>Mobile :<br></td>
                            <td>{{ $userDetail->m_phone }} <br><br></td>
                            <td>City :<br></td>
                            <td>{{ $userDetail->address }} <br><br></td>
                            <td>Phone :<br></td>
                            <td>{{ $userDetail->city }} <br><br></td>
                            <td>Country :<br></td>
                            <td>{{ $userDetail->country }} <br><br></td>
                            <td>Zip Code :<br></td>
                            <td>{{ $userDetail->zipcode }} <br><br></td>
                            <td>
                                <a href="/profile/{{$userDetail->id}}/edit" class="btn btn-primary"><i class="fa fa-edit"> Edit Profile<br></i></a>
                            </td>
                        </tr>
                    @endforeach
            </div>
        </div>
    </div>
@endsection
