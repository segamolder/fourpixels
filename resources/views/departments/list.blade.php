@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>{{ __('custom.departments') }}</span>
                            <a href="{{route('department.create')}}" class="btn btn-primary">{{__('custom.add')}}</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="list-group">
                            @foreach($departments as $department)
                                <department-item
                                    image_path="logo/"
                                    edit_button="{{__('custom.edit')}}"
                                    delete_button="{{__('custom.remove')}}"
                                    edit_route="{{route('department.edit', $department->id)}}"
                                    delete_route="{{route('department.destroy', $department->id)}}"
                                    :department="{{$department}}"
                                >
                                </department-item>
                            @endforeach

                            <ul class="pagination mt-2">
                                <li class="page-item {{ ($departments->currentPage() == 1) ? ' disabled' : '' }}">
                                    <a class="page-link" href="{{ $departments->url(1) }}">{{__('custom.previous')}}</a>
                                </li>
                                @for ($i = 1; $i <= $departments->lastPage(); $i++)
                                    <li class="page-item {{ ($departments->currentPage() == $i) ? ' active' : '' }}">
                                        <a class="page-link" href="{{ $departments->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor
                                <li class="page-item {{ ($departments->currentPage() == $departments->lastPage()) ? ' disabled' : '' }}">
                                    <a class="page-link" href="{{ $departments->url($departments->currentPage()+1) }}" >{{__('custom.next')}}</a>
                                </li>
                            </ul>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
