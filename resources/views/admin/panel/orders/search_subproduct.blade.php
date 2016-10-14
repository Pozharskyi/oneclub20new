<a href="#myModal" id="openBtn" data-toggle="modal">Добавить продукт</a>

<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <div id="searchProductSection">
                    <form id="searchProduct"  method="POST"
                          action="{{route('adminPanel.subproduct.add.show',['user' => $userId, 'order' => $orderId])}}">
                        {{csrf_field()}}
                        <h1>Поиск продукта</h1>
                        <label for="searchString">Введите №</label>
                        <input id="searchString" type="search" class="form-control" name="searchString" value=''>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Найти продукт</button>
                        </div>
                    </form>
                </div>
                <div id="subproductView"></div>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
{{--<script type="text/javascript">--}}
    {{--$("#searchProduct").submit(function (e) {--}}
        {{--e.preventDefault();--}}
        {{--console.log('submit searchUserForm clicked');--}}

        {{--var searchString = $('#searchString').val();--}}

        {{--$.ajax({--}}
            {{--method: "POST",--}}
            {{--url: "{{route('adminPanel.subproduct.add.show',['user' => $userId, 'order' => $orderId])}}",--}}
            {{--data: {--}}
                {{--searchString: searchString--}}
            {{--},--}}
            {{--success: function (data) {--}}
                {{--console.log(data);--}}
                {{--$("#searchProductSection").hide();--}}
                {{--$("#subproductView").append(data);--}}

                {{--$("#subproductView").show();--}}
            {{--},--}}
            {{--error: function () {--}}
                {{--console.log(error);--}}
            {{--}--}}
        {{--});--}}
    {{--});--}}
{{--</script>--}}