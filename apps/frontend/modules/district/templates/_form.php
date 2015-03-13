<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for('district/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th><?php echo $form['name']->renderLabel() ?></th>
        <td>
          <?php echo $form['name']->renderError() ?>
          <?php echo $form['name'] ?>
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
            <?php echo link_to('Устгах', 'district/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Хорооллыг устгахдаа итгэлтэй байна уу?', 'class' => 'button')) ?>
          <?php endif; ?>
        </td>
      </tr>
      <tr>
        <td></td>
        <td>
          <a href="<?php echo url_for('district/index') ?>">Бүх хорооллууд</a>
        </td>
      </tr>
    </tfoot>
  </table>
</form>
