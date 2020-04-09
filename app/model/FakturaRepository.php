<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Fakturace;
/**
 * Description of FakturaRepository
 *
 * @author uidv7359
 */
class FakturaRepository extends Repository{
	public function GetTabledata() {
		return $this->getTable()->select('FakturaID,FakturaID FakturaID2,FirmaID,Datum,Cena,Zaplaceno,Poznamka')->order('Datum DESC');
	}
	public function updateCena($PraceID){
		$sql="UPDATE prace P JOIN typ T ON P.TypID=T.TypID
				SET P.Cena = P.Delka*T.Cena
				WHERE P.PraceID=$PraceID";
		return $this->context->query($sql);
	}
	
}
