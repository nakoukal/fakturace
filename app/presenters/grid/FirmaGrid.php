<?php
namespace App\Presenters;
use NiftyGrid\Grid;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FirmaGrid
 *
 * @author uidv7359
 */
class FirmaGrid extends Grid{
	public $firmaRepository;
	
	public function __construct($firmarepository)
    {
        parent::__construct();
		$this->firmaRepository = $firmarepository;
    }
	
	protected function configure($presenter)
    {
		
        //Vytvoříme si zdroj dat pro Grid
        //Při výběru dat vždy vybereme id
        $source = new \NiftyGrid\DataSource\NDataSource($this->firmaRepository->findAll());
        //Předáme zdroj
        $this->setDataSource($source);
		$this->setDefaultOrder("Nazev ASC");
		$this->gridName = "FIRMA";
		$this->addGlobalButton(Grid::ADD_ROW, 'Přidat nový záznam');
		$this->addColumn('Nazev', 'Název')
				->setTextEditable()
				->setTextFilter()
				->setAutocomplete();
		$this->addColumn('Adresa', 'Adresa')
				->setTextEditable()
				->setTextFilter()
				->setAutocomplete();
		$this->addColumn('Email', 'Email')
				->setTextEditable()
				->setTextFilter()
				->setAutocomplete();
		$this->addColumn('Timestamp', 'Timestamp', '170px')
				->setRenderer(function($row){return date('d.m.Y H:i:s', strtotime($row['Timestamp']));})
				->setDateTimeFilter();
				
		$self = $this;
		$this->setRowFormCallback(function($values) use($self){
			$data = array(
					"Nazev" => $values["Nazev"],
					"Adresa" => $values["Adresa"],
					"Email" => $values["Email"],
					);
			if(isset($values['FirmaID'])){
				//update
				$by = array('FirmaID'=>$values["FirmaID"]);
				$self->firmaRepository->updateTable($data,$by);
				$self->flashMessage("Nastaveni bylo zmeneno.", "grid-successful");
			}
			else{
				$self->firmaRepository->insertData($data);
				$this->flashMessage("Zázna byl uložen","grid-successful");
			}
        }
		);
		$this->addButton(Grid::ROW_FORM, "Rychlá editace")->setClass("fast-edit");
		$this->addButton("delete", "Smazat")
				->setClass("delete")
				->setLink(function($row) use ($self){return $self->link("delete!", $row['FirmaID']);})
				->setConfirmationDialog(function($row){return "Určitě chcete odstranit logy ".$row['FirmaID']."?";});
		}
		
		public function handleDelete($id)
    {
		$this->firmaRepository->findAll()->where('FirmaID',$id)->delete();
		if(count($id) > 1){
			$this->flashMessage("Vybrané logy byly úspěšně smazány.","grid-successful");
		}else{
			$this->flashMessage("Vybraný log byl úspěšně smazán","grid-successful");
		}        
        $this->redirect("this");
    }
		
	
}
