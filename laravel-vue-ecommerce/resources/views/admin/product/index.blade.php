@extends('layouts.admin')

@section('content')
    <div class="card" style="margin-left: 250px;">
        <div class="card-header">
            <h4>Product Page</h4>
            <hr/>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $item)
                        <tr>
                            <td>{{$item->id}}</td>
                            <td>{{$item->name}}</td>
                            <td style="max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                {{$item->description}}</td>
                            <td>
                                <img src="{{asset('assets/uploads/products/'.$item->image)}}" alt="Image here" class="w-55">
                            </td>
                            <td>
                                <a href="{{url('delete-product/'.$item->id)}}" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>    
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
