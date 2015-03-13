<?php use_helper('JavascriptBase', 'Tag')?>
<?php $sf_response->addJavascript('jquery.ui.datepicker-mn.js')?>
<?php $sf_response->addJavascript('highcharts.js')?>

<?php echo $durations_widget->render('duration', ESC_RAW)?>
<input type="text" id="date" value="<?php echo date('Y-m-d')?>"/>
<?php echo $time_widget->render('time', time(), ESC_RAW)?>

<?php echo button_to_function('Харуул', "loadData($('#duration').val(), $('#date').val(), $('#time_hour').val(), $('#time_minute').val())")?>
<?php echo link_to_function('өмнөх', "loadPrev($('#duration').val(), $('#date').val(), $('#time_hour').val(), $('#time_minute').val())", array('class' => 'button'))?>
<?php echo link_to_function('дараах', "loadNext($('#duration').val(), $('#date').val(), $('#time_hour').val(), $('#time_minute').val())", array('class' => 'button'))?>
<div id="load_indicator" style="display: none; color: red;" align="center">түр хүлээнэ үү...</div>
<div id="container" style="width: 800px; height: 400px; margin: 0 auto"></div>

<a href="#" id="showcustomers" style="display:none;"></a>

<script type="text/javascript">
$(function(){
  $("#date").datepicker();
  Highcharts.setOptions({
    lang: { resetZoom: 'Бүхлээр нь харах' }
  });
});

var chart;
function loadData(duration, date, hour, minute)
{
  $('#load_indicator').show();
  $.ajax({
    url: '<?php echo url_for('total_usage/loadData')?>',
    data: { duration: duration, date: date, hour: hour, minute: minute },
    dataType: 'json',
    success: function(json){
      $('#load_indicator').hide();
      createQuery();
      chart.addSeries(json);
    }
  });
}

function loadPrev(duration, date, hour, minute)
{
  $('#load_indicator').show();
  $.ajax({
    url: '<?php echo url_for('total_usage/loadPrev')?>',
    data: { duration: duration, date: date, hour: hour, minute: minute },
    dataType: 'json',
    success: function(json){
      $('#load_indicator').hide();
      $('#date').val(json[0][0]);
      $('#time_hour').val(json[0][1]);
      $('#time_minute').val(json[0][2]);
      createQuery();
      chart.addSeries(json[1]);
    }
  });
}

function loadNext(duration, date, hour, minute)
{
  $('#load_indicator').show();
  $.ajax({
    url: '<?php echo url_for('total_usage/loadNext')?>',
    data: { duration: duration, date: date, hour: hour, minute: minute },
    dataType: 'json',
    success: function(json){
      $('#load_indicator').hide();
      $('#date').val(json[0][0]);
      $('#time_hour').val(json[0][1]);
      $('#time_minute').val(json[0][2]);
      createQuery();
      chart.addSeries(json[1]);
    }
  });
}

function createQuery()
{
  chart = new Highcharts.Chart({
    chart: { renderTo: 'container', zoomType: 'x' },
    title: { text: '' },
    subtitle: { text: '' },
    xAxis: {
      type: 'datetime',
      maxZoom: 3600 * 1000,
      title: { text: null }
    },
    yAxis: {
      title: { text: 'Хэрэглэгчид' },
      min: 0,
      startOnTick: false,
      showFirstLabel: false
    },
    tooltip: {
      formatter: function() {
        return ''+
          Highcharts.dateFormat('%Y-%m-%d %H:%M', this.x) + ' : '+
          'нийт <strong>' + Highcharts.numberFormat(this.y, 0) +'</strong> хэрэглэгч';
      }
    },
    legend: { enabled: false },
    plotOptions: {
      area: {
        fillColor: {
          linearGradient: [0, 0, 0, 300],
          stops: [ [0, '#4572A7'], [1, 'rgba(2,0,0,0)'] ]
        },
        lineWidth: 1,
        marker: {
          enabled: false,
          states: { hover: { enabled: true, radius: 5 } }
        },
        shadow: false,
        states: { hover: { lineWidth: 1 } }
      },
      series: {
        lineWidth: 1,
          point: {
            events: {
              'click': function() { showCustomers(this.x); }
            }
          }
      }
    }
  });
}

function showCustomers(timestamp)
{
  var d = new Date(timestamp);
  function ISODateString(d){
    function pad(n){return n<10 ? '0'+n : n}
    return d.getUTCFullYear()+'-'
      + pad(d.getUTCMonth()+1)+'-'
      + pad(d.getUTCDate())+' '
      + pad(d.getUTCHours())+':'
      + pad(d.getUTCMinutes())+':'
      + pad(d.getUTCSeconds());
  }

  var t = timestamp + d.getTimezoneOffset() * 60 * 1000;
  $('#showcustomers').attr('href', '<?php echo url_for('customer/dateCustomer')?>?timestamp=' + t);
  $('#showcustomers').show();
  $('#showcustomers').html('энд дарж ' + ISODateString(d) + ' хугацаанд орж байсан хэрэглэгчидийг үзнэ үү!')
}
</script>
