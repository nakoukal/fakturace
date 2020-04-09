<?php
/**
 * NiftyGrid - DataGrid for Nette
 *
 * @author	Jakub Holub
 * @copyright	Copyright (c) 2012 Jakub Holub
 * @license     New BSD Licence
 * @link        http://addons.nette.org/cs/niftygrid
 */
namespace NiftyGrid;

use Nette\Utils\Strings;
/**
 * @author     Jakub Holub
 */
class FilterCondition extends \Nette\Object
{
	/* filter types */
	const TEXT = "text";
	const SELECT = "select";
	const NUMERIC = "numeric";
	const DATE = "date";
	const DATETIME = "datetime";
	const BOOLEAN = "boolean";

	/* condition types */
	const WHERE = " WHERE ";

	/* conditions names */
	const CONTAINS = "contains";
	const STARTSWITH = "startsWith";
	const ENDSWITH = "endsWith";
	const EQUAL = "equal";
	const HIGHER = "higher";
	const HIGHEREQUAL = "higherEqual";
	const LOWER = "lower";
	const LOWEREQUAL = "lowerEqual";
	const DIFFERENT = "different";

	const DATE_EQUAL = "dateEqual";
	const DATE_HIGHER = "dateHigher";
	const DATE_HIGHEREQUAL = "dateHigherEqual";
	const DATE_LOWER = "dateLower";
	const DATE_LOWEREQUAL = "dateLowerEqual";
	const DATE_DIFFERENT = "dateDifferent";
	
	const DATETIME_EQUAL = "datetimeEqual";
	const DATETIME_HIGHER = "datetimeHigher";
	const DATETIME_HIGHEREQUAL = "datetimeHigherEqual";
	const DATETIME_LOWER = "datetimeLower";
	const DATETIME_LOWEREQUAL = "datetimeLowerEqual";
	const DATETIME_DIFFERENT = "datetimeDifferent";

	/**
	 * @static
	 * @param string $s
	 * @return mixed
	 */
	public static function like($s)
	{
		$escape = array(".", "%","_", "'");
		$replace = array("\.", "\%", "\_");
		return str_replace($escape, $replace, $s);
	}

	/**
	 * @static
	 * @param string $type
	 * @return array
	 */
	public static function getConditionsByType($type)
	{
		if($type == self::TEXT)
			return array(
				self::ENDSWITH => "%",
				self::STARTSWITH => "%",
			);
		elseif($type == self::DATE)
			return array(
				self::DATE_EQUAL => "=",
				self::DATE_DIFFERENT => "<>",
				self::DATE_HIGHEREQUAL => ">=",
				self::DATE_HIGHER => ">",
				self::DATE_LOWEREQUAL => "<=",
				self::DATE_LOWER => "<",
			);
		elseif($type == self::DATETIME)
			return array(
				self::DATETIME_EQUAL => "=",
				self::DATETIME_DIFFERENT => "<>",
				self::DATETIME_HIGHEREQUAL => ">=",
				self::DATETIME_HIGHER => ">",
				self::DATETIME_LOWEREQUAL => "<=",
				self::DATETIME_LOWER => "<",
			);
		elseif($type == self::NUMERIC)
			return array(
				self::EQUAL => "=",
				self::DIFFERENT => "<>",
				self::HIGHEREQUAL => ">=",
				self::HIGHER => ">",
				self::LOWEREQUAL => "<=",
				self::LOWER => "<",
			);
	}

	/**
	 * @static
	 * @param string $value
	 * @param string $type
	 * @return array
	 */
	public static function prepareFilter($value, $type)
	{
		/* select nebo boolean muze byt pouze equal */
		if($type == self::SELECT || $type == self::BOOLEAN)
			return array(
				"condition" => self::EQUAL,
				"value" => $value
			);
		elseif($type == self::TEXT){
			foreach(self::getConditionsByType(self::TEXT) as $name => $condition){
					if(Strings::endsWith($value, $condition) && !Strings::startsWith($value, $condition) && $name == self::STARTSWITH)
						return array(
							"condition" => $name,
							"value" => Strings::substring($value, 0,"-".Strings::length($condition))
						);
					elseif(Strings::startsWith($value, $condition) && !Strings::endsWith($value, $condition) && $name == self::ENDSWITH)
						return array(
							"condition" => $name,
							"value" => Strings::substring($value, Strings::length($condition))
						);
			}
			return array(
				"condition" => self::CONTAINS,
				"value" => $value
			);
		}
		elseif($type == self::DATE){
			foreach(self::getConditionsByType(self::DATE) as $name => $condition){
				if(Strings::startsWith($value, $condition))
					return array(
						"condition" => $name,
						"value" => self::dbdateConvert(Strings::substring($value, Strings::length($condition)))
					);
			}
			return array(
				"condition" => self::DATE_EQUAL,
				"value" => self::dbdateConvert($value)
			);
		}
		elseif($type == self::DATETIME){
			foreach(self::getConditionsByType(self::DATETIME) as $name => $condition){
				if(Strings::startsWith($value, $condition))
					return array(
						"condition" => $name,
						"value" => self::dbdatetimeConvert(Strings::substring($value, Strings::length($condition)))
					);
			}
			return array(
				"condition" => self::DATETIME_EQUAL,
				"value" => self::dbdatetimeConvert($value)
			);
		}
		elseif($type == self::NUMERIC){
			foreach(self::getConditionsByType(self::NUMERIC) as $name => $condition){
				if(Strings::startsWith($value, $condition))
					return array(
						"condition" => $name,
						"value" => (int) Strings::substring($value, Strings::length($condition))
					);
			}
			return array(
				"condition" => self::EQUAL,
				"value" => (int) $value
			);
		}
	}

	/**
	 * @static
	 * @param string $value
	 * @return array
	 */
	public static function contains($value)
	{
		return array(
			"type" => self::WHERE,
			"datatype" => self::TEXT,
			"cond" => " LIKE ?",
			"value" => "%".self::like($value)."%",
		);
	}

	/**
	 * @static
	 * @param string $value
	 * @return array
	 */
	public static function equal($value)
	{
		return array(
			"type" => self::WHERE,
			"datatype" => self::TEXT,
			"cond" => " = ?",
			"value" => $value,
		);
	}

	/**
	 * @static
	 * @param string $value
	 * @return array
	 */
	public static function startsWith($value)
	{
		return array(
			"type" => self::WHERE,
			"datatype" => self::TEXT,
			"cond" => " LIKE ?",
			"value" => self::like($value)."%",
		);
	}

	/**
	 * @static
	 * @param string $value
	 * @return array
	 */
	public static function endsWith($value)
	{
		return array(
			"type" => self::WHERE,
			"datatype" => self::TEXT,
			"cond" => " LIKE ?",
			"value" => "%".self::like($value),
		);
	}

	/**
	 * @static
	 * @param string $value
	 * @return array
	 */
	public static function higher($value)
	{
		return array(
			"type" => self::WHERE,
			"datatype" => self::NUMERIC,
			"cond" => " > ?",
			"value" => $value,
		);
	}

	/**
	 * @static
	 * @param string $value
	 * @return array
	 */
	public static function higherEqual($value)
	{
		return array(
			"type" => self::WHERE,
			"datatype" => self::NUMERIC,
			"cond" => " >= ?",
			"value" => $value,
		);
	}

	/**
	 * @static
	 * @param string $value
	 * @return array
	 */
	public static function lower($value)
	{
		return array(
			"type" => self::WHERE,
			"datatype" => self::NUMERIC,
			"cond" => " < ?",
			"value" => $value,
		);
	}

	/**
	 * @static
	 * @param string $value
	 * @return array
	 */
	public static function lowerEqual($value)
	{
		return array(
			"type" => self::WHERE,
			"datatype" => self::NUMERIC,
			"cond" => " <= ?",
			"value" => $value,
		);
	}

	/**
	 * @static
	 * @param string $value
	 * @return array
	 */
	public static function different($value)
	{
		return array(
			"type" => self::WHERE,
			"datatype" => self::NUMERIC,
			"cond" => " <> ?",
			"value" => $value,
		);
	}


	/**
	 * @static
	 * @param string $value
	 * @return array
	 */
	public static function dateEqual($value)
	{
		return array(
			"type" => self::WHERE,
			"datatype" => self::DATE,
			"cond" => " = ",
			"value" => $value,
			"columnFunction" => "DATE",
			"valueFunction" => "DATE"
		);
	}

