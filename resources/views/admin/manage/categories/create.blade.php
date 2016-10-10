@extends('layouts.adminPanel')

@section('title') Страница управления данными @stop

@section('content')

    @include('admin.manage.sub-nav')
    @include('admin.manage.categories.nav')

    <div class="container">

        <div class="text-center" style="margin-bottom: 30px;">
            <h2>Страница добавления категорий</h2>
        </div>

        <div class="row">

            <div class="col-md-3"></div>
            <div class="col-md-6">

                <form action="{{ url('/admin/manage/categories/create') }}" method="post">

                    {{ csrf_field() }}

                    <label for="category_name">Имя категории</label>
                    <input type="text" class="form-control" name="category_name" id="category_name"/>


                    <label for="category_parent_id">Выберите родительскую категорию</label>
                    <select id="category_parent_id" name="category_parent_id" size="1" class="form-control">
                        @foreach($categories as $category)

                            <option value="{{$category->id}}">{{$category->category_name}}
                                @if(isset($category->parent))/{{$category->parent->category_name}}
                                @endif
                            </option>

                        @endforeach
                    </select>

                    <div class="text-center">
                        <button class="btn btn-default" style="margin-top: 25px;">Добавить категорию</button>
                    </div>
                </form>

            </div>
            <div class="col-md-3"></div>

        </div>

    </div>

@endsection