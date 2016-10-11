<a href="#myModal" id="openBtn" data-toggle="modal">Размерная сетка</a>

<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Международный размер</th>
                        <th>Размер производителя</th>
                        @if(isset($sizeCharts->first()->measurements))
                            @foreach($sizeCharts->first()->measurements as $measurement)
                                <th>{{$measurement->name->name}}</th>
                            @endforeach
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @foreach( $sizeCharts as $sizeChart )
                        <tr>
                            <td>{{ $sizeChart->size->name }}</td>
                            <td>{{ $sizeChart->brand_size }}</td>
                            @if(isset($sizeCharts->first()->measurements))
                                @foreach($sizeChart->measurements as $measurement)
                                    <td>{{$measurement->value}}</td>
                                @endforeach
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->