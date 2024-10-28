<?php
    use Carbon\Carbon;
?>
@extends('layouts.admin')
@section('content')
<style>
    .redirect-card-home {
        cursor: pointer;
    }
    #chartdiv {
        width: 100%;
        font-size: 10px;
        height: 500px;
    }
    .average-price-card .card {
        background:#b8189a  !important;
    }
    .blueout-price-card .card{
        background:#2196f3  !important;
    }
    .red-price-card .card{
        background:#ba0c00 !important;
    }
    .yellow-price-card .card{
        background:#bfac00 !important;
    }
    .green-price-card .card{
        background:#008031 !important;
    }
     .purple-price-card .card{
        background:#710080 !important;
    }
     .pink-price-card .card{
        background:#fc007a !important;
    }
    .nav-dashboard {
        background: #fff;
        padding: 10px;
    }
</style> 
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<div class="content-header">
    <div class="container">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="m-0">PAPAN INFORMASI SILA</h1>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <ul class="nav nav-tabs tab-solid tab-solid-danger nav-dashboard mb-2" role="tablist">
        <li class="nav-item" style="cursor: pointer">
          <a class="nav-link active" id="tab-button-1"> <i class=" fas fa-envelope"></i>Dashboard Surat</a>
        </li>
        <li class="nav-item" style="cursor: pointer">
          <a class="nav-link" id="tab-button-2"><i class=" fas fa-money"></i> Dashboard Keuangan</a>
        </li>
    </ul>

    @include('dashboard-tab-1')

    @include('dashboard-tab-2');
    
</div>
@stop
@section('footer')
<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>
<script>
    $(document).ready(function(){

        $("#tab-button-1").click(function(){
            $("#tab-2").hide();
            $("#tab-1").show();
            if(!$(this).hasClass('active')) {
                $(this).addClass('active');
                $("#tab-button-2").removeClass('active');
            }
        }); 

        $("#tab-button-2").click(function(){
            $("#tab-2").show();
            $("#tab-1").hide();
            if(!$(this).hasClass('active')) {
                $(this).addClass('active');
                $("#tab-button-1").removeClass('active');
            }
        })
        
        $('.redirect-card-home').click(function(){
            window.location.href = $(this).attr('href')
        })

         // Load amCharts 4 libraries

         function createBarChart(chartId, data) {
            am4core.useTheme(am4themes_animated);
            var chart = am4core.create(chartId, am4charts.XYChart);
            chart.data = data;

            var xAxis = chart.xAxes.push(new am4charts.CategoryAxis());
            xAxis.dataFields.category = "category";

            var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

            var series = chart.series.push(new am4charts.ColumnSeries());
            series.dataFields.valueY = "value";
            series.dataFields.categoryX = "category";
            series.columns.template.tooltipText = "{categoryX}: [bold]{valueY}[/]";
            series.columns.template.fillOpacity = 0.8;

            var columnTemplate = series.columns.template;
            columnTemplate.strokeWidth = 2;
            columnTemplate.strokeOpacity = 1;
            xAxis.dataFields.category = 'category'
            xAxis.renderer.cellStartLocation = 0.1
            xAxis.renderer.cellEndLocation = 0.9
            xAxis.renderer.grid.template.location = 0;
            xAxis.renderer.autoGridCount = false;
            xAxis.renderer.labels.template.disabled = false;

            xAxis.dataFields.category = "category";
            xAxis.renderer.minGridDistance = 30; // Jarak minimal antar label
            xAxis.renderer.labels.template.rotation = -45; // Rotasi label
            xAxis.renderer.labels.template.horizontalCenter = "right";
            xAxis.renderer.labels.template.verticalCenter = "middle";
        }

        let dataPenghimpunan = {!!json_encode($dataPerBulanPendistribusian)!!}
        let chartData1 = [];
        for (const key in dataPenghimpunan) {
            chartData1.push({
                category: key,
                value: dataPenghimpunan[key]['pendistribusian'],
            })
        }

        let dataPenerimaan = {!!json_encode($dataPerBulanPenerimaan)!!}
        let chartData2 = [];
        for (const key in dataPenerimaan) {
            chartData2.push({
                category: key,
                value: dataPenerimaan[key]['penerimaan'],
            })
        }

        createBarChart("chartPenghimpunan", chartData1);
        createBarChart("chartPenerimaan", chartData2);
        

        am4core.ready(function() {
            
            chart = am4core.create('chartdiv', am4charts.XYChart)
            chart.colors.step = 2;
            
            chart.legend = new am4charts.Legend()
            chart.legend.position = 'top'
            chart.legend.paddingBottom = 20
            chart.legend.labels.template.maxWidth = 95
            
            var xAxis = chart.xAxes.push(new am4charts.CategoryAxis())
            xAxis.dataFields.category = 'category'
            xAxis.renderer.cellStartLocation = 0.1
            xAxis.renderer.cellEndLocation = 0.9
            xAxis.renderer.grid.template.location = 0;
            xAxis.renderer.autoGridCount = false;
            xAxis.renderer.labels.template.disabled = false;

            xAxis.dataFields.category = "category";
            xAxis.renderer.minGridDistance = 30; // Jarak minimal antar label
            xAxis.renderer.labels.template.rotation = -45; // Rotasi label
            xAxis.renderer.labels.template.horizontalCenter = "right";
            xAxis.renderer.labels.template.verticalCenter = "middle";
            
            var yAxis = chart.yAxes.push(new am4charts.ValueAxis());
            yAxis.min = 0;
            
            function createSeries(value, name) {
                var series = chart.series.push(new am4charts.ColumnSeries())
                series.dataFields.valueY = value
                series.dataFields.categoryX = 'category'
                series.name = name
            
                // series.events.on("hidden", arrangeColumns);
                series.events.on("shown", arrangeColumns);
            
                var bullet = series.bullets.push(new am4charts.LabelBullet())
                bullet.interactionsEnabled = false
                bullet.dy = 30;
                bullet.label.text = '{valueY}'
                bullet.label.fill = am4core.color('#ffffff')
            
                return series;
            }

            
            let data = {!!json_encode($dataPerBulan)!!}
            for (const key in data) {
                chart.data.push({
                    category: key,
                    suratmasuk: data[key]['suratmasuk'],
                    proposalsurat:  data[key]['proposalsurat'],
                    suratkeluar:  data[key]['suratkeluar'],
                    disposisi:  data[key]['disposisi'],
                })
            }

            createSeries('suratmasuk', 'Surat Masuk');
            createSeries('proposalsurat', 'Proposal Surat');
            createSeries('suratkeluar', 'Surat Keluar');
            createSeries('disposisi', 'Disposisi');
        
            function arrangeColumns() {
                var series = chart.series.getIndex(0);
                var w = 1 - xAxis.renderer.cellStartLocation - (1 - xAxis.renderer.cellEndLocation);
                if (series.dataItems.length > 1) {
                    var x0 = xAxis.getX(series.dataItems.getIndex(0), "categoryX");
                    var x1 = xAxis.getX(series.dataItems.getIndex(1), "categoryX");
                    var delta = ((x1 - x0) / chart.series.length) * w;
                    if (am4core.isNumber(delta)) {
                        var middle = chart.series.length / 2;
            
                        var newIndex = 0;
                        chart.series.each(function(series) {
                            if (!series.isHidden && !series.isHiding) {
                                series.dummyData = newIndex;
                                newIndex++;
                            }
                            else {
                                series.dummyData = chart.series.indexOf(series);
                            }
                        })
                        var visibleCount = newIndex;
                        var newMiddle = visibleCount / 2;
                        chart.series.each(function(series) {
                            var trueIndex = chart.series.indexOf(series);
                            var newIndex = series.dummyData;
                            var dx = (newIndex - trueIndex + middle - newMiddle) * delta
                            series.animate({ property: "dx", to: dx }, series.interpolationDuration, series.interpolationEasing);
                            series.bulletsContainer.animate({ property: "dx", to: dx }, series.interpolationDuration, series.interpolationEasing);
                        })
                    }
                }
            }
        
        }); // end am4core.ready()

        var numbers = document.getElementsByTagName('tspan');
            for(var i = 0; i < numbers.length; i++){
            if(numbers[i].innerHTML == '0'){
                numbers[i].parentElement.removeChild(numbers[i]);
            }
        }
    })
</script>
@endsection
