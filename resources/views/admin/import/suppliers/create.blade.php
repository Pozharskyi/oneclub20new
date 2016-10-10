@extends('layouts/adminPanel')

@section('title') Страница добавления поставщиков @stop

@section('content')

    <div style="margin-top: -22px">

        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

    </div>

    <div style="margin-top: 22px;"></div>

    @include('admin.import.sub-nav')
    @include('admin.import.suppliers.nav.nav')

    <form action="{{ url('/admin/import/suppliers/create') }}" method="post">

        {{ csrf_field() }}
        {{ method_field('POST') }}

        <div class="container">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-4">

                    <label for="name" style="margin-top: 25px;">Поставщик, компания</label>
                    <input type="text" class="form-control" name="name" id="name" required />

                    <label for="shop" style="margin-top: 25px;">Магазин</label>
                    <textarea name="shop" id="shop" class="form-control" rows="4" required></textarea>

                    <label for="brands" style="margin-top: 25px;">Бренды</label>
                    <textarea name="brands" id="brands" class="form-control" rows="4" required></textarea>

                    <label for="contact_person" style="margin-top: 25px;">Контактное лицо</label>
                    <input type="text" class="form-control" name="contact_person" id="contact_person" required />

                    <label for="phones" style="margin-top: 25px;">Телефоны</label>
                    <input type="text" class="form-control" name="phones" id="phones" required />

                    <label for="email" style="margin-top: 25px;">Email</label>
                    <input type="email" class="form-control" name="email" id="email" required />

                    <label for="coefficient" style="margin-top: 25px;">Плановая наценка, коэффициент</label>
                    <input type="text" class="form-control" name="coefficient" id="coefficient" required />

                    <label for="product_marga" style="margin-top: 25px;">Плановая маржа, %</label>
                    <input type="text" class="form-control" name="product_marga" id="product_marga" />

                    <label for="time_of_returns" style="margin-top: 25px;">Срок возвратов</label>
                    <textarea name="time_of_returns" id="time_of_returns" class="form-control" rows="4" required></textarea>

                    <label for="work_status" style="margin-top: 25px;">Статус</label>
                    <select id="work_status" name="work_status" class="form-control" required>

                        @foreach( $workStatuses as $workStatus )
                            <option value="{{ $workStatus }}">{{ $workStatus }}</option>
                        @endforeach

                    </select>

                    <label for="work_comment" style="margin-top: 25px;">
                        Комментарий к статусу в процессе переговоров, с датой статуса
                    </label>
                    <textarea name="work_comment" id="work_comment" class="form-control" rows="4"></textarea>

                </div>
                <div class="col-md-3"></div>
                <div class="col-md-4">

                    <label for="agreement" style="margin-top: 25px;">Наличие договора</label>
                    <select id="agreement" name="agreement" class="form-control" required>

                        @foreach( $agreementTypes as $agreementType )
                            <option value="{{ $agreementType }}">{{ $agreementType }}</option>
                        @endforeach

                    </select>

                    <label for="start_working" style="margin-top: 25px;">Дата старта сотрудничества</label>
                    <input type="text" class="form-control" name="start_working" placeholder="YYYY-MM-DD" id="start_working" required />

                    <label for="payment_form" style="margin-top: 25px;">Форма расчета</label>
                    <input type="text" class="form-control" name="payment_form" id="payment_form" required />

                    <label for="payment_postpone" style="margin-top: 25px;">Отстрочка платежа, в днях</label>
                    <input type="text" class="form-control" name="payment_postpone" id="payment_postpone" />

                    <label for="ecommerce_comment" style="margin-top: 25px;">Комментарии по коммерческой части</label>
                    <textarea name="ecommerce_comment" id="ecommerce_comment" class="form-control" rows="4" required></textarea>

                    <label for="address_sending" style="margin-top: 25px;">Адрес забора и отправки образцов</label>
                    <textarea name="address_sending" id="address_sending" class="form-control" rows="4" required></textarea>

                    <label for="logistic_comment" style="margin-top: 25px;">Комментарий для логистики</label>
                    <textarea name="logistic_comment" id="logistic_comment" class="form-control" rows="4"></textarea>

                    <label for="address_return" style="margin-top: 25px;">Адрес забора заказов и отправки возвратов</label>
                    <textarea name="address_return" id="address_return" class="form-control" rows="4"></textarea>

                    <label for="products_category" style="margin-top: 25px;">Товарная категорияв</label>
                    <textarea name="products_category" id="products_category" class="form-control" rows="4" required></textarea>

                    <label for="buyer_id" style="margin-top: 25px;">Отвественный байер</label>
                    <select id="buyer_id" name="buyer_id" class="form-control" required>
                        <option></option>
                        <option value="1">Сердюк Александр</option>
                    </select>

                </div>
            </div>
        </div>

        <div class="text-center" style="margin-top: 25px;">
            <button class="btn btn-default">Добавить поставщика</button>
        </div>

    </form>

@endsection