@extends('layouts.adminPanel')

@section('title') Страница управления размерными сетками @stop

@section('content')

    @include('admin.manage.sub-nav')
    @include('admin.manage.size_chart.nav')

    <div class="container">

        <div class="text-center" style="margin-bottom: 30px;">
            <h2>Страница изменения размерных сеток</h2>
        </div>

        <div class="row">

            <div class="col-md-3"></div>
            <div class="col-md-6">

                <form action="{{ url('/admin/manage/size_chart/update') }}" method="post">

                    {{ csrf_field() }}

                    <label for="brand_id">Выберите бренд</label>
                    <select id="brand_id" name="brand_id" size="1" class="form-control">
                        @foreach($brands as $brand)
                            @if($brand->id === $sizeChart->brand->id)
                                <option selected value="{{$brand->id}}">
                                    {{$brand->brand_name}}
                                </option>
                            @else
                                <option value="{{$brand->id}}">
                                    {{$brand->brand_name}}
                                </option>
                            @endif
                        @endforeach
                    </select>

                    <label for="category_id">Выберите категорию</label>
                    <select id="category_id" name="category_id" size="1" class="form-control">
                        @foreach($categories as $category)
                            @if($category->id === $sizeChart->category->id)
                                <option selected value="{{$category->id}}">{{$category->category_name}}
                                    /{{$category->parent1->category_name}}
                                    /{{$category->parent2->category_name}}
                                </option>
                                @else
                                <option value="{{$category->id}}">{{$category->category_name}}
                                    /{{$category->parent1->category_name}}
                                    /{{$category->parent2->category_name}}
                                </option>
                            @endif


                        @endforeach
                    </select>

                    <label for="size_id">Выберите международный размер</label>
                    <select id="size_id" name="size_id" size="1" class="form-control">
                        @foreach($sizes as $size)
                            @if($size->id === $sizeChart->size->id)
                                <option selected value="{{$size->id}}">
                                    {{$size->name}}
                                </option>
                                @else
                                <option value="{{$size->id}}">
                                    {{$size->name}}
                                </option>
                            @endif

                        @endforeach
                    </select>

                    <label for="brand_size">Размер производителя</label>
                    <input type="number" step="1" class="form-control" name="brand_size" id="brand_size"
                           value="{{$sizeChart->brand_size}}"/>

                    @foreach($measurementsNames as $measurementsName)
                        <div class="checkbox">
                                @if(in_array($measurementsName->id, $sizeChart->measurements->pluck('measurements_names_id')->toArray()))
                                    <label><input checked type="checkbox" name="nameIds[]"
                                                  value="{{$measurementsName->id}}"
                                        >{{$measurementsName->name}}</label>
                                @else
                                    <label><input type="checkbox" name="nameIds[]"
                                                  value="{{$measurementsName->id}}"
                                        >{{$measurementsName->name}}</label>
                                @endif
                        </div>

                        <label for="values[]">Параметр</label>
                        @if(in_array($measurementsName->id, $sizeChart->measurements->pluck('measurements_names_id')->toArray()))
                             <input type="text" name="values[]" id="values-{{$measurementsName->id}}"
                                    value="{{$sizeChart->measurements->where('measurements_names_id', $measurementsName->id )->first()->value}}">
                        @else
                            <input type="text" name="values[]" id="values-{{$measurementsName->id}}" value="">

                        @endif
                    @endforeach

                    <input type="hidden" name="size_chart_id" value="{{ $sizeChart->id }}" />

                    <div class="text-center">
                        <button class="btn btn-default" style="margin-top: 25px;">Добавить размерную сетку</button>
                    </div>
                </form>

            </div>
            <div class="col-md-3"></div>

        </div>

    </div>

@endsection