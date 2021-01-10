<!DOCTYPE HTML>
<html>
<head>
    <script>
        window.onload = function () {
            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                title: {
                    text: "Persebaran Data"
                },
                axisX: {
                    title: "X"
                },
                axisY: {
                    title: "Y",
                    suffix: ""
                },
                legend: {
                    cursor: "pointer",
                    itemclick: toggleDataSeries
                },
                data: [{
                    type: "scatter",
                    name: "Besar",
                    showInLegend: true,
                    toolTipContent: "<span style=\"color:#4F81BC \">{name}</span><br>Active Users: {x}<br>CPU Utilization: {y}%",
                    dataPoints: <?php echo json_encode($resultBesar, JSON_NUMERIC_CHECK); ?>
                },
                    {
                        type: "scatter",
                        name: "Sedang",
                        showInLegend: true,
                        markerType: "triangle",
                        toolTipContent: "<span style=\"color:#C0504E \">{name}</span><br>Active Users: {x}<br>CPU Utilization: {y}%",
                        dataPoints: <?php echo json_encode($resultSedang, JSON_NUMERIC_CHECK); ?>
                    },
                    {
                        type: "scatter",
                        name: "Kecil",
                        showInLegend: true,
                        markerType: "triangle",
                        toolTipContent: "<span style=\"color:#C0504E \">{name}</span><br>Active Users: {x}<br>CPU Utilization: {y}%",
                        dataPoints: <?php echo json_encode($resultKecil, JSON_NUMERIC_CHECK); ?>
                    }]
            });
            chart.render();

            function toggleDataSeries(e) {
                if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                    e.dataSeries.visible = false;
                } else {
                    e.dataSeries.visible = true;
                }
                e.chart.render();
            }

        }
    </script>
</head>
<body>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html>
