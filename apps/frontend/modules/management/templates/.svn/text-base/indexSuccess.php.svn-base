<table class="list">
  <thead>
    <tr>
      <th colspan="5">Customer</th>
      <th colspan="3">Radcheck</th>
      <th colspan="3">Radreply</th>
      <th>Radusergroup</th>
    </tr>
    <tr>
      <th>Нэр</th>
      <th></th>
      <th>Хурд</th>
      <th>Нэвтрэх нэр</th>
      <th>Нууц үг</th>

      <th>Нэр</th>
      <th></th>
      <th>Нууц үг</th>

      <th>Нэр</th>
      <th>Хурд</th>
      <th>IP</th>
      
      <th>Нэр</th>
    </tr>
  </thead>
  <tbody>
  <?php
  $n = 0;
  $c1 = count($customers) - 1;
  $c2 = count($radchecks) - 1;
  $c3 = count($radreplies) - 1;
  $c4 = count($radusergroup) - 1;
  ?>
  <?php while ($c1 >= 0 || $c2 >= 0 || $c3 >= 0 || $c4 >= 0) {?>
    <?php
    $n++;
    $arr = array();
    if ($c1+1) { $c = $customers[$c1]; $arr[] = $c['username']; }
    if ($c2+1) { $rc = $radchecks[$c2]; $arr[] = $rc['username']; }
    if ($c3+1) { $rr = $radreplies[$c3]; $arr[] = $rr['username']; }
    if ($c4+1) { $ru = $radusergroup[$c4]; $arr[] = $ru['username']; }
    rsort($arr);
    $str = '';
    $str = array_pop($arr);
    $print_customer     = ($c1 >= 0) && ($str == $c['username']);
    $print_radcheck     = ($c2 >= 0) && ($str == $rc['username']);
    $print_radreply     = ($c3 >= 0) && ($str == $rr['username']);
    $print_radusergroup = ($c4 >= 0) && ($str == $ru['username']);
    ?>
    <tr class="<?php if ($n%2) echo 'odd'?>">
      <?php if ($print_customer) { $c1--; ?>
        <td><?php echo link_to($c['name'], 'customer/show?id='.$c['id']);?></td>
        <td><?php echo $speeds[$c['bandwidth_id']].'k'?></td>
        <td>
          <?php if (($c['is_blocked'] == 1) != ($rc['attr'] == 'blocked')) {?>
            <span class="red"><?php echo $c['is_blocked'] ? 'хаалттай' : ''?></span>
          <?php }else{?>
            <?php echo $c['is_blocked'] ? 'хаалттай' : ''?>
          <?php }?>
        </td>
        <td><?php echo $c['username']?></td>
        <td><?php echo $c['password']?></td>
      <?php }else{ echo str_repeat('<td></td>', 5); }?>
      <?php if ($print_radcheck) { $c2--; ?>
        <td><?php echo $rc['username']?></td>
        <td>
          <?php if ($rc['attr'] != 'Password') {?>
            <?php if ($c['is_blocked'] != 1 || $rc['attr'] != 'blocked') {?>
              <span class="red"><?php echo $rc['attr'] ?></span>
            <?php }else{?>
              <?php echo $rc['attr']?>
            <?php }?>
          <?php }?>
        </td>
        <td>
          <?php if (strlen($c['password']) || $rc['value'] == $c['password']) {?>
            <?php echo $rc['value']?>
          <?php }else{?>
            <span class="red"><?php echo $rc['value'] ?></span>
          <?php }?>
        </td>
      <?php }else{ echo str_repeat('<td></td>', 3); }?>
      <?php if ($print_radreply) { $c3--; ?>
        <td><?php echo $rr['username']?></td>
        <td>
          <?php if ($speeds[$c['bandwidth_id']] != $v = tools::ip2bandwidth($rr['ip'])) {?>
            <span class="red"><?php echo $v.'k'?></span>
          <?php }else{?>
            <?php echo $v.'k'?>
          <?php }?>
        </td>
        <td><?php echo $rr['ip']?></td>
      <?php }else{ echo str_repeat('<td></td>', 2); }?>
      <?php if ($print_radusergroup) { $c4--; ?>
        <td><?php echo $ru['username']?></td>
      <?php }else{ echo str_repeat('<td></td>', 1); }?>
    </tr>
  <?php }?>
  </tbody>
</table>
