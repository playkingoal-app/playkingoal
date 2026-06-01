@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @livewire('grupos.unirse-grupo', ['grupo' => $grupo])
            </div>
        </div>
    </div>
@endsection
