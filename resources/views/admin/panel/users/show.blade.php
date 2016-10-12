@extends('layouts.adminPanel')

@section('title') Users @stop

@section('breadcrumb')
    <li><a href={{route('adminTable.users.searchUser')}}>Выбор пользователя</a> <span class="divider"></span></li>
    <li class="active">Данные пользователя</li>
@endsection

@section('content')


    @if (session()->has('message'))
        <div class="alert alert-info">{{session('message')}}</div>
    @endif
    <div class="col-md-6">

        <input class="hidden" id="userId" value="{{$user->id}}">

        <div class="hidden" id="message"></div>

        <div id="updateUser">
            <form id="updateUserForm" action="#">
                <h2>Обновить пользователя</h2>
                <div class="form-group{{ $errors->has('name') ? ' has-error' : ''}}">
                    Полное имя:
                    <input id="name" type="text" class="form-control" name="name" value='{{$user->name}}'>
                    @if ($errors->has('name'))
                        <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('email') ? ' has-error' : ''}}">
                    Email:
                    <input id="email" type="text" class="form-control" name="email" value='{{$user->email}}'>
                    @if ($errors->has('email'))
                        <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('f_name') ? ' has-error' : ''}}">
                    Имя:
                    <input id="f_name" type="text" class="form-control" name="f_name" value='{{$user->f_name}}'>
                    @if ($errors->has('f_name'))
                        <span class="help-block">
                        <strong>{{ $errors->first('f_name') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('l_name') ? ' has-error' : ''}}">
                    Фамилия:
                    <input id="l_name" type="text" class="form-control" name="l_name" value='{{$user->l_name}}'>
                    @if ($errors->has('l_name'))
                        <span class="help-block">
                        <strong>{{ $errors->first('l_name') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('phone') ? ' has-error' : ''}}">
                    Телефон:
                    <div class="form-inline">
                        <label>+380</label>
                        <input id="phone" type="text" class="form-control" name="phone" value='{{$user->phone}}'>
                        @if ($errors->has('phone'))
                            <span class="help-block">
                                  <strong>{{ $errors->first('phone') }}</strong>
                                 </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('gender') ? ' has-error' : ''}}">
                    Пол:
                    <select id="gender" name="gender" size="1" class="form-control">
                        <option @if($user->gender == 'Male') selected @endif value="Male">Male</option>
                        <option @if($user->gender == 'Female') selected @endif value="Female">Female</option>
                    </select>

                </div>

                <div class="form-group{{ $errors->has('date_of_birth') ? ' has-error' : ''}}">
                    Дата рождения:
                    <input id="date_of_birth" type="date" class="form-control" name="date_of_birth"
                           value='{{$user->date_of_birth}}'>
                    @if ($errors->has('date_of_birth'))
                        <span class="help-block">
                        <strong>{{ $errors->first('date_of_birth') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Обновить
                        пользователя
                    </button>
                </div>
            </form>
            <form id="deleteUserForm" action="#">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Delete User</button>
                </div>
            </form>

            <form id="usersCategoriesForm" action="#">
                @foreach($usersCategories as $usersCategory)
                    <div class="checkbox-inline">
                        <label><input type="checkbox" name="usersCategoryIds[]"
                                      value="{{$usersCategory->id}}"
                                      @foreach($user->usersCategories as $uCategory)
                                      @if($usersCategory->id == $uCategory->id) checked="checked" @endif
                                    @endforeach
                            >{{$usersCategory->category}}</label>
                    </div>
                @endforeach
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Установить категории пользователя</button>
                </div>
            </form>

            <form id="usersBonusUpdateForm" action="#">
                <div class="form-group">
                    Количество бонусов:
                    <input id="bonuses_amount" type="number" step="1" min="0" class="form-control" name="bonuses_amount"
                           @if(isset($user->bonuses))value="{{$user->bonuses->bonuses_amount}}" @else value="0" @endif >
                </div>

                <div class="form-group{{ $errors->has('bonus_comment') ? ' has-error' : ''}}">
                    Комментарий к изменению бонусов:
                    <input id="bonus_comment" type="text" class="form-control" name="bonus_comment"
                           value='{{$user->bonuses->bonuses_comment}}'>
                    @if ($errors->has('bonus_comment'))
                        <span class="help-block">
                            <strong>{{ $errors->first('bonus_comment') }}</strong>
                         </span>
                    @endif
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Обновить бонусы пользователя</button>
                </div>
            </form>

            <form id="usersBalanceUpdateForm" action="#">
                <div class="form-group">
                    Количество денег на персональном счете:
                    <input id="balance_amount" type="number" step="1" min="0" class="form-control" name="balance_amount"
                           @if(isset($user->balances))value="{{$user->balances->balance_amount}}"
                           @else value="0" @endif >
                </div>

                <div class="form-group{{ $errors->has('balance_comment') ? ' has-error' : ''}}">
                    Комментарий к изменению персонального счета:
                    <input id="balance_comment" type="text" class="form-control" name="balance_comment"
                           value='{{$user->balances->balance_comment}}'>
                    @if ($errors->has('balance_comment'))
                        <span class="help-block">
                            <strong>{{ $errors->first('balance_comment') }}</strong>
                         </span>
                    @endif
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Обновить персональный счет пользователя</button>
                </div>
            </form>

        </div>
    </div>
    <div class="col-md-6">
        <div id="orderListSection">
            <h1>Выберите заказ</h1>
            <ul id="orderList" class="list-group">
                @foreach($user->orders as $order)
                    <li>
                        <a href="{{route('adminPanel.order.index',
                        ['user' => $user->id, 'order' => $order->id])}}">{{$order->public_order_id}}</a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div id="discountListSection">
            <h1>Дискаунты пользователя</h1>
            <ul id="discountList" class="list-group">
                @if(! empty($user->discounts))
                    @foreach($user->discounts as $discount)
                        <li>
                            <form method="POST" class="inline-form" style="display: inline;"
                                  action="{{route('AdminPanel.user.removeDiscounts', ['user' => $user->id, 'discount' => $discount->id])}}">
                                {{ method_field('PUT') }}
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <a href="{{route('AdminPanel.discounts.show',
                                     ['discount' => $discount->id])}}">{{$discount->discount_id}}
                                    </a>
                                    <button type="submit" class="btn btn-sm btn-primary">X</button>
                                </div>
                            </form>

                        </li>
                    @endforeach
                @endif
                @if(! empty($user->categoriesDiscounts))

                    @foreach($user->categoriesDiscounts as $discount)
                        <li>
                            <a href="{{route('AdminPanel.discounts.show',
                            ['discount' => $discount->id])}}">{{$discount->discount_id}}</a>
                        </li>

                    @endforeach
                @endif
            </ul>
        </div>
        @if(!($allDiscounts->isEmpty()))
            <form id="addDiscounts" method="POST"
                  action="{{route('AdminPanel.user.addDiscounts', ['user'=>$user->id])}}">
                <h2>Добавить дискаунты</h2>
                {{ method_field('PUT') }}
                {{ csrf_field() }}

                <div class="form-group">
                    Дискаунты:
                    <select id="userDiscounts" name="userDiscounts[]" multiple size="3" class="form-control">
                        @foreach($allDiscounts as $discount)
                            <option value="{{$discount->id}}">
                                {{$discount->discount_id}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        Добавить дискаунты пользователю
                    </button>
                </div>
            </form>
        @endif
    </div>


    <div class="userLogs">
        @include('admin.panel.users.logs');
    </div>

    <script type="text/javascript">

        {{-- START Section ajax paginate logs --}}

          $(window).on('hashchange', function () {
            if (window.location.hash) {
                var page = window.location.hash.replace('#', '');
                if (page == Number.NaN || page <= 0) {
                    return false;
                } else {
                    getUserLogs(page);
                }
            }
        });
        $(document).ready(function () {
            $(document).on('click', '.pagination a', function (e) {
                getUserLogs($(this).attr('href').split('page=')[1]);
                e.preventDefault();
            });
        });
        function getUserLogs(page) {
            $.ajax({
                url: '?page=' + page,
                dataType: 'json'
            }).done(function (data) {
                $('.userLogs').html(data);
                location.hash = page;
            }).fail(function () {
                alert('UserLogs could not be loaded.');
            });
        }

        {{-- END Section ajax paginate logs --}}

        $("#updateUserForm").submit(function (e) {
            e.preventDefault();
            console.log('submit clicked');
            var id = $("#userId").val();
            var name = $("#name").val();
            var email = $("#email").val();
            var f_name = $("#f_name").val();
            var l_name = $("#l_name").val();
            var phone = $("#phone").val();
            var gender = $('#gender option:selected').val();
            var date_of_birth = $("#date_of_birth").val();
            console.log(gender);
            $.ajax({
                method: "PUT",
                url: "{{route('adminTable.user.update')}}",
                data: {
                    id: id,
                    email: email,
                    name: name,
                    f_name: f_name,
                    l_name: l_name,
                    phone: phone, gender: gender,
                    date_of_birth: date_of_birth
                },
                success: function (user) {
                    $("#userId").val(user.id);
                    $("#name").val(user.name);
                    $("#email").val(user.email);
                    $("#f_name").val(user.f_name);
                    $("#l_name").val(user.l_name);
                    $("#phone").val(user.phone);
                    $('#gender option').removeAttr('selected')
                            .filter('[value=' + user.gender + ']')
                            .attr('selected', true);
                    $("#date_of_birth").val(user.date_of_birth);

                    console.log(user);
                    $.each(user.user_logs, function (i, v) {

                        $('#userLogTbody').prepend(
                                "<tr><td class='col-md-1'>" + v.date +
                                "</td><td class='col-md-6'>" + v.log_action.name + ' ' + v.field_changed + ' пользователя - ' + v.user.name +
                                ' с ' + v.fromto.from + ' на ' + v.fromto.to + '. Автор - ' + v.author.name +
                                "</td></tr>"
                        );
                    });
                    console.log('---in Update----');
                    console.log(user);
                },
                error: function (jqXhr) {
//                    if( jqXhr.status === 401 ) //redirect if not authenticated user.
//                        $( location ).prop( 'pathname', 'auth/login' );
                    if (jqXhr.status === 422) {
                        //process validation errors here.
                        var errors = jqXhr.responseJSON; //this will get the errors response data.
                        //show them somewhere in the markup
                        //e.g
                        errorsHtml = '<div class="alert alert-danger"><ul>';

                        $.each(errors, function (key, value) {
                            errorsHtml += '<li>' + value[0] + '</li>'; //showing only the first error.
                        });
                        errorsHtml += '</ul></di>';

                        $('#form-errors').html(errorsHtml); //appending to a <div id="form-errors"></div> inside form
                    } else {
                        /// do some thing else
                    }
                }
//                error: function(data){
//                    var errors = data.responseJSON;
//                    console.log(errors);
//                    // Render the errors with js ...
//                }
            });
        });

        $("#usersCategoriesForm").submit(function (e) {
            e.preventDefault();
            console.log('submit usersCategoriesForm clicked');
            var data = {'usersCategoryIds[]': []};
            $("#usersCategoriesForm input:checked").each(function () {
                data['usersCategoryIds[]'].push($(this).val());
            });

            console.log(data);
            $.ajax({
                method: "PUT",
                url: "{{route('adminTable.user.updateCategories', ['user' => $userId])}}",
                data: {
                    data: data['usersCategoryIds[]']
                },
                success: function (user) {

                    console.log(user);
                },
                error: function () {
                    console.log(error);
                }
            });
        });

        $("#usersBonusUpdateForm").submit(function (e) {
            e.preventDefault();
            console.log('submit usersBonusUpdateForm clicked');
            var bonuses_amount = $("#bonuses_amount").val();
            var bonus_comment = $("#bonus_comment").val();
            console.log(bonuses_amount);
            $.ajax({
                method: "PUT",
                url: "{{route('adminTable.user.updateUsersBonuses', ['user' => $userId])}}",
                data: {
                    bonuses_amount: bonuses_amount,
                    bonus_comment: bonus_comment
                },
                success: function (bonuses) {
                    $("#bonuses_amount").val(bonuses.bonuses_amount);
                    $("#bonus_comment").val(bonuses.bonuses_comment);

                    console.log(bonuses);

                    $.each(bonuses.user_logs, function (i, v) {

                        $('#userLogTbody').prepend(
                                "<tr><td class='col-md-1'>" + v.date +
                                "</td><td class='col-md-6'>" + v.log_action.name + ' ' + v.field_changed + ' пользователя - ' + v.user.name +
                                ' с ' + v.fromto.from + ' на ' + v.fromto.to + '. Автор - ' + v.author.name +
                                "</td></tr>"
                        );
                    });
                },
                error: function () {
                    console.log(error);
                }
            });
        });

        $("#usersBalanceUpdateForm").submit(function (e) {
            e.preventDefault();
            console.log('submit usersBalanceUpdateForm clicked');
            var balance_amount = $("#balance_amount").val();
            var balance_comment = $("#balance_comment").val();

            $.ajax({
                method: "PUT",
                url: "{{route('adminTable.user.updateUsersBalance', ['user' => $userId])}}",
                data: {
                    balance_amount: balance_amount,
                    balance_comment: balance_comment,
                },
                success: function (balance) {
                    $("#bonuses_amount").val(balance.balance_amount);
                    $("#balance_comment").val(balance.balance_comment);

                    console.log(balance);

                    $.each(balance.user_logs, function (i, v) {

                        $('#userLogTbody').prepend(
                                "<tr><td class='col-md-1'>" + v.date +
                                "</td><td class='col-md-6'>" + v.log_action.name + ' ' + v.field_changed + ' пользователя - ' + v.user.name +
                                ' с ' + v.fromto.from + ' на ' + v.fromto.to + '. Автор - ' + v.author.name +
                                "</td></tr>"
                        );
                    });
                },
                error: function () {
                    console.log(error);
                }
            });
        });

        $("#deleteUserForm").submit(function (e) {
            e.preventDefault();
            var id = $("#userId").val();
            $.ajax({
                method: "DELETE",
                url: "{{route('adminTable.user.delete')}}",
                data: {id: id},
                success: function (msg) {
                    $("#updateUser").addClass('hidden');
                    $("#orderListSection").addClass('hidden');
                    console.log(msg);
                }
            });
        });

    </script>

@stop