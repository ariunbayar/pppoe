<?php use_helper('JavascriptBase')?>

<?php $sf_response->addJavascript('jquery.ui.datepicker-mn.js')?>
<?php $sf_response->addJavascript('highcharts.js')?>

<h1>
  <?php echo image_tag($customer->getIsBlocked() ? 'minus' : 'add')?>
  <?php echo $customer->getName()?>
</h1>

<table class="form">
  <tbody>
    <tr>
      <th>Байршил</th>
      <td>
        <?php echo $customer->getDistrict()->getName()?>
        <?php echo $customer->getBair()?> байр
        <?php echo $customer->getToot()?> тоот
      </td>
    </tr>
    <?php if ($customer->getNextAction()) {?>
    <tr>
      <th></th>
      <td>
        <?php
        $str = ($customer->getNextAction() == 'block' ? 'хаагдана' : 'нээгдэнэ');
        $color = ($customer->getNextAction() == 'block' ? 'red' : 'green');
        $ndate = $customer->getDateTimeObject('next_date')->format('U');
        echo date('Y-m-d H:i', $ndate).' <span class="'.$color.'">'.$str.'</span>';
        ?>
      </td>
    </tr>
    <?php }?>
    <tr>
      <th>Хурд</th>
      <td><?php echo $customer->getBandwidth()->getBandwidth().'k'?></td>
    </tr>
    <tr>
      <th>Утасны дугаар</th>
      <td>
        <?php foreach ($customer->getPhones() as $i => $phone) echo ($i?', ':'').$phone->getDescription()?>
      </td>
    </tr>
    <tr>
      <th>Бүртгэгдсэн</th>
      <td><?php echo $customer->getDateTimeObject('created_at')->format('Y-m-d H:i')?></td>
    </tr>
    <tr>
      <th>Зассан</th>
      <td>
        <?php $u = $customer->getUser()?>
        <?php echo link_to($u->getUsername(), 'user/edit?id='.$u->getId())?>
        <?php echo $customer->getDateTimeObject('updated_at')->format('Y-m-d H:i')?>
        <?php echo link_to('илүү', 'changelog/index?customer_id='.$customer->getId())?>
      </td>
    </tr>
    <tr>
      <th>Тайлбар</th>
      <td><?php echo $customer->getDescription()?></td>
    </tr>
    <tr>
      <th>Интернэтийн хэрэглээ</th>
      <td>
        <?php echo $durations_widget->render('duration', ESC_RAW)?>
        <input type="text" id="date" value="<?php echo date('Y-m-d')?>"/>
        <?php echo $time_widget->render('time', time(), ESC_RAW)?>

        <?php echo button_to_function('Харуул', "loadData({$customer->getId()}, $('#duration').val(), $('#date').val(), $('#time_hour').val(), $('#time_minute').val())")?>
        <?php echo link_to_function('өмнөх', "loadPrev({$customer->getId()}, $('#duration').val(), $('#date').val(), $('#time_hour').val(), $('#time_minute').val())", array('class' => 'button'))?>
        <?php echo link_to_function('дараах', "loadNext({$customer->getId()}, $('#duration').val(), $('#date').val(), $('#time_hour').val(), $('#time_minute').val())", array('class' => 'button'))?>
        <div id="load_indicator" style="display: none; color: red;" align="center">түр хүлээнэ үү...</div>
        <div id="container" style="width: 600px; height: 100px; margin: 0 auto"></div>
      </td>
    </tr>
    <tr>
      <th></th>
      <td>
        <?php echo link_to('Засах', 'customer/edit?id='.$customer->getId(), array('class' => 'button'))?>
        <?php echo link_to('Устгах', 'customer/delete?id='.$customer->getId(), array('method' => 'delete', 'confirm' => 'Хэрэглэгчийг устгахдаа итгэлтэй байна уу?', 'class' => 'button')) ?>
      </td>
    </tr>
    <tr>
      <th></th>
      <td>
        <?php echo link_to('Хэрэглэгчдийн жагсаалт', 'customer/index')?>
      </td>
    </tr>
  </tbody>
</table>

<script type="text/javascript">
$(function(){
  $("#date").datepicker();
  Highcharts.setOptions({
    lang: { resetZoom: 'Бүхлээр нь харах' }
  });
});

var chart;
function loadData(id, duration, date, hour, minute)
{
  $('#load_indicator').show();
  $.ajax({
    url: '<?php echo url_for('customer/loadData')?>',
    data: { customer_id: id, duration: duration, date: date, hour: hour, minute: minute },
    dataType: 'json',
    success: function(json){
      $('#load_indicator').hide();
      createQuery();
      chart.addSeries(json);
    }
  });
}

function loadPrev(id, duration, date, hour, minute)
{
  $('#load_indicator').show();
  $.ajax({
    url: '<?php echo url_for('customer/loadPrev')?>',
    data: { customer_id: id, duration: duration, date: date, hour: hour, minute: minute },
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

function loadNext(id, duration, date, hour, minute)
{
  $('#load_indicator').show();
  $.ajax({
    url: '<?php echo url_for('customer/loadNext')?>',
    data: { customer_id: id, duration: duration, date: date, hour: hour, minute: minute },
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
      title: { text: '' },
      min: 0,
      max: 1,
      startOnTick: false,
      showFirstLabel: false
    },
    tooltip: {
      formatter: function() {
        return ''+
          Highcharts.dateFormat('%Y-%m-%d %H:%M', this.x) + ' ' + (Highcharts.numberFormat(this.y, 0) == 1 ? 'орсон' : 'ороогүй');
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
      }
    }
  });
}
</script>