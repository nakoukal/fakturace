<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Fakturace;

/**
 * Description of PraceRepository
 *
 * @author uidv7359
 */
class PraceRepository extends Repository{
		
	public function GetTabledataBy($by) {
		return $this->getTable()->where($by)->select('prace.PraceID,typ.Typ,prace.TypID,prace.FakturaID,prace.Datum,prace.Delka,prace.Popis,prace.Timestamp,prace.Cena');
	}
	
	public function GetTabledata() {
		return $this->getTable()->select('prace.PraceID,prace.TypID,prace.FakturaID,prace.Datum,prace.Delka,prace.Popis,prace.Timestamp,prace.Cena');
	}
	
	public function updateCena($PraceID){
		$sql="UPDATE prace P JOIN typ T ON P.TypID=T.TypID
				SET P.Cena = P.Delka*T.Cena
				WHERE P.PraceID=$PraceID";
		return $this->context->query($sql);
	}
}
