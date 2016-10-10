<link rel="stylesheet" type="text/css" href="{{ url('/css/admin/import/sub-nav.css') }}" />
<script src="{{ url('/js/token.js') }}"></script>

<div class="container">
    <div class="row">
        <ul id="nav">
            <li>
                <a href="{{ url('/admin') }}">Заказы</a>
            </li>
            <li>
                <a href="{{ url('/admin/stats/payments') }}">Типы оплат</a>
            </li>
            <li>
                <a href="{{ url('/admin/stats/delivery') }}">Типы доставки</a>
            </li>
            <li>
                <a href="{{ url('/admin/stats/profit') }}">Прибыль</a>
            </li>
        </ul>

        <div class="divider"></div>

    </div>
</div>