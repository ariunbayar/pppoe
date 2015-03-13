<?php use_helper('JavascriptBase')?>

<h1>Админууд</h1>

<?php echo link_to('Шинээр үүсгэх', 'user/new')?>

<table class="list">
  <thead>
    <tr>
      <th>Нэвтрэх нэр</th>
      <th>
        <?php echo link_to_function('Эрх', "$('.role_desc').show(); $('.role_show').hide(); $(this).hide(); $(this).next().show()")?>
        <?php echo link_to_function('Эрх', "$('.role_desc').hide(); $('.role_show').show(); $(this).hide(); $(this).prev().show()", array('style' => 'display:none'))?>
      </th>
      <th>Үүссэн</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($users as $i => $user): ?>
    <tr <?php if ($i%2) echo 'class="odd"'?>>
      <td><?php echo link_to($user->getUsername(), 'user/edit?id='.$user->getId()) ?></td>
      <td>
        <?php echo link_to_function('харуул', "$(this).next().show('blind'); $(this).hide()", array('class' => 'role_show'))?>
        <div class="role_desc" style="display: none;" onclick="$(this).prev().show(); $(this).hide()">
          <?php echo tools::translateRoles($user->getRole(), '<br/>') ?>
        </div>
      </td>
      <td><?php echo $user->getCreatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
