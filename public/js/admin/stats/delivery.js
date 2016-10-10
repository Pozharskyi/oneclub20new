/**
 * Created by Home on 06.10.2016.
 */

var data = {};

function getChartInfo()
{
    $.ajax({
        url: "/admin/stats/info/delivery",
        data: "csrf_token=15fmaL9mafF185",
        type: "PUT",
        headers: {
            'X-XSRF-TOKEN': getXsrfToken()
        },
        success: function ( result )
        {
            data.info = JSON.parse(result);
        },
        async: false
    });
}

getChartInfo();

var chart = AmCharts.makeChart( "chartdiv", {
    "type": "pie",
    "theme": "light",
    "dataProvider": data.info,
    "valueField": "Количество использований",
    "titleField": "Типы доставки",
    "balloon":{
        "fixedPosition":true
    },
    "export": {
        "enabled": true
    }
} );