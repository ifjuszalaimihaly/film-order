@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">Original Title</th>
                        <th scope="col">Translated Title</th>
                        <th scope="col">Release Year</th>
                        <th scope="col">Rating</th>
                        <th scope="col">Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($films as $film)
                        <tr>
                            <td>{{$film->original_title}}</td>
                            <td>{{$film->translated_title}}</td>
                            <td>{{$film->release_year}}</td>
                            <td>{{$film->rating}}</td>
                            <td>{{$film->status->name}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
