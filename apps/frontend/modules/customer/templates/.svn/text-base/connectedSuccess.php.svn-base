<?php use_helper('JavascriptBase')?>

<table class="list">
  <thead>
    <tr>
      <th>Нэр</th>
      <th>Хороолол</th>
      <th>Байр</th>
      <th>Тоот</th>
      <th>Хурд</th>
      <th>
        <?php echo link_to_function('Тайлбар', "$('.description').show(); $('.desc_show').hide(); $(this).hide(); $(this).next().show()")?>
        <?php echo link_to_function('Тайлбар', "$('.description').hide(); $('.desc_show').show(); $(this).hide(); $(this).prev().show()", array('style' => 'display:none'))?>
      </th>
      <th>Төлбөр</th>
      <th>Хаах/Нээх</th>
      <th></th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($customers as $i => $customer): ?>
      <?php
      $naction = $customer->getNextAction();
      $str = ($naction == 'block' ? 'хаах' : 'нээх');
      $ndate = $customer->getDateTimeObject('next_date')->format('U');
      $blocked = $customer->getIsBlocked();
      $desc = $customer->getDescription();
      $id = $customer->getId();
      ?>
    <tr <?php if ($i%2) echo 'class="odd"'?>>
      <td><?php echo link_to($customer->getName(), 'customer/show?id='.$id) ?></td>
      <td><?php echo link_to($customer->getDistrict()->getName(), 'customer/show?id='.$id) ?></td>
      <td><?php echo link_to($customer->getBair(), 'customer/show?id='.$id) ?></td>
      <td><?php echo link_to($customer->getToot(), 'customer/show?id='.$id) ?></td>
      <td align="right"><?php echo $customer->getBandwidth()->getBandwidth().'k' ?></td>
      <td>
        <?php if (mb_strlen($desc, 'UTF-8') <= 10) {?>
          <?php echo $desc;?>
        <?php }else{?>
          <?php echo link_to_function(mb_substr($desc, 0, 12, 'UTF-8').'...', "$(this).next().show('blind'); $(this).hide()", array('class' => 'desc_show'))?>
          <div class="description" style="display: none;" onclick="$(this).prev().show(); $(this).hide()">
            <?php echo $desc ?>
          </div>
        <?php }?>
      </td>
      <td align="right"><?php echo number_format($customer->getPayment(), 0, '.', '`') ?></td>
      <td align="center">
        <?php
        if ($naction) {
          echo date('Y-m-d H:i', $ndate).' '.$str;
        }else{
          echo '-';
        }
        ?>
      </td>
      <td><?php echo image_tag($blocked ? 'minus' : 'add', array('title' => ($blocked ? 'Хаагдсан' : 'Нээлттэй'))) ?></td>
      <td><?php echo link_to('засах', 'customer/edit?id='.$customer->getId())?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>