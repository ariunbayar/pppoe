<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
  </head>
  <body>
    <div id="wrapper">
      <div style="margin-bottom: 20px; padding: 20px;">
        <?php if ($sf_user->isAuthenticated()) {?>
          <?php echo link_to('Хэрэглэгчид', 'customer/index')?>
          <?php echo link_to('Хорооллууд', 'district/index')?>
          <?php echo link_to('Түүх', 'changelog/index')?>
          <?php echo link_to('Хэрэглээ', 'total_usage/index')?>
          <?php echo link_to('Админууд', 'user/index')?>
          <?php echo link_to('Тохиргоо', 'ipsetting/index')?>
          <?php echo link_to('Нууц үг', 'user/resetPassword')?>
          <?php echo link_to('Гарах', 'secure/logout')?>
        <span style="float:right;"><?php include_component('customer', 'totalUser')?></span>
        <?php }else{?>
          <?php echo link_to('Нэвтрэх', 'secure/login')?>
        <?php }?>
      </div>
      <?php if ($sf_user->hasFlash('message')) {?>
      <div id="message">
        <?php echo $sf_user->getFlash('message')?>
      </div>
      <?php }?>
      <?php echo $sf_content ?>
    </div>
  </body>
</html>
