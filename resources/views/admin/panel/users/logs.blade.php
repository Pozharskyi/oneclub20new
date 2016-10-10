
<div class="row">

    <div class="col-md-12">
        <div id="userLogSection">
            <table id="userLogTable" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <td>Дата</td>
                    <td>Событие</td>
                </tr>
                </thead>
                <tbody id="userLogTbody">
                @foreach($userLogs as $userLog)
                    <tr>
                        <td>{{$userLog->date}}</td>

                        <td>{{$userLog->logAction->name}} поле {{$userLog->field_changed}} пользователя -
                            {{ $userLog->user->name}}
                             c {{$userLog->fromto->from}} на {{$userLog->fromto->to}}. Автор
                            - {{$userLog->author->name}}
                        </td>
                    </tr>

                @endforeach

                </tbody>
            </table>
            {{$userLogs->links()}}
        </div>
    </div>
</div>