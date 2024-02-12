@extends('layout')
@section('title','admin page')
@section('content')
<!-- Blade view -->
<h1>admin dashboard

</h1>
<div class="container">
    <div class="mt-5">
        @if($errors->any())
        <div class="col-12">
            @foreach ( $errors->all() as $error)
            <div class="alert alert-danger">
                {{$error}}
            </div>

            @endforeach
        </div>
        @endif

        @if(session()->has('error'))
        <div class="alert alert-danger">
            {{session('error')}}
        </div>
        @endif

        @if(session()->has('success'))
        <div class="alert alert-success">
            {{session('success')}}
        </div>
        @endif
    </div>
    <table class="table">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Edit</th>
                <th>Delete</th>
                <th>Status</th>
                <th>Change password</th>
            </tr>
        </thead>
        @foreach ($details as $detail)
        <tbody>
            <tr>
                <td>{{$detail->id}}</td>
                <td>{{$detail->name}}</td>
                <td>{{$detail->email}}</td>
                <td>
                    <a href="{{route('admin.edit' , ['detail'=>$detail])}}">Edit</a>
                </td>
                <td>
                    <form method="post" action="{{ route('admin.destroy', ['detail' => $detail]) }}">
                        @csrf
                        @method('delete')
                        <input type="submit" value="Delete">
                    </form>
                </td>

                <td>
                    @if($detail->status == 'active')
                    <form method="post" action="{{ route('admin.deactivate', ['detail' => $detail]) }}">
                        @csrf
                        {{ method_field('PUT') }}
                        <button type="submit">Deactivate</button>
                    </form>
                    @else
                    <form method="post" action="{{ route('admin.activate', ['detail' => $detail]) }}">
                        @csrf
                        {{ method_field('PUT') }}
                        <button type="submit">Activate</button>
                    </form>
                    @endif
                </td>
                <td>
                <a href="{{ route('admin.change-password.form', ['user' => $detail->id]) }}">Change Password</a>
                </td>


            </tr>
        </tbody>

        @endforeach
    </table>
</div>

@endsection
