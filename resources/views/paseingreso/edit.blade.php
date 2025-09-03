@extends('layouts.app')

@section('template_title')
    {{ __('Update') }} Paseingreso
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Update') }} Paseingreso</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('paseingresos.update', $paseingreso->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('paseingreso.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
