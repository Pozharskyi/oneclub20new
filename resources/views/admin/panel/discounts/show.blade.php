@extends('layouts.adminPanel')

@section('title') Discounts @stop

@section('breadcrumb')
    <li class="active">Дискаунт инфо</li>
@endsection

@section('content')
        <div id="discountInfo">
            <h1>Дискаунт инфо</h1>
            <ul class="list-group">
                <li>
                    <div class="col-xs-3 col-sm-3 col-md-2">
                        discount_id
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-10">
                        {{$discount->discount_id}}
                    </div>
                </li>
                <li>
                    <div class="col-xs-3 col-sm-3 col-md-2">
                        status
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-10">
                        {{$discount->status}}
                    </div>
                </li>
                <li>
                    <div class="col-xs-3 col-sm-3 col-md-2">
                        type
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-10">
                        {{$discount->type}}
                    </div>
                </li>
                <li>
                    <div class="col-xs-3 col-sm-3 col-md-2">
                        discount_amount
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-10">
                        {{$discount->discount_amount}}
                    </div>
                </li>
                <li>
                    <div class="col-xs-3 col-sm-3 col-md-2">
                        active_from
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-10">
                        {{$discount->active_from}}
                    </div>
                </li>
                <li>
                    <div class="col-xs-3 col-sm-3 col-md-2">
                        active_to
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-10">
                        {{$discount->active_to}}
                    </div>
                </li>
                <li>
                    <div class="col-xs-3 col-sm-3 col-md-2">
                        comment
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-10">
                        {{$discount->comment}}
                    </div>
                </li>
                <li>
                    <div class="col-xs-3 col-sm-3 col-md-2">
                        rule
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-10">
                        {{$discount->rule}}
                    </div>
                </li>
                <li>
                    <div class="col-xs-3 col-sm-3 col-md-2">
                        auto
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-10">
                        {{$discount->auto}}
                    </div>
                </li>
                <li>
                    <div class="col-xs-3 col-sm-3 col-md-2">
                        min_basket_sum
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-10">
                        {{$discount->min_basket_sum}}
                    </div>
                </li>
                <li>
                    <div class="col-xs-3 col-sm-3 col-md-2">
                        max_basket_sum
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-10">
                        {{$discount->max_basket_sum}}
                    </div>
                </li>
                <li>
                    <div class="col-xs-3 col-sm-3 col-md-2">
                        subproduct_amount_from
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-10">
                        {{$discount->subproduct_amount_from}}
                    </div>
                </li>
                <li>
                    <div class="col-xs-3 col-sm-3 col-md-2">
                        purchase_number
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-10">
                        {{$discount->purchase_number}}
                    </div>
                </li>
                <li>
                    <div class="col-xs-3 col-sm-3 col-md-2">
                        deliveryTypes
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-10">
                        {{$discount->deliveryTypes}}
                    </div>
                </li>
                <li>
                    <div class="col-xs-3 col-sm-3 col-md-2">
                        paymentTypes
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-10">
                        {{$discount->paymentTypes}}
                    </div>
                </li>
                <li>
                    <div class="col-xs-3 col-sm-3 col-md-2">
                        userCategories
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-10">
                        {{$discount->userCategories}}
                    </div>
                </li>
            </ul>
        </div>
@stop