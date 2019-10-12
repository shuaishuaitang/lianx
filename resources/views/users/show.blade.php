@extends('layouts.default')
@section('title', $user->name)
@section('content')
    <div style="margin-top: 100px;"></div>
    {{ $user->name }} - {{ $user->email }}

    <div class="row">
        <div class="col-md-offset-2 col-md-8">
            <div class="col-md-12">
                <div class="col-md-offset-2 col-md-8">
                    <section class="user_info">
                        @include('shared.user_info', ['user' => $user])
                    </section>
                    <section class="stats">
                        @include('shared.status', ['user' => $user])
                    </section>
                </div>
            </div>
            <div class="col-md-12">
                @if (Auth::check())
                    @include('users.follow_form')
                @endif
                @if (count($statuses) > 0)
                    <ol class="statuses">
                        @foreach ($statuses as $status)
                            @include('statuses.status')
                            {{--@include('statuses.status')--}}
                        @endforeach
                    </ol>
                {{--输出分页写法--}}
                    {!! $statuses->render() !!}
                @endif
            </div>
        </div>
    </div>
@stop