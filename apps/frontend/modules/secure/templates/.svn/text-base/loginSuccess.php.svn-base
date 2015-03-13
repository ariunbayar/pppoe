<form action="<?php echo url_for('secure/signIn') ?>" method="post">
  <table class="form">
    <tbody>
      <tr>
        <th><?php echo $form['username']->renderLabel()?></th>
        <td>
          <?php echo $form['username']->renderError()?>
          <?php echo $form['username']->render()?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['password']->renderLabel()?></th>
        <td>
          <?php echo $form['password']->renderError()?>
          <?php echo $form['password']->render()?>
        </td>
      </tr>
    </tbody>
    <tfoot>
      <tr>
        <td></td>
        <td>
          <?php echo $form->renderHiddenFields()?>
          <input type="submit" value="Нэвтрэх" />
        </td>
      </tr>
    </tfoot>
  </table>
</form>