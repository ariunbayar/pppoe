<?php

/**
 * user actions.
 *
 * @package    pppoe
 * @subpackage user
 * @author     Ariunbayar
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class userActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->users = Doctrine_Core::getTable('User')
      ->createQuery('a')
      ->orderBy('a.username')
      ->execute();
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new UserForm();
    $this->form->setDefault('reset', true);
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new UserForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($user = Doctrine_Core::getTable('User')->find(array($request->getParameter('id'))), sprintf('Object user does not exist (%s).', $request->getParameter('id')));
    $this->form = new UserForm($user);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($user = Doctrine_Core::getTable('User')->find(array($request->getParameter('id'))), sprintf('Object user does not exist (%s).', $request->getParameter('id')));
    $this->form = new UserForm($user);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($user = Doctrine_Core::getTable('User')->find(array($request->getParameter('id'))), sprintf('Object user does not exist (%s).', $request->getParameter('id')));

    $msg = $this->getUser()->getUsername()." админийг устгалаа: ".$user->getUsername()."\n"
          .'Нэвтрэх нэр: '.$user->getUsername()."\n"
          .'Эрх: '.tools::translateRoles($user->getRole())."\n";
    ChangeLogTable::saveNew(null, 'user', $msg, $this->getUser()->getId());
    // update by object id
    Doctrine_Core::getTable('ChangeLog')->createQuery('cl')
            ->update()
            ->set('cl.object_id', '?', 0)
            ->where('cl.object_id=?', $user->getId())
            ->andWhere('cl.object=?', 'user')
            ->execute();
    // update by editor id
    Doctrine_Core::getTable('ChangeLog')->createQuery('cl')
            ->update()
            ->set('cl.editor_id', '?', 0)
            ->where('cl.editor_id=?', $user->getId())
            ->execute();

    $user->delete();

    $this->getUser()->setFlash('message', 'Админийг амжилттай устгалаа!');
    $this->redirect('user/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $is_new = $form->isNew();
      if (!$is_new) $values = $form->getObject()->toArray();
      $user = $form->save();

      if ($is_new){
        $msg = $this->getUser()->getUsername()." шинэ админ үүсгэлээ: ".$user->getUsername()."\n"
              .'Нэвтрэх нэр: '.$user->getUsername()."\n"
              .'Эрх: '.tools::translateRoles($user->getRole());
        ChangeLogTable::saveNew($user->getId(), 'user', $msg, $this->getUser()->getId());
      }else{
        $msg = '';
        if ($user->getUsername() != $values['username']) {
          $msg .= 'Нэвтрэх нэр: '.$values['username'].' -> '.$user->getUsername()."\n";
        }
        if ($user->getPassword() != $values['password']) {
          $msg .= 'Нууц үг: *** -> ***'."\n";
        }
        if ($user->getRole() != $values['role']) {
          $msg .= 'Эрх: '.tools::translateRoles($values['role']).' -> '.tools::translateRoles($user->getRole())."\n";
        }
        if ($msg != '') {
          $msg = $this->getUser()->getUsername()." админийг заслаа: ".$user->getUsername()."\n".$msg;
          ChangeLogTable::saveNew($user->getId(), 'user', $msg, $this->getUser()->getId());
        }
      }
      
      $this->getUser()->setFlash('message', 'Админий мэдээллийг амжилттай хадгаллаа!');
      $this->redirect('user/edit?id='.$user->getId());
    }
  }

  public function executeResetPassword(sfWebRequest $request)
  {
    $this->form = new ResetPasswordForm();
  }

  public function executeUpdatePassword(sfWebRequest $request)
  {
    if (!$request->isMethod('post')) $this->redirect('secure/resetPassword');

    $form = new ResetPasswordForm();
    $form->bind($request->getParameter($form->getName()));
    if ($form->isValid()) {
      $user = Doctrine_Core::getTable('User')->findOneById($this->getUser()->getId());
      $user->setPassword(md5($form->getValue('password')));
      $user->save();

      $msg = $this->getUser()->getUsername()." нууц үгээ өөрчиллөө";
      ChangeLogTable::saveNew(null, null, $msg, $this->getUser()->getId());

      $this->getUser()->setFlash('message', 'Таны нууц үг амжилттай өөрчлөгдлөө!');
      $this->redirect('user/resetPassword');
    }

    $this->form = $form;
    $this->setTemplate('resetPassword');
  }
}
