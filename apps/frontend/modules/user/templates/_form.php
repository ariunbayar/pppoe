<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for('user/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table class="form">
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th><?php echo $form['username']->renderLabel() ?></th>
        <td>
          <?php echo $form['username']->renderError() ?>
          <?php echo $form['username'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['reset']->renderLabel() ?></th>
        <td>
          <?php echo $form['reset']->renderError() ?>
          <?php echo $form['reset'] ?>
        </td>
      </tr>
      <tr id="password_row">
        <th><?php echo $form['password']->renderLabel() ?></th>
        <td>
          <?php echo $form['password']->renderError() ?>
          <?php echo $form['password'] ?>
        </td>
      </tr>
      <tr id="confirm_row">
        <th><?php echo $form['confirm']->renderLabel() ?></th>
        <td>
          <?php echo $form['confirm']->renderError() ?>
          <?php echo $form['confirm'] ?>
        </td>
      </tr>
      <tr>
        <th>
          <?php echo $form['role']->renderLabel() ?>
          <span class="form-help"><?php echo $form['role']->renderHelp()?></span>
        </th>
        <td>
          <?php echo $form['role']->renderError() ?>
          <?php echo $form['role'] ?>
        </td>
      </tr>
    </tbody>
    <tfoot>
      <tr>
        <td></td>
        <td>
          <?php echo $form->renderHiddenFields(false) ?>
          <input type="submit" value="Хадгалах" />
          <?php if (!$form->getObject()->isNew()): ?>
            <?php echo link_to('Устгах', 'user/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Админийг устгахдаа итгэлтэй байна уу?', 'class' => 'button')) ?>
          <?php endif; ?>
        </td>
      </tr>
      <tr>
        <td></td>
        <td><?php echo link_to('Админий жагсаалт', 'user/index')?></td>
      </tr>
    </tfoot>
  </table>
</form>

<script type="text/javascript">
//<![CDATA[
$(function(){
  $('#user_reset').change(function () {
    if ($(this).is(':checked')) {
      $('#password_row, #confirm_row').show();
    }else{
      $('#password_row, #confirm_row').hide();
    }
  });
  $('#user_reset').change();
});
//]]>
</script>