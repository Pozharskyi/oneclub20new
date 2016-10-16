<html xmlns:x="urn:schemas-microsoft-com:office:excel">
<head>
    <!--[if gte mso 9]>
    <xml>
        <x:ExcelWorkbook>
            <x:ExcelWorksheets>
                <x:ExcelWorksheet>
                    <x:Name>Sheet 1</x:Name>
                    <x:WorksheetOptions>
                        <x:Print>
                            <x:ValidPrinterInfo/>
                        </x:Print>
                    </x:WorksheetOptions>
                </x:ExcelWorksheet>
            </x:ExcelWorksheets>
        </x:ExcelWorkbook>
    </xml>
    <![endif]-->
</head>
<body>
    <table>
        <thead>
        <tr>
            @foreach($headers as $header)
                <td>
                    {{ $header }}
                </td>
            @endforeach
        </tr>
        </thead>
        <tbody>

        @php $i = 0 @endphp

        @while($i < $count)

            <tr>

                @foreach($headers as $header)
                    <td @if(isset($errors[$i][$header])) style="background-color: red;" @endif>
                        {{ $file[$i][$header] }}
                    </td>
                @endforeach

            </tr>

            @php $i++ @endphp
        @endwhile

        </tbody>
    </table>
</body>

@php

    header('Content-type: application/excel');
    $filename = 'import_error.xls';
    header('Content-Disposition: attachment; filename='.$filename);

@endphp