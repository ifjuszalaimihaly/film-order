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
                        <th scope="col">User name</th>
                        <th scope="col">Status</th>

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
                            <td>{{$order->user->name}}</td>
                            <td>
                                    <form class="form-inline"
                                          action="{{route('admin.order-status.update',$order->film->id)}}"
                                          method="post">
                                        {{csrf_field()}}
                                        <input name="_method" type="hidden" value="PUT">
                                        <select class="form-control mr-1" id="status_id" name="status_id">
                                            @foreach($statuses as $status)
                                                <option value="{{$status->id}}"
                                                @if($status->id == $order->film->status->id) selected @endif>
                                                    {{$status->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                        <input type="submit" class="btn btn-success" value="Change">
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
