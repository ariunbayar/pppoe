<?php

/**
 * secure actions.
 *
 * @package    incris
 * @subpackage secure
 * @author     Ariunbayar
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class secureActions extends sfActions
{
  public function executeSecure(sfWebRequest $r)
  {
    $this->getUser()->setFlash('message', 'Энэ үйлдлийг хийхэд таны эрх хүрэлцэхгүй байна');
  }

  public function executeLogin(sfWebRequest $request)
  {
    if ($this->getUser()->isAuthenticated()) {
      $this->redirect('@homepage');
    }

    $this->form = new LoginForm();
  }

  public function executeSignIn(sfWebRequest $request)
  {
    if (!$request->isMethod('post')) $this->redirect('secure/login');

    $username = $request->getParameter('username');
    $password = $request->getParameter('password');

    $form = new LoginForm();
    $form->bind($request->getParameter($form->getName()));
    if ($form->isValid()) {
      $user = Doctrine_Core::getTable('User')->findOneByUsername($form->getValue('username'));
      $this->signIn($user);

      $this->redirect($this->generateUrl('homepage'));
    }

    $this->form = $form;
    $this->setTemplate('login');
  }

  private function signIn(User $user)
  {
    $u = $this->getUser();
    $u->setAuthenticated(true);
    $u->setAttribute('id', $user->getId());
    $u->setAttribute('username', $user->getUsername());
    $roles = explode(',', $user->getRole());
    foreach ($roles as $role) {
      $u->addCredential($role);
    }
  }

  public function executeLogout(sfWebRequest $request)
  {
    $u = $this->getUser();
    $u->setAttribute('id', null);
    $u->setAttribute('username', null);
    $u->setAuthenticated(false);
    $u->clearCredentials();

    $this->redirect('@homepage');
  }
}