	/**
	 * @static
	 * @param string $value
	 * @return array
	 */
	public static function dateHigher($value)
	{
		return array(
			"type" => self::WHERE,
			"datatype" => self::DATE,
			"cond" => " > ",
			"value" => $value,
			"columnFunction" => "DATE",
			"valueFunction" => "DATE"
		);
	}

	/**
	 * @static
	 * @param string $value
	 * @return array
	 */
	public static function dateHigherEqual($value)
	{
		return array(
			"type" => self::WHERE,
			"datatype" => self::DATE,
			"cond" => " >= ",
			"value" => $value,
			"columnFunction" => "DATE",
			"valueFunction" => "DATE"
		);
	}


	/**
	 * @static
	 * @param string $value
	 * @return array
	 */
	public static function dateLower($value)
	{
		return array(
			"type" => self::WHERE,
			"datatype" => self::DATE,
			"cond" => " < ",
			"value" => $value,
			"columnFunction" => "DATE",
			"valueFunction" => "DATE"
		);
	}

	/**
	 * @static
	 * @param string $value
	 * @return array
	 */
	public static function dateLowerEqual($value)
	{
		return array(
			"type" => self::WHERE,
			"datatype" => self::DATE,
			"cond" => " <= ",
			"value" => $value,
			"columnFunction" => "DATE",
			"valueFunction" => "DATE"
		);
	}

	/**
	 * @static
	 * @param string $value
	 * @return array
	 */
	public static function dateDifferent($value)
	{
		return array(
			"type" => self::WHERE,
			"datatype" => self::DATE,
			"cond" => " <> ",
			"value" => $value,
			"columnFunction" => "DATE",
			"valueFunction" => "DATE"
		);
	}
	
	public static function dbdateConvert($value)
	{
		if (strlen($value) > 0)
		{
			$datetime = explode(' ', $value);
			$date = explode('.', $datetime[0]);
					
			// Database datetime format: Y-m-d H:i:s
			return @$date[2].'-'.@$date[1].'-'.@$date[0];// '.@$datetime[1];
		}
	}
	
	
	/**
	 * @static
	 * @param string $value
	 * @return array
	 */
	public static function datetimeEqual($value)
	{
		return array(
			"type" => self::WHERE,
			"datatype" => self::DATETIME,
			"cond" => " = ",
			"value" => $value,
			"columnFunction" => "",
			"valueFunction" => ""
		);
	}

	/**
	 * @static
	 * @param string $value
	 * @return array
	 */
	public static function datetimeHigher($value)
	{
		return array(
			"type" => self::WHERE,
			"datatype" => self::DATETIME,
			"cond" => " > ",
			"value" => $value,
			"columnFunction" => "",
			"valueFunction" => ""
		);
	}

	/**
	 * @static
	 * @param string $value
	 * @return array
	 */
	public static function datetimeHigherEqual($value)
	{
		return array(
			"type" => self::WHERE,
			"datatype" => self::DATETIME,
			"cond" => " >= ",
			"value" => $value,
			"columnFunction" => "",
			"valueFunction" => ""
		);
	}


	/**
	 * @static
	 * @param string $value
	 * @return array
	 */
	public static function datetimeLower($value)
	{
		return array(
			"type" => self::WHERE,
			"datatype" => self::DATETIME,
			"cond" => " < ",
			"value" => $value,
			"columnFunction" => "",
			"valueFunction" => ""
		);
	}

	/**
	 * @static
	 * @param string $value
	 * @return array
	 */
	public static function datetimeLowerEqual($value)
	{
		return array(
			"type" => self::WHERE,
			"datatype" => self::DATETIME,
			"cond" => " <= ",
			"value" => $value,
			"columnFunction" => "",
			"valueFunction" => ""
		);
	}

	/**
	 * @static
	 * @param string $value
	 * @return array
	 */
	public static function datetimeDifferent($value)
	{
		return array(
			"type" => self::WHERE,
			"datatype" => self::DATETIME,
			"cond" => " <> ",
			"value" => $value,
			"columnFunction" => "",
			"valueFunction" => ""
		);
	}
	
	public static function dbdatetimeConvert($value)
	{
		if (strlen($value) > 0)
		{
			$datetime = explode(' ', $value);
			$date = explode('.', $datetime[0]);
					
			// Database datetime format: Y-m-d H:i:s
			return @$date[2].'-'.@$date[1].'-'.@$date[0].' '.@$datetime[1];
		}
	}
}
