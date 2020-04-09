<?php
namespace App\Presenters;
use Nette,App\Model;
use Joseki\Application\Responses\PdfResponse;
use Nette\Mail\SendmailMailer;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FakturaPresenter
 *
 * @author uidv7359
 */
class FakturaPresenter extends BasePresenter{
	private $fakturaRepository;
	private $firmaRepository;
	private $praceRepository;	
	private $typRepository;

	public function inject(\Fakturace\FakturaRepository $fakturarepository,
							\Fakturace\FirmaRepository $firmarepository,
							\Fakturace\PraceRepository $pracerepository,
							\Fakturace\TypRepository $typrepository)
    {
		$this->fakturaRepository = $fakturarepository;
		$this->firmaRepository = $firmarepository;
		$this->praceRepository = $pracerepository;		
		$this->typRepository = $typrepository;
    }
	
	
	protected function createComponentFakturaGrid(){
		return new FakturaGrid($this->fakturaRepository,$this->firmaRepository,$this->praceRepository,$this->typRepository);
	}
	
	public function renderTopdf(){
		$this->template->works = $this->praceRepository->findAll()->where(array('FakturaID'=>'2'));
	}
	
	public function actionPdf($id)
	{
		$template = $this->createTemplate();
		$template->setFile(dirname(__FILE__)."/../templates/Faktura/topdf.latte");
		$template->works = $this->praceRepository->findAll()->where(array('FakturaID'=>$id));
		$template->faktura = $this->fakturaRepository->findBy(array('FakturaID'=>$id))->fetch();
		$template->today = date('d.m.Y');
		$pdf = new PdfResponse($template);
		$pdf->setSaveMode(PdfResponse::INLINE);
		$this->sendResponse($pdf);
	}
	
	public function actionMailpdf($id){
		$template = $this->createTemplate();
		$template->setFile(dirname(__FILE__)."/../templates/Faktura/topdf.latte");
		$template->works = $this->praceRepository->findAll()->where(array('FakturaID'=>$id));
		$template->faktura = $this->fakturaRepository->findBy(array('FakturaID'=>$id))->fetch();
		$template->today = date('d.m.Y');
		$pdf = new PdfResponse($template);
		$savedFile = $pdf->save(dirname(__FILE__)."/../../temp/");
		$mail = new Nette\Mail\Message;
		$mail->addTo("radek@nakoukal.com");
		$mail->addAttachment($savedFile);
		$mailer = new SendmailMailer();
		$mailer->send($mail);
	}
}
