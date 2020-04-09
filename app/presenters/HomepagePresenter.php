<?php

namespace App\Presenters;

use Nette,
	App\Model;


/**
 * Homepage presenter.
 */
class HomepagePresenter extends BasePresenter
{
	private $firmaRepository;

	public function inject(\Fakturace\FirmaRepository $firmarepository)
    {
		$this->firmaRepository = $firmarepository;
    }
	
	public function renderDefault()
	{
		$firma = $this->firmaRepository->findAll()->fetchAll();		
		$this->template->firms = $firma;
	}

}
