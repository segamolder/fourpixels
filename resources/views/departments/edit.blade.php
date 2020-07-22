@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ $title }}</div>
                    <div class="card-body">
                        <department-edit
                            :users="{{$users}}"
                            :lang="{{json_encode(trans('custom.edit_form', []))}}"
                            <?if (isset($department)) {?>
                            :departament="{{json_encode($department)}}"
                            edit_route="{{route('department.update', $department->id)}}"
                            <?}?>
                            store_route="{{route('department.store')}}"
                        >
                        </department-edit>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
