@extends('layouts.adminPanel')

@section('title') Страница управления данными @stop

@section('content')

    @include('admin.manage.alert')

    @include('admin.manage.sub-nav')
    @include('admin.manage.categories.nav')

    <div class="container">

        <div class="text-center" style="margin-bottom: 30px;">
            <h2>Страница просмотра категорий</h2>
        </div>

        <div class="row">

            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Название</th>
                    <th>Кем было сделано</th>
                    <th>Дата создания</th>
                    <th>Дата обновления</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                @foreach( $categories as $category )

                    <tr id="category_{{ $category->id }}">

                        <td>
                            @if(isset($category->parent->parent))
                                {{$category->parent->parent->category_name}}
                                > {{$category->parent->category_name}}
                                > {{$category->category_name}}
                            @elseif(isset($category->parent))
                                {{$category->parent->category_name}}
                                > {{$category->category_name}}
                            @else{{$category->category_name}}
                            @endif
                        </td>

                        <td>{{ $category->user->name }}</td>
                        <td>{{ $category->created_at }}</td>
                        <td>{{ $category->updated_at }}</td>
                        @if(! $category->parent_id == 0)
                        <td>
                            <a href="{{ url( '/admin/manage/categories/update/' . $category->id ) }}">Редактировать</a>
                        </td>
                        @endif
                    </tr>

                @endforeach

                </tbody>
            </table>

        </div>
    </div>

    <script type="text/javascript" src="{{ url('/js/admin/manage/categories/main.js') }}"></script>

@endsection