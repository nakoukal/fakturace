<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Presenters;

/**
 * Description of PracePresenter
 *
 * @author uidv7359
 */
class PracebyPresenter  extends BasePresenter{
	private $praceRepository;
	private $fakturaRepository;
	private $typRepository;
	private $fakturaID;
	
	public function inject(	\Fakturace\PraceRepository $pracerepository,
							\Fakturace\FakturaRepository $fakturarepository,
							\Fakturace\TypRepository $typrepository)
    {
		$this->praceRepository = $pracerepository;
		$this->fakturaRepository = $fakturarepository;
		$this->typRepository = $typrepository;
    }
	
	protected function createComponentPracebyGrid(){
		return new PracebyGrid($this->praceRepository,$this->fakturaRepository,$this->typRepository,$this->fakturaID);
	}
	
	public function actionDefault($id){
		$this->fakturaID =  $id;	
	} 
}
