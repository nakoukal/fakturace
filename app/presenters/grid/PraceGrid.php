<?php
namespace App\Presenters;
use NiftyGrid\Grid;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PraceGrid
 *
 * @author uidv7359
 */
class PraceGrid extends Grid{
	private $praceRepository;
	private $fakturaRepository;
	private $typRepository;
	
	
	public function __construct($pracerepository,$fakturarepository,$typrepository)
    {
        parent::__construct();
		$this->praceRepository = $pracerepository;
		$this->fakturaRepository = $fakturarepository;
		$this->typRepository = $typrepository;
    }
	
	protected function configure($presenter)
    {
		
        //Vytvoříme si zdroj dat pro Grid
        //Při výběru dat vždy vybereme id
        $source = new \NiftyGrid\DataSource\NDataSource($this->praceRepository->findAll());
        //Předáme zdroj
        $this->setDataSource($source);
		$this->setDefaultOrder("Datum ASC");
		$this->gridName = "PRACE";
		$this->paginate = FALSE;
		$this->width = "1200px";
		$this->addGlobalButton(Grid::ADD_ROW, 'Přidat nový záznam');
		$this->addColumn('FakturaID', 'FID','50px')
				->setSelectFilter($this->fakturaRepository->findAll()->fetchPairs('FakturaID','FakturaID'))
				;
		
		$this->addColumn('TypID', 'TypID','90px')
				->setRenderer(function($row){$typArr = $this->typRepository->getTypBy(array('TypID'=>$row['TypID']));return $typArr['Typ'];})
				->setSelectFilter($this->typRepository->findAll()->order('Typ')->fetchPairs('TypID','Typ'))
				//->setSelectEditable($this->typRepository->findAll()->order('Typ')->fetchPairs('TypID','Typ'));
				//->setTextFilter()
				;
				
		$this->addColumn('Popis', 'Popis','350px')
				->setTextFilter()
				//->setTextEditable(true)
				;
		
		$this->addColumn('Datum', 'Datum','150px')
				->setRenderer(function($row){return date('d.m.Y H:i:s', strtotime($row['Datum']));})
				->setDateTimeFilter()
				//->setDateTimeEditable()
				;
				
		$this->addColumn('Delka', 'Delka','50px')
				->setNumericFilter()
				//->setTextEditable()
				;
		
		$this->addColumn('Cena', 'Cena','70px')
				->setNumericFilter()
				//->setTextEditable()
				;
		
		$this->addColumn('Timestamp', 'Timestamp', '150px')
				->setRenderer(function($row){return date('d.m.Y H:i:s', strtotime($row['Timestamp']));})
				->setDateTimeFilter()
				;
		/*
		$self = $this;
		
		$this->setRowFormCallback(function($values) use($self){
			$data = array(
					"FakturaID" => $values["FakturaID"],
					"TypID" => $values["TypID"],
					"Datum" => date('Y-m-d H:i:s', strtotime($values['Datum'])),
					"Delka" => $values["Delka"],
					"Cena" => $values["Cena"],
					"Timestamp" => date('Y-m-d H:i:s'),
					);
			if(isset($values['PraceID'])){
				//update
				$by = array('PraceID'=>$values["PraceID"]);
				$self->praceRepository->updateTable($data,$by);
				$self->fakturaRepository->updateCena(array('FakturaID'=>$values["FakturaID"]));
				$self->flashMessage("Nastaveni bylo zmeneno.", "grid-successful");
			}
			else{
				$self->praceRepository->insertData($data);
				$this->flashMessage("Zázna byl uložen","grid-successful");
			}
        }
		);
		$this->addButton(Grid::ROW_FORM, "Rychlá editace")->setClass("fast-edit");
		$this->addButton("delete", "Smazat")
				->setClass("delete")
				->setLink(function($row) use ($self){return $self->link("delete!", $row['PraceID']);})
				->setConfirmationDialog(function($row){return "Určitě chcete odstranit logy ".$row['PraceID']."?";});
		 * 
		 */
	}
		
		
	public function handleDelete($id)
    {
		$this->praceRepository->findAll()->where('PraceID',$id)->delete();
		if(count($id) > 1){
			$this->flashMessage("Vybrané logy byly úspěšně smazány.","grid-successful");
		}else{
			$this->flashMessage("Vybraný log byl úspěšně smazán","grid-successful");
		}        
        $this->redirect("this");
    }	
}
