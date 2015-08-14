<?php

/*
 * DPMO * 
 * Copyright (C) 2014 Continental Automotive Systems Czech Republic s.r.o.  * 
 * Radek Nakoukal * 
 */

namespace Fakturace;

/**
 * Description of dpmosettingRepository
 *
 * @author uidv7359
 */
class FirmaRepository extends Repository{
	public function getNazevBy($by){		
		return $this->getTable()->select('Nazev')->where($by)->fetch();
	}
}
