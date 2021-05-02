<?php

    $string = file_get_contents("where_you're_logged_in.json");
    $character=json_decode($string);
    $obj=( $character->active_sessions);
    $locations=array();
    for($i=0;$i<sizeof($obj);$i=$i+1){
        $deviceLocation=$obj[$i]->location;
        array_push($locations,$deviceLocation);
    }

    $counted = array_count_values($locations);
    arsort($counted);
    $keys = array_keys($counted);

?>
<html>
<head>
    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">

        google.charts.load('current', {'packages':['line']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Location');
            data.addColumn('number', 'Number of active sessions');

            data.addRows([
                <?php for($i=0;$i<sizeof($keys);$i++){

                ?>
                ['<?php echo $keys[$i]?>', <?php echo $counted[$keys[$i]]?>],
                <?php
                }?>
            ]);

            var options = {
                chart: {
                    title: 'Number of Active Facebook Sessions',
                },
                width: 900,
                height: 500
            };

            var chart = new google.charts.Line(document.getElementById('chart_div'));

            chart.draw(data, google.charts.Line.convertOptions(options));
            <?php unset($locations);?>
        }

    </script>
</head>

<body>
    <!--Div that will hold the line chart-->
    <div id="chart_div"></div>
</body>
</html>
