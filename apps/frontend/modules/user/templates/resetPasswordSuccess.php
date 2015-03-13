<form action="<?php echo url_for('user/updatePassword') ?>" method="post">
  <table class="form">
    <tbody>
      <tr>
        <th><?php echo $form['password']->renderLabel()?></th>
        <td>
          <?php echo $form['password']->renderError()?>
          <?php echo $form['password']->render()?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['confirm']->renderLabel()?></th>
        <td>
          <?php echo $form['confirm']->renderError()?>
          <?php echo $form['confirm']->render()?>
        </td>
      </tr>
    </tbody>
    <tfoot>
      <tr>
        <td></td>
        <td>
          <?php echo $form->renderHiddenFields()?>
          <input type="submit" value="Өөрчил" />
        </td>
      </tr>
    </tfoot>
  </table>
</form>