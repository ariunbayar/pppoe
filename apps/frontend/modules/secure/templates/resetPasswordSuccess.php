<form action="<?php echo url_for('secure/updatePassword') ?>" method="post">
  <table class="form">
    <tbody>
      <tr>
        <th><?php echo $form['password']->renderLabel()?></th>
        <td>
          <?php echo $form['password']->render()?>
          <?php echo $form['password']->renderError()?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['confirm']->renderLabel()?></th>
        <td>
          <?php echo $form['confirm']->render()?>
          <?php echo $form['confirm']->renderError()?>
        </td>
      </tr>
    </tbody>
    <tfoot>
      <tr>
        <td></td>
        <td>
          <?php echo $form->renderHiddenFields()?>
          <input type="submit" value="Үргэлжлүүл" />
        </td>
      </tr>
    </tfoot>
  </table>
</form>