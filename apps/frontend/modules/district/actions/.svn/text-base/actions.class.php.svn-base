<?php

/**
 * district actions.
 *
 * @package    pppoe
 * @subpackage district
 * @author     Ariunbayar
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class districtActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->districts = Doctrine_Core::getTable('District')
      ->createQuery('a')
      ->orderBy('a.name')
      ->execute();
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new DistrictForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new DistrictForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($district = Doctrine_Core::getTable('District')->find(array($request->getParameter('id'))), sprintf('Object district does not exist (%s).', $request->getParameter('id')));
    $this->form = new DistrictForm($district);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($district = Doctrine_Core::getTable('District')->find(array($request->getParameter('id'))), sprintf('Object district does not exist (%s).', $request->getParameter('id')));
    $this->form = new DistrictForm($district);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($district = Doctrine_Core::getTable('District')->find(array($request->getParameter('id'))), sprintf('Object district does not exist (%s).', $request->getParameter('id')));

    $msg = $this->getUser()->getUsername()." хорооллыг устгалаа: ".$district->getName();
    ChangeLogTable::saveNew(null, 'district', $msg, $this->getUser()->getId());
    // update by object id
    Doctrine_Core::getTable('ChangeLog')->createQuery('cl')
            ->update()
            ->set('cl.object_id', '?', 0)
            ->where('cl.object_id=?', $district->getId())
            ->andWhere('cl.object=?', 'district')
            ->execute();
    // TODO customers
    $district->delete();

    $this->getUser()->setFlash('message', 'Хорооллыг амжилттай устгалаа');
    $this->redirect('district/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid()) {
      $is_new = $form->isNew();
      if (!$is_new) $values = $form->getObject()->toArray();
      $district = $form->save();

      if ($is_new) {
        $msg = $this->getUser()->getUsername()." шинэ хороолол үүсгэлээ: ".$district->getName();
        ChangeLogTable::saveNew($district->getId(), 'district', $msg, $this->getUser()->getId());
      }elseif ($values['name'] != $district->getName()) {
        $msg = $this->getUser()->getUsername()." хорооллыг заслаа\n"
              .'Нэр: '.$values['name'].' -> '.$district->getName();
        ChangeLogTable::saveNew($district->getId(), 'district', $msg, $this->getUser()->getId());
      }

      $this->getUser()->setFlash('message', 'Хорооллыг амжилттай хадгаллаа');
      $this->redirect('district/edit?id='.$district->getId());
    }
  }
}
