<?php

class myUser extends sfBasicSecurityUser
{
  public function getId()
  {
    return $this->getAttribute('id');
  }

  public function getUsername()
  {
    return $this->getAttribute('username');
  }
}
