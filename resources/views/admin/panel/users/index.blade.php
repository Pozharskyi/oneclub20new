@extends('layouts.adminPanel')

@section('title') Users @stop

@section('breadcrumb')
    <li class="active">Выбор пользователя</li>
@endsection

@section('content')
    <div class="row">
        @if (session()->has('message'))
            <div class="alert alert-info" >{{session('message')}}</div>
        @endif

        <div class="col-md-6">
            <form id="searchUserForm" action="#">
                <h1>Поиск пользователя</h1>
                <input id="searchString" type="search" class="form-control" name="searchString" value=''>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Найти пользователя</button>
                </div>
            </form>
        </div>

        <div id="searchResult" class="col-md-6">
            <h2>Результаты поиска</h2>
            <table id="selectUserTable" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <td>Email</td>
                    <td>Имя</td>
                </tr>
                </thead>
                <tbody id="selectUserTbody">

                </tbody>
            </table>

        </div>
    </div>
    <script type="text/javascript">
        $("#searchUserForm").submit(function (e) {
            e.preventDefault();
            console.log('submit searchUserForm clicked');

            var searchString = $('#searchString').val();

            $.ajax({
                method: "POST",
                url: "{{route('adminTable.user.showUsers')}}",
                data: {
                    searchString: searchString
                },
                success: function (users) {
                    console.log(users);
                    $('#selectUserTbody').children().remove();
                    $('#searchResult').show();
                    $.each(users, function (i, v) {

                        $('#selectUserTbody').append(
                                "<tr><td>" + v.email +
                                "</td><td>" + "<a href=/admin/users/" + v.id + ">" + v.name + "</a>" +
                                "</td><td>" + "<a href=/admin/users/" + v.id + "/manage_role"+">" + "Редактировать роли " + "</a>" +
                                "</td></tr>"
                        );
                    });

                },
                error: function () {
                    console.log(error);
                }
            });
        });
    </script>
    <style>
        #searchResult {
            display: none;
        }
    </style>
@stop
