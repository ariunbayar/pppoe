<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>
<?php use_helper('JavascriptBase')?>
<?php $sf_response->addJavascript('jquery.ui.datepicker-mn.js')?>

<form action="<?php echo url_for('customer/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table class="form">
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th>
          <b>*</b>
          <?php echo $form['name']->renderLabel() ?>
        </th>
        <td>
          <?php echo $form['name']->renderError() ?>
          <?php echo $form['name'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['district_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['district_id']->renderError() ?>
          <?php echo $form['district_id'] ?>
        </td>
      </tr>
      <tr>
        <th>
          <b>*</b>
          <?php echo $form['bair']->renderLabel() ?>
        </th>
        <td>
          <?php echo $form['bair']->renderError() ?>
          <?php echo $form['bair'] ?>
        </td>
      </tr>
      <tr>
        <th>
          <b>*</b>
          <?php echo $form['toot']->renderLabel() ?>
        </th>
        <td>
          <?php echo $form['toot']->renderError() ?>
          <?php echo $form['toot'] ?>
        </td>
      </tr>
      <tr>
        <th>
          <b>*</b>
          <?php echo $form['username']->renderLabel() ?>
        </th>
        <td>
          <?php echo $form['username']->renderError() ?>
          <?php echo $form['username'] ?>
        </td>
      </tr>
      <tr>
        <th>
          <b>*</b>
          <?php echo $form['password']->renderLabel() ?>
        </th>
        <td>
          <?php echo $form['password']->renderError() ?>
          <?php echo $form['password'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['bandwidth_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['bandwidth_id']->renderError() ?>
          <?php echo $form['bandwidth_id'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['payment']->renderLabel() ?></th>
        <td>
          <?php echo $form['payment']->renderError() ?>
          <?php echo $form['payment'] ?>
        </td>
      </tr>
      <tr>
        <th>
          Утасны дугаар<br/>
          <span class="form-help">Хоосон үлдээсэн нүд хадгалагдахгүй</span>
        </th>
        <td>
          <?php if (!$form->isNew()) foreach ($form->getObject()->getPhones() as $phone) echo '<input type="text" name="customer[phones][]" size="10" value="'.$phone->getDescription().'"/><br/>'?>
          <input type="text" name="customer[phones][]" size="10"/>
          <?php echo link_to_function('нэмэх', "$(this).before('<br/><input type=\"text\" name=\"customer[phones][]\" size=\"10\"/>')")?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['description']->renderLabel() ?></th>
        <td>
          <?php echo $form['description']->renderError() ?>
          <?php echo $form['description'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['is_blocked']->renderLabel() ?></th>
        <td>
          <?php echo $form['is_blocked']->renderError() ?>
          <?php echo $form['is_blocked'] ?>
        </td>
      </tr>
      <tr>
        <th>
          Автоматаар хаагдах / нээгдэх<br/>
          <?php if ($form->getObject()->isNew()) {?>
            <span class="form-help">Хадгалсаны дараа энэ мэдээллийг өөрчлөнө үү</span>
          <?php }?>
        </th>
        <td>
          <?php if (!$form->getObject()->isNew()) {?>
            <?php foreach ($form->getObject()->getOrderedNextActions() as $next_action) {?>
              <?php echo $next_action->getDateTimeObject('date')->format('Y-m-d H:i')?>
              <span class="<?php echo $next_action->getAction() == 'block' ? 'red' : 'green'?>">
                <?php echo $next_action->getAction() == 'block' ? 'хаагдана' : 'нээгдэнэ'?>
              </span>
              <?php echo link_to('устгах', 'next_action/delete?id='.$next_action->getId(), array('method' => 'delete', 'confirm' => 'Энэ автомат үйлдлийг устгахдаа итгэлтэй байна уу?')) ?>
              <br/>
            <?php }?>
            <?php
            echo $form['nex_date']->renderError();
            echo $form['nex_time']->renderError();
            echo $form['nex_action']->renderError();
            echo $form['nex_date'];
            echo $form['nex_time'];
            echo $form['nex_action'];
            ?>
            <script type="text/javascript">
            //<![CDATA[
            $(function(){ $("#customer_nex_date").datepicker(); } );
            //]]>
            </script>
          <?php }?>
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
            <?php echo link_to('Устгах', 'customer/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Хэрэглэгчийг устгахдаа итгэлтэй байна уу?', 'class' => 'button')) ?>
          <?php endif; ?>
        </td>
      </tr>
      <tr>
        <td></td>
        <td>
          <a href="<?php echo url_for('customer/index') ?>">Бүх хэрэглэгчид</a>
        </td>
      </tr>
    </tfoot>
  </table>
</form>
