/**
 * Created by Home on 06.10.2016.
 */

var data = {};

function getChartInfo()
{
    $.ajax({
        url: "/admin/stats/info/payments",
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

var chart = AmCharts.makeChart("chartdiv", {
    "theme": "light",
    "type": "serial",
    "startDuration": 2,
    "dataProvider": data.info,
    "valueAxes": [{
        "position": "left",
        "title": "Типы оплат"
    }],
    "graphs": [{
        "balloonText": "[[category]]: <b>[[value]]</b>",
        "fillColorsField": "color",
        "fillAlphas": 1,
        "lineAlpha": 0.1,
        "type": "column",
        "valueField": "Количество использований"
    }],
    "depth3D": 20,
    "angle": 30,
    "chartCursor": {
        "categoryBalloonEnabled": false,
        "cursorAlpha": 0,
        "zoomable": false
    },
    "categoryField": "Типы оплат",
    "categoryAxis": {
        "gridPosition": "start",
        "labelRotation": 90
    },
    "export": {
        "enabled": true
    }

});