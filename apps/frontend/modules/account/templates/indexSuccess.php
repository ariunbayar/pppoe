<h1>Хэрэглэгчид</h1>
<table border="1">
  <tr>
    <th>Нэр</th>
    <th>Нууц үг</th>
    <th>IP</th>
    <th>Хурд</th>
    <th></th>
  </tr>
  <?php foreach ($accounts as $account) {?>
  <tr>
    <td><?php echo $account['username']?></td>
    <td><?php echo $account['password']?></td>
    <td><?php echo $account['ip']?></td>
    <td><?php echo $account['bandwidth']?></td>
    <td>
      <?php echo link_to('засах', 'account/edit?username='.$account['username'])?>
      <?php echo link_to('устгах', 'account/delete?username='.$account['username'], array('confirm' => 'Устгахдаа итгэлтэй байна уу?'))?>
    </td>
  </tr>
  <?php }?>
</table>