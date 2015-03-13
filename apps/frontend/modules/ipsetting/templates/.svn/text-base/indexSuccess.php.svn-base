<span class="red">АНХААР! Хэрэв таны оруулсан тохиргоо буруу бол сервер лүү хандах боломжгүй болох аюултай.</span>

<form action="<?php echo url_for('ipsetting/save')?>" method="post">
  <table class="form">
    <tr>
      <th>
        IP Хаяг<br/>
        <span class="form-help">жишээ нь 202.131.0.10</span>
      </th>
      <td>
        <input type="text" name="ip_address" value="<?php echo $ip_address?>"/>
      </td>
    </tr>
    <tr>
      <th>
        Subnet mask<br/>
        <span class="form-help">жишээ нь 255.255.255.252</span>
      </th>
      <td>
        <input type="text" name="subnet" value="<?php echo $subnet?>"/>
      </td>
    </tr>
    <tr>
      <th>
        Gateway Хаяг<br/>
        <span class="form-help">жишээ нь 202.131.0.9</span>
      </th>
      <td>
        <input type="text" name="gateway" value="<?php echo $gateway?>"/>
      </td>
    </tr>
    <tr>
      <th>
        DNS Хаягууд<br/>
        <span class="form-help">жишээ нь 202.131.0.2 202.131.0.3<br/> Олон DNS хаяг оруулахдаа зайгаар тусгаарлана уу</span>
      </th>
      <td>
        <input type="text" name="dns" value="<?php echo $dns?>"/>
      </td>
    </tr>
    <tr>
      <th></th>
      <td><input type="submit" value="Хадгалах"/></td>
    </tr>
    <tr>
      <th></th>
      <td>
        <?php if ($in_progress) {?>
          <span class="red">Тохиргоог идэвхижүүлж байна...</span><br/>
        <?php }?>
        <?php echo link_to('Тохиргоог идэвхижүүлэх', 'ipsetting/activate', array('class' => 'button'))?>
      </td>
    </tr>
  </table>
</form>
