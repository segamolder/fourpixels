@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="card-header">{{ $title }}</div>
                    <div class="card-body">
                        <form action="{{isset($user)?route('user.update', $user->id):route('user.store')}}" method="post">
                            @csrf
                            @if(isset($user))
                                @method('PUT')
                            @endif
                            <div class="form-group">
                                <label for="input-name">{{__('custom.edit_form.name')}}</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="input-name"
                                    placeholder="{{__('custom.edit_form.enter_value').__('custom.edit_form.name')}}"
                                    name="name"
                                    value="{{isset($user)?$user->name:''}}">
                            </div>
                            <div class="form-group">
                                <label for="input-email">{{__('E-mail')}}</label>
                                <input
                                    type="email"
                                    class="form-control"
                                    id="input-email"
                                    placeholder="{{__('custom.enter_email')}}"
                                    name="email"
                                    value="{{isset($user)?$user->email:''}}">
                            </div>
                            <div class="form-group">
                                <label for="input-password">{{__('custom.password')}}</label>
                                <input type="password"
                                       class="form-control"
                                       id="input-password"
                                       name="password"
                                       placeholder="{{__('custom.enter_password')}}">
                            </div>
                            <button type="submit" class="btn btn-primary">{{__('custom.edit_form.save')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
