@extends('layouts.adminPanel')

@section('title') Страница управления размерными сетками @stop

@section('content')

    @include('admin.manage.sub-nav')
    @include('admin.manage.size_chart.nav')

    <div class="container">

        <div class="text-center" style="margin-bottom: 30px;">
            <h2>Страница добавления размерных сеток</h2>
        </div>

        <div class="row">

            <div class="col-md-3"></div>
            <div class="col-md-6">

                <form action="{{ url('/admin/manage/size_chart/create') }}" method="post">

                    {{ csrf_field() }}

                    <label for="brand_id">Выберите бренд</label>
                    <select id="brand_id" name="brand_id" size="1" class="form-control">
                        @foreach($brands as $brand)
                            <option value="{{$brand->id}}">
                                {{$brand->brand_name}}
                            </option>
                        @endforeach
                    </select>

                    <label for="category_id">Выберите категорию</label>
                    <select id="category_id" name="category_id" size="1" class="form-control">
                        @foreach($categories3level as $category)
                            <option value="{{$category->id}}">{{$category->category_name}}
                                /{{$category->parent1->category_name}}
                                /{{$category->parent2->category_name}}
                            </option>

                        @endforeach
                    </select>

                    <label for="size_id">Выберите международный размер</label>
                    <select id="size_id" name="size_id" size="1" class="form-control">
                        @foreach($sizes as $size)
                            <option value="{{$size->id}}">
                                {{$size->name}}
                            </option>
                        @endforeach
                    </select>

                    <label for="brand_size">Размер производителя</label>
                    <input type="number" step="1" class="form-control" name="brand_size" id="brand_size" />

                    @foreach($names as $name)
                        <div class="checkbox">
                            <label><input type="checkbox" name="nameIds[]"
                                          value="{{$name->id}}"
                                >{{$name->name}}</label>
                        </div>

                        <label for="values[]">Параметр</label>
                        <input type="text" name="values[]" id="values-{{$name->id}}">
                    @endforeach

                    <div class="text-center">
                        <button class="btn btn-default" style="margin-top: 25px;">Добавить размерную сетку</button>
                    </div>
                </form>

            </div>
            <div class="col-md-3"></div>

        </div>

    </div>

@endsection