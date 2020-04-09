<?php
namespace App\Presenters;
use NiftyGrid\Grid;

class FakturaGrid extends Grid{
	public $fakturaRepository;
	public $firmaRepository;
	public $praceRepository;
	public $typRepository;
	
	public function __construct($fakturarepository,$firmarepository,$pracerepository,$typrepository)
    {
        parent::__construct();
		$this->fakturaRepository = $fakturarepository;
		$this->firmaRepository = $firmarepository;
		$this->praceRepository = $pracerepository;
		$this->typRepository = $typrepository;
    }
	
	protected function configure($presenter)
    {
		
        //Vytvoříme si zdroj dat pro Grid
        //Při výběru dat vždy vybereme id
        $source = new \NiftyGrid\DataSource\NDataSource($this->fakturaRepository->GetTabledata());
        //Předáme zdroj
        $this->setDataSource($source);
		$this->setDefaultOrder("Datum ASC");
		$this->gridName = "FAKTURA";
		$this->addGlobalButton(Grid::ADD_ROW, 'Přidat nový záznam');
		
		$this->addSubGrid("FakturaID2", "Zobrazit práci")
			->setGrid(new \App\Presenters\PracebyGrid($this->praceRepository, $this->fakturaRepository, $this->typRepository, $this->activeSubGridId))
			->settings(function($grid){$grid->setDefaultOrder("prace.Datum ASC");})
			->setCellStyle("background-color:#f6f6f6; padding:20px;");
			
		$this->addColumn('FakturaID', 'FID','50px')
				->setTextFilter()
				->setAutocomplete();
		$this->addColumn('Datum', 'Datum', '130px')
				->setDateTimeEditable()
				->setRenderer(function($row){return ($row['Datum']==NULL)?'':date('d.m.Y H:i', strtotime($row['Datum']));})
				->setDateTimeFilter();
		$this->addColumn('FirmaID', 'Firma')
				->setRenderer(function($row){$typArr = $this->firmaRepository->getNazevBy(array('FirmaID'=>$row['FirmaID']));return $typArr['Nazev'];})				
				->setSelectEditable($this->firmaRepository->findAll()->order('Nazev')->fetchPairs('FirmaID','Nazev'))
				->setTextFilter()
				->setAutocomplete();
		$this->addColumn('Cena', 'Cena');
		
		$this->addColumn('Zaplaceno', 'Zaplaceno', '130px')
				->setDateEditable()
//				->setRenderer(function($row){return ($row['Zaplaceno']==NULL)?'':date('d.m.Y', strtotime($row['Zaplaceno']));})
				->setCellRenderer(function($row){return (Date('Y-m-d', strtotime($row['Zaplaceno'])) > Date('Y-m-d',strtotime('2000-01-01'))) ? "background-color:#E4FFCC" : "background-color:#ff0000";})
				->setDateTimeFilter();
		$this->addColumn('Poznamka', 'Poznamka','200px')
				->setTextEditable();
				
		$self = $this;
		$this->setRowFormCallback(function($values) use($self){
			$data = array(
				"FirmaID" => $values["FirmaID"],
				"Datum" => date('Y-m-d H:i', strtotime($values['Datum'])),
				"Zaplaceno" => date('Y-m-d', strtotime($values['Zaplaceno'])),
				"Poznamka" => $values["Poznamka"],
			);

			if(isset($values['FakturaID'])){
				//update
				$by = array('FakturaID'=>$values["FakturaID"]);
				$self->fakturaRepository->updateTable($data,$by);
				$self->flashMessage("Nastaveni bylo zmeneno.", "grid-successful");
			}
			else{
				//insert
				$self->fakturaRepository->insertData($data);
				$this->flashMessage("Zázna byl uložen","grid-successful");
			}
        }
		);
		$this->addButton(Grid::ROW_FORM, "Rychlá editace")->setClass("fast-edit");
		$this->addButton("delete", "Smazat")
				->setClass("delete")
				->setLink(function($row) use ($self){return $self->link("delete!", $row['FakturaID']);})
				->setConfirmationDialog(function($row){return "Určitě chcete odstranit logy ".$row['FakturaID']."?";});
		$this->addButton("add","Přidat")
				->setClass("edit")
				->setAjax(false)
				->setLink(function($row) use ($presenter){return $presenter->link('Praceby:default',array('id'=>$row['FakturaID']));});
		$this->addButton("print","Pdf")
				->setClass("print")
				->setAjax(false)
				->setLink(function($row) use ($presenter){return $presenter->link('Faktura:pdf',array('id'=>$row['FakturaID']));});
	}
		
	public function handleDelete($id)
    {
		$this->fakturaRepository->findAll()->where('FakturaID',$id)->delete();
		if(count($id) > 1){
			$this->flashMessage("Vybrané logy byly úspěšně smazány.","grid-successful");
		}else{
			$this->flashMessage("Vybraný log byl úspěšně smazán","grid-successful");
		}        
        $this->redirect("this");
    }
}
