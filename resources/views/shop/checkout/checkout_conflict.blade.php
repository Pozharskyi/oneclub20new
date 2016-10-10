<div class="container">

    <div class="text-center">
        <h1>Конфликт предметов</h1>

        <div style="width: 60%; height: 1px; margin: 30px auto 30px auto; background-color: #e4e4e4;"></div>
    </div>

    <form action="{{ url('/checkout/conflict') }}" method="post" id="conflict_form">

        @foreach( $conflicts as $conflict )

            <div class="row" id="sub_item_{{ $conflict->id }}">
                <div class="col-md-2">
                    <img src="{{ $conflict->subProduct->photos[0]->photo }}" style="width: 100%" />
                </div>
                <div class="col-md-3">
                    <h2>{{ $conflict->subProduct->product->description->product_name }}</h2>

                    <div style="width: 100%; height: 40px;">
                        <div class="pull-left" style="margin-right: 25px;">
                            <h4 style="color: #555;">
                                <strike>{{ $conflict->subProduct->product->price[0]->final_price }} грн.</strike>
                            </h4>
                        </div>

                        <div class="pull-left">
                            <h4 style="color: rgb(240, 0, 140);">
                                {{ $conflict->subProduct->product->price[0]->special_price }} грн.
                            </h4>
                        </div>
                    </div>

                    <h4>Цвет: {{ $conflict->subProduct->color->name }}</h4>
                    <h4>Размер: {{ $conflict->subProduct->size->name }}</h4>
                </div>
                <div class="col-md-3">

                    <h4>Всего: <b>{{ $conflict->total }} шт.</b></h4>
                    <h4>В резерве у других пользователей: <b>{{ $conflict->reserved }} шт.</b></h4>
                    <h4>Нужно: <b>{{ $conflict->needle }} шт.</b></h4>
                    <h4>Доступно: <b>{{ $conflict->available }} шт.</b></h4>

                    <select class="form-control" name="baskets_awp_qty_{{ $conflict->id }}">

                        @for( $i = 1; $i < $conflict->available + 1; $i++ )
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor

                    </select>
                </div>
                <div class="col-md-1">

                    <h2>
                        <a href="javascript: void(0);" onclick="deleteItem( {{ $conflict->id }});">Удалить</a>
                    </h2>

                </div>
            </div>

            <input type="hidden" name="baskets_awp_ms[]" value="{{ $conflict->id }}" />

            <div style="margin-top: 35px; margin-bottom: 35px; width: 100%; height: 1px; background-color: rgb(240, 0, 140);"></div>

        @endforeach

        <input type="hidden" name="conflicts_count" value="{{ $count }}" />
    </form>

    <div class="text-center" style="margin-top: 40px; margin-bottom: 40px;">
        <a href="{{ url('/basket') }}">
            <button type="button" onclick="closePopup();" class="btn btn-default">Обратно</button>
        </a>
        <button type="button" onclick="resolveConflict();" class="btn btn-primary">Перейти к оформлению</button>
    </div>

</div>