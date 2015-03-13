<h1>Шинээр үүсгэх</h1>
<form method="post" action="<?php echo url_for('account/create')?>">
  <table border="1">
    <tr>
      <th align="right">Нэр ( A-Z, a-z, 0-9, _ )</th>
      <td>
        <input type="text" name="username" value="<?php echo $username?>"/>
      </td>
    </tr>
    <tr>
      <th align="right">Нууц үг ( A-Z, a-z, 0-9, _ )</th>
      <td>
        <input type="text" name="password" value="<?php echo $password?>"/>
      </td>
    </tr>
    <tr>
      <th align="right">Хурд</th>
      <td>
        <select name="sub">
          <?php foreach ($bandwidths as $i => $v) {?>
          <option value="<?php echo $i?>" <?php if ($i == $sub) echo 'selected'?>><?php echo $v?></option>
          <?php }?>
        </select>
      </td>
    </tr>
    <tr>
      <th></th>
      <td>
        <input type="submit" value="Хадгал"/>
      </td>
    </tr>
  </table>
</form>