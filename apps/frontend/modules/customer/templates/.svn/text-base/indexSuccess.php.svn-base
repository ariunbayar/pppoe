<?php use_helper('JavascriptBase')?>

<h1>Хэрэглэгчид</h1>

<form action="<?php echo url_for('customer/index')?>" method="post">
  <div>
    <?php echo $form->renderGlobalErrors()?>
    <?php echo $form->renderHiddenFields()?>
    <table class="form">
      <tbody>
        <tr>
          <th><?php echo $form['name']->renderLabel()?></th>
          <td>
            <?php echo $form['name']->renderError()?>
            <?php echo $form['name']?>
          </td>
          <th><?php echo $form['district']->renderLabel()?></th>
          <td>
            <?php echo $form['district']->renderError()?>
            <?php echo $form['district']?>
          </td>
        </tr>
        <tr>
          <th><?php echo $form['bair']->renderLabel()?></th>
          <td>
            <?php echo $form['bair']->renderError()?>
            <?php echo $form['bair']?>
          </td>
          <th><?php echo $form['speed']->renderLabel()?></th>
          <td>
            <?php echo $form['speed']->renderError()?>
            <?php echo $form['speed']?>
          </td>
        </tr>
        <tr>
          <th><?php echo $form['toot']->renderLabel()?></th>
          <td>
            <?php echo $form['toot']->renderError()?>
            <?php echo $form['toot']?>
          </td>
          <th><?php echo $form['blocked']->renderLabel()?></th>
          <td>
            <?php echo $form['blocked']->renderError()?>
            <?php echo $form['blocked']?>
          </td>
        </tr>
        <tr>
          <th><?php echo $form['phone']->renderLabel()?></th>
          <td>
            <?php echo $form['phone']->renderError()?>
            <?php echo $form['phone']?>
          </td>
          <th></th>
          <td>
          </td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="4" align="center">
            <input type="submit" value="Хайх"/>
          </td>
        </tr>
      </tfoot>
    </table>
  </div>
</form>

<hr/>

<?php echo link_to('Шинээр үүсгэх', 'customer/new')?>

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

<?php if ($pager->haveToPaginate()) {?>
  <div>
    <?php echo link_to('<< Эхнийх', 'customer/index?page=1', array('class' => 'button'))?>
    <?php echo link_to('< Өмнөх', 'customer/index?page='.$pager->getPreviousPage(), array('class' => 'button'))?>
    <?php foreach ($pager->getLinks() as $page) {
      if ($page == $pager->getPage()) {
        echo '<strong style="margin: 0 20px">'.$page.'</strong>';
      }else{
        echo link_to($page, 'customer/index?page='.$page, array('class' => 'button'));
      }
    }?>
    <?php echo link_to('Дараах >', 'customer/index?page='.$pager->getNextPage(), array('class' => 'button'))?>
    <?php echo link_to('Сүүлийнх >>', 'customer/index?page='.$pager->getLastPage(), array('class' => 'button'))?>
  </div>
<?php }?>
<center>
  <strong>
    <?php echo $pager->getLastPage()?> хуудасны <?php echo $pager->getPage()?><br/>
    Нийт <?php echo $pager->getNbResults();?> хэрэглэгч
  </strong>
</center>

