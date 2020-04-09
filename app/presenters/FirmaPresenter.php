<?php
namespace App\Presenters;
use Nette,App\Model;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FirmaPresenter
 *
 * @author uidv7359
 */
class FirmaPresenter extends BasePresenter{
	private $firmaRepository;

	public function inject(\Fakturace\FirmaRepository $firmarepository)
    {
		$this->firmaRepository = $firmarepository;
    }
	
	
	protected function createComponentFirmaGrid(){
		return new FirmaGrid($this->firmaRepository);
	}
}
