@if( $qty == 0)

    <h3 style="color: rgb(240, 0, 140);">Результатов не найдено</h3>

@else

    @php $i = 0 @endphp

    @foreach( $collection as $item )

        @if( $i == 0 || $i % 3 == 0 )
            <div class="row">
        @endif

            <div class="col-md-4">

                <a href="/list/{{ $item->subProduct->product->product_store_id }}/{{ $item->subProduct->color->id }}">
                    <img src="{{ $item->subProduct->photos[0]->photo }}" style="width: 100%;" />
                </a>

                <h4>{{ $item->subProduct->product->description->product_name }}</h4>
                <h5>{{ $item->subProduct->product->brand_name }}</h5>

                <div style="width: 100%; height: 40px;">
                    <div class="pull-left" style="margin-right: 25px;">
                        <h4 style="color: #555;">
                            <strike>{{ $item->subProduct->price->final_price }} грн.</strike>
                        </h4>
                    </div>

                    <div class="pull-left">
                        <h4 style="color: rgb(240, 0, 140);">
                            {{ $item->subProduct->price->special_price }} грн.
                        </h4>
                    </div>
                </div>

                <h5>{{ $item->colorsCount }}

                    @if( $item->colorsCount == 1 )
                        цвет
                    @else
                        цветов
                    @endif

                </h5>

            </div>

        @if( $i == 2 || $i % 3 == 2 )
            </div>
        @endif

        @php $i++ @endphp

    @endforeach

@endif