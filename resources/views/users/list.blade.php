@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    @if(isset($message))
                        <div class="alert alert-primary" role="alert">
                            {{$message}}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>{{ __('custom.users') }}</span>
                            <a href="{{route('user.create')}}" class="btn btn-primary">{{__('custom.add')}}</a>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="list-group">
                            @foreach($users as $user)
                                <div
                                    class="list-group-item list-group-item-action flex-column align-items-start">
                                    <div class="row d-flex justify-content-between align-items-center">
                                        <div class="col-sm-12 col-md-3">
                                            {{$user->name}}
                                        </div>
                                        <div class="col-sm-12 col-md-3 d-flex flex-column">
                                            {{$user->email}}
                                        </div>
                                        <div class="col-sm-12 col-md-3">
                                            {{$user->created_at}}
                                        </div>
                                        <div class="col-sm-12 col-md-3 d-flex">
                                            <form method="POST" action="{{route('user.edit', $user->id)}}">
                                                {{ csrf_field() }}
                                                {{ method_field('GET') }}

                                                <div class="form-group mb-0 mr-2">
                                                    <input type="submit" class="btn btn-secondary"
                                                           value="{{__('custom.edit')}}">
                                                </div>
                                            </form>
                                            <form method="POST" action="{{route('user.destroy', $user->id)}}">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}

                                                <div class="form-group mb-0">
                                                    <input type="submit" class="btn btn-danger"
                                                           value="{{__('custom.remove')}}">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <ul class="pagination mt-2">
                                <li class="page-item {{ ($users->currentPage() == 1) ? ' disabled' : '' }}">
                                    <a class="page-link" href="{{ $users->url(1) }}">{{__('custom.previous')}}</a>
                                </li>
                                @for ($i = 1; $i <= $users->lastPage(); $i++)
                                    <li class="page-item {{ ($users->currentPage() == $i) ? ' active' : '' }}">
                                        <a class="page-link" href="{{ $users->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor
                                <li class="page-item {{ ($users->currentPage() == $users->lastPage()) ? ' disabled' : '' }}">
                                    <a class="page-link"
                                       href="{{ $users->url($users->currentPage()+1) }}">{{__('custom.next')}}</a>
                                </li>
                            </ul>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
