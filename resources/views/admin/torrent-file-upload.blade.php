@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @if(session("message"))
                    <div class="alert alert-success alert-dismissible fade show"
                         role="alert">
                        <ul>
                            <li>{{session("message")}}</li>
                        </ul>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">Original Title</th>
                        <th scope="col">Translated Title</th>
                        <th scope="col">Release Year</th>
                        <th scope="col">Imdb</th>
                        <th scope="col">Rating</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>{{$order->film->original_title}}</td>
                            <td>{{$order->film->translated_title}}</td>
                            <td>{{$order->film->release_year}}</td>
                            <td>{{$order->film->imdb}}</td>
                            <td>{{$order->film->rating}}</td>

                            <td>
                                <form class="form-inline"
                                      action="{{route('admin.torrentfileupload.upload',$order->film->id)}}"
                                      method="post" enctype="multipart/form-data">
                                    {{csrf_field()}}
                                    <input class="form-control mr-1" id="torrentfile" name="torrentfile" type="file">
                                    <input type="submit" class="btn btn-success" value="Upload">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{$orders->links()}}
            </div>
        </div>
    </div>
@endsection
