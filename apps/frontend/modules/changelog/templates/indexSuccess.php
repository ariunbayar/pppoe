<h1>Хийсэн үйлдлүүдийн түүх</h1>

<table class="list">
  <thead>
    <tr>
      <th>Админ</th>
      <th width="130">Огноо</th>
      <th></th>
      <th></th>
      <th>Тайлбар</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($changelogs as $i => $changelog) {?>
    <tr <?php if ($i%2) echo 'class="odd"'?>>
      <td>
        <?php
        if ($changelog->getEditorId()) {
          echo link_to($changelog->getEditor()->getUsername(), 'user/edit?id='.$changelog->getEditor()->getId());
        }elseif ($changelog->getEditorId() === null){
          echo 'SYSTEM';
        }else{
          echo 'устсан';
        }
        ?>
      </td>
      <td><?php echo $changelog->getCreatedAt()?></td>
      <td>
        <?php
        switch ($changelog->getObject()) {
          case 'user':
            echo 'Админ';
            break;
          case 'district':
            echo 'Хороолол';
            break;
          case 'customer':
            echo 'Хэрэглэгч';
            break;
          default:
            echo $changelog->getObject();
        }
        ?>
      </td>
      <td>
        <?php
        if ($changelog->getObjectId()) {
          switch ($changelog->getObject()) {
            case 'user':
              $u = $changelog->getUser();
              echo link_to($u->getUsername(), 'user/edit?id='.$u->getId());
              break;
            case 'district':
              $d = $changelog->getDistrict();
              echo link_to($d->getName(), 'district/edit?id='.$d->getId());
              break;
            case 'customer':
              $c = $changelog->getCustomer();
              echo link_to($c->getName(), 'customer/show?id='.$c->getId());
              break;
            default:
              echo $changelog->getObjectId();
          }
        }elseif ($changelog->getObjectId() !== null) {
          echo 'устсан';
        }
        ?>
      </td>
      <td><?php echo nl2br($changelog->getDescription())?></td>
    </tr>
  <?php }?>
  </tbody>
</table>

<?php if ($pager->haveToPaginate()) {?>
  <div>
    <?php echo link_to('<< Эхнийх', 'changelog/index?page=1', array('class' => 'button'))?>
    <?php echo link_to('< Өмнөх', 'changelog/index?page='.$pager->getPreviousPage(), array('class' => 'button'))?>
    <?php foreach ($pager->getLinks(8) as $page) {
      if ($page == $pager->getPage()) {
        echo '<strong style="margin: 0 20px">'.$page.'</strong>';
      }else{
        echo link_to($page, 'changelog/index?page='.$page, array('class' => 'button'));
      }
    }?>
    <?php echo link_to('Дараах >', 'changelog/index?page='.$pager->getNextPage(), array('class' => 'button'))?>
    <?php echo link_to('Сүүлийнх >>', 'changelog/index?page='.$pager->getLastPage(), array('class' => 'button'))?>
    <center>
      <strong>
        <?php echo $pager->getLastPage()?> хуудасны <?php echo $pager->getPage()?><br/>
        Нийт <?php echo $pager->getNbResults();?> бичлэг
      </strong>
    </center>
  </div>
<?php }?>