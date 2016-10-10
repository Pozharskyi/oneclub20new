<div class="row">
    <div class="col-md-12">

        <div id="userLogSection" class="">
            <table id="orderLogTable" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <td>Дата</td>
                    <td>Событие</td>
                </tr>
                </thead>
                <tbody id="orderLogTbody">
                @foreach($orderLogs as $orderLog)
                    <tr>
                        <td>{{$orderLog->date}}</td>

                        <td>{{$orderLog->logAction->name}} поле {{$orderLog->field_changed}}
                            {{ $orderLog->loggable_type}}
                            заказа № {{$order->public_order_id}} c
                            {{$orderLog->fromto->from}} на {{$orderLog->fromto->to}}. Автор
                            - {{$orderLog->author->name}}
                        </td>
                    </tr>

                @endforeach
                </tbody>
            </table>
            {{$orderLogs->links()}}
        </div>
    </div>
</div>