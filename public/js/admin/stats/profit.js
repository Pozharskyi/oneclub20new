/**
 * Created by Home on 06.10.2016.
 */

var data = {};

function getChartInfo()
{
    $.ajax({
        url: "/admin/stats/info/profit",
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
    "type": "serial",
    "theme": "light",
    "marginRight": 80,
    "marginTop": 17,
    "autoMarginOffset": 20,
    "dataProvider": data.info,
    "valueAxes": [{
        "logarithmic": true,
        "dashLength": 1,
        "guides": [{
            "dashLength": 6,
            "inside": true,
            "label": "average",
            "lineAlpha": 1,
            "value": 90.4
        }],
        "position": "left"
    }],
    "graphs": [{
        "bullet": "round",
        "id": "g1",
        "bulletBorderAlpha": 1,
        "bulletColor": "#FFFFFF",
        "bulletSize": 7,
        "lineThickness": 2,
        "title": "Price",
        "type": "smoothedLine",
        "useLineColorForBulletBorder": true,
        "valueField": "price"
    }],
    "chartScrollbar": {},
    "chartCursor": {
        "valueLineEnabled": true,
        "valueLineBalloonEnabled": true,
        "valueLineAlpha": 0.5,
        "fullWidth": true,
        "cursorAlpha": 0.05
    },
    "dataDateFormat": "YYYY-MM-DD",
    "categoryField": "date",
    "categoryAxis": {
        "parseDates": true
    },
    "export": {
        "enabled": true
    }
});

/*
chart.addListener("dataUpdated", zoomChart);

function zoomChart() {
    chart.zoomToDates(new Date(2016, 9, 1), new Date(2016, 11, 6));
}
*/