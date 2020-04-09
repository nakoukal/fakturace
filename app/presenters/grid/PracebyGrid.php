<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Presenters;
use NiftyGrid\Grid;

/**
 * Description of PraceGridByFaktura
 *
 * @author uidv7359
 */
class PracebyGrid extends Grid{
	private $praceRepository;
	private $fakturaRepository;
	private $typRepository;
	private $fakturaID;
	private $PraceID;
	
	
	public function __construct($pracerepository,$fakturarepository,$typrepository,$fakturaid)
    {
        parent::__construct();
		$this->praceRepository = $pracerepository;
		$this->fakturaRepository = $fakturarepository;
		$this->typRepository = $typrepository;
		$this->fakturaID = $fakturaid;
    }
	
	protected function configure($presenter)
    {
		
        //Vytvoříme si zdroj dat pro Grid
        //Při výběru dat vždy vybereme id
        $source = new \NiftyGrid\DataSource\NDataSource($this->praceRepository->GetTabledataBy(array('FakturaID'=>$this->fakturaID)));
        //Předáme zdroj
        $this->setDataSource($source);
		$this->setDefaultOrder("PraceID ASC");
		$this->gridName = "PRACE";
		$this->width = "1000px";
		$this->export = TRUE;
		$this->addGlobalButton(Grid::ADD_ROW, 'Přidat nový záznam');
		$this->addGlobalButton('fakturace', 'Fakturace')
				->setClass("link")
				->setAjax(false)
				->setLink($presenter->link('Faktura:default'));
		$this->addColumn('TypID', 'TypID','70px')
				->setRenderer(function($row){$typArr = $this->typRepository->getTypBy(array('TypID'=>$row['TypID']));return $typArr['Typ'];})
				->setSelectEditable($this->typRepository->findAll()->order('Typ')->fetchPairs('TypID','Typ'));
		$this->addColumn('Popis', 'Popis','300px')
				->setTextEditable(true);
		$this->addColumn('Datum', 'Datum','130px')				
				->setDateTimeEditable()
				->setRenderer(function($row){return date('d.m.Y H:i', strtotime($row['Datum']));});
		$this->addColumn('Delka', 'Delka','50px')
				->setTextEditable();
		$this->addColumn('Cena', 'Cena','70px')
				->setTextEditable();				
		$this->addColumn('Timestamp', 'Timestamp', '170px')
				->setRenderer(function($row){return date('d.m.Y H:i', strtotime($row['Timestamp']));});
		
		
				
		$self = $this;
		$this->setRowFormCallback(function($values) use($self){
			$data = array(
					"FakturaID" => $this->fakturaID,
					"TypID" => $values["TypID"],
					"Datum" => date('Y-m-d H:i', strtotime($values['Datum'])),
					"Popis" => $values['Popis'],
					"Delka" => $values["Delka"],
					"Cena" => $values["Cena"],
					"Timestamp" => date('Y-m-d H:i'),
					);
			if(isset($values['PraceID'])){
				//update
				$this->PraceID = $values["PraceID"];
				$by = array('PraceID'=>$this->PraceID);
				$self->praceRepository->updateTable($data,$by);
				$self->flashMessage("Nastaveni bylo zmeneno.", "grid-successful");
			}
			else{
				$row = $self->praceRepository->insertData($data);
				$self->PraceID = $row->PraceID;				
				$self->flashMessage("Zázna byl uložen ".$this->PraceID,"grid-successful");
			}
			if($values["TypID"]!=7)
				$self->praceRepository->updateCena($this->PraceID);
			//update cena at faktura
			$self->updateCena();
        }
		);
		$this->addButton(Grid::ROW_FORM, "Rychlá editace")->setClass("fast-edit");
		$this->addButton("delete", "Smazat")
				->setClass("delete")
				->setLink(function($row) use ($self){return $self->link("delete!", $row['PraceID']);})
				->setConfirmationDialog(function($row){return "Určitě chcete odstranit logy ".$row['PraceID']."?";});
		}
		
	public function handleDelete($id)
    {
		$this->praceRepository->findAll()->where('PraceID',$id)->delete();
		if(count($id) > 1){
			$this->flashMessage("Vybrané logy byly úspěšně smazány.","grid-successful");
		}else{
			$this->flashMessage("Vybraný log byl úspěšně smazán","grid-successful");
		}
		$this->updateCena();
        $this->redirect("this");
    }
	
	public function updateCena(){
		//update cena at faktura
		$CenaArr=$this->praceRepository->findBy(array('FakturaID'=>$this->fakturaID))->select('SUM(Cena) Cena')->fetch();
		$Cena = $CenaArr["Cena"];
		$this->fakturaRepository->updateTable(array('Cena'=>$Cena),array('FakturaID'=>$this->fakturaID));
	}
}
