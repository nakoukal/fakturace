<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Fakturace;
/**
 * Description of TypRepository
 *
 * @author uidv7359
 */
class TypRepository extends Repository{
	public function getTypBy($by){
		return $this->getTable()->select('Typ')->where($by)->fetch();
	}
}
