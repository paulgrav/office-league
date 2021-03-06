<?php
    /**
    * Simple class to sanitize what's being passed in and make sure that we like it.
    * 
    * @author Chris Booker
    */

    class Parameters {

        /**
        * Check a parameter against an allowed list and return a valid value, or a default value, or bool false.
        * 
        * @param mixed $strParamName
        * @param mixed $arrAllowedList
        * @param mixed $strDefault
        */
        protected static function getAllowedParam(array $arrParamSource, $strParamName, array $arrAllowedList, $strDefault=null)
        {        
            if (empty($arrParamSource[$strParamName]) || !in_array($arrParamSource[$strParamName], $arrAllowedList))
            {            
                return ($strDefault === null) ? false : $strDefault;
            }

            return $arrParamSource[$strParamName];        
        }

        /**
        * Build a list of parameters based on what is allowed, and what is given, so we can ensure 
        * that other crap doesn't get through.
        * 
        * @param array $arrRequired - parameters that are required
        * @param array $arrOptional - valid parameters that are optional
        * @param array $arrParamSource - a list that is being checked to get required/optional params from.
        */
        public static function getFullParamList(array $arrRequired, array $arrOptional = null, array $arrParamSource = null)
        {
            if ($arrParamSource == null)
            {
                $arrParamSource = $_GET; //Take params from the URL if not otherwise specified.
            }

            $arrParamList = array();

            foreach ($arrRequired as $strParam) 
            {
                $arrParamList[$strParam] = self::getParam($strParam, $arrParamSource);
            }
            
            if ($arrOptional != null)
            {
                foreach ($arrOptional as $strParam)
                {
                    $arrParamList[$strParam] = self::getParam($strParam, $arrParamSource);
                }
            }
            return $arrParamList;
        }

        /**
        * Get a recognised parameter, sanitize it, and return it.
        * 
        * @param string 
        */
        public static function getParam($strParamName, $arrParamSource) 
        {        

            switch ($strParamName) 
            {
                case 'method':
                    $arrAllowList = array('get','create','update','reset');
                    $strParamValue = self::getAllowedParam($arrParamSource, 'method', $arrAllowList, 'get');
                    break;

                case 'action':
                    $strParamValue = !empty($arrParamSource['action']) ? $arrParamSource['action'] : null;
                    break;

                case 'seasonTypeId':                
                    $strParamValue = !empty($arrParamSource['seasonTypeId']) ? intval($arrParamSource['seasonTypeId']) : null;
                    break;
                    
                case 'competitionId':                
                    $strParamValue = !empty($arrParamSource['competitionId']) ? intval($arrParamSource['competitionId']) : null;
                    break;

                case 'seasonId':
                    $strParamValue = !empty($arrParamSource['seasonId']) ? intval($arrParamSource['seasonId']) : null;
                    break;

                case 'teamId':
                    $strParamValue = !empty($arrParamSource['teamId']) ? intval($arrParamSource['teamId']) : null;
                    break;  

                case 'roundId':
                    $strParamValue = !empty($arrParamSource['roundId']) ? intval($arrParamSource['roundId']) : null;
                    break; 

                case 'fixtureId':
                    $strParamValue = !empty($arrParamSource['fixtureId']) ? intval($arrParamSource['fixtureId']) : null;
                    break;

                case 'homeScore':
                    $strParamValue = isset($arrParamSource['homeScore']) && !is_null($arrParamSource['homeScore']) ? intval($arrParamSource['homeScore']) : null;
                    break;             

                case 'awayScore':
                    $strParamValue = isset($arrParamSource['awayScore']) && !is_null($arrParamSource['awayScore']) ? intval($arrParamSource['awayScore']) : null;
                    break;             

                case 'notKnockedOut':
                    $strParamValue = !empty($arrParamSource['notKnockedOut']) ? 1 : 0;
                    break;         

                case 'played':
                    $strParamValue = !empty($arrParamSource['played']) ? (bool) $arrParamSource['played'] : null;
                    break;                     

                default:
                    return null;
                    break;
            }

            return $strParamValue;
        }

    }
?>
