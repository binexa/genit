<?php

/**
 * Genit Openbiz Cubi Generator
 *
 * LICENSE
 *
 * This source file is subject to the BSD license that is bundled
 * with this package in the file LICENSE.txt.
 *
 * @package   cubi.bin.genit
 * @copyright Copyright (c) 2012, Agus Suhartono
 * @license   http://www.opensource.org/licensess/bsd-license.php
 * @link      http://code.google.com/p/genit/
 * @version   $Id$
 */

/**
 * Description of GenitHelper
 *
 * @author k6
 */
class GenitHelper
{
   
    //put your code here
    static public function capitalize($string)
    {
        $strArray = explode(" ", $string);
        foreach ($strArray as $key => $value) {
            $strArray[$key] = ucfirst($value);
        }
        $upstring = implode(' ', $strArray);
        return $upstring;
    }

    /**
     * Trim empty line of text content
     *
     * @param string $content
     * @return string
     */
    static public function trimEmptyLines($content)
    {
        $lines = explode("\n", $content);
        $ret = "";
        foreach ($lines as $line) {
            if (trim($line) == "")
                continue;
            $ret .= $line . nl;
        }
        return $ret;
    }
   
    /**
     * Copy template file to target
     * 
     * @param string $destinationTemplateName template name for target
     * @param string $sourceTemplateFile template file name
     * @param string $packageName module name
     * @param type $onModule
     * @return bool Returns true on success or false on failure.
     */
    static public function copyTemplateFile($destinationTemplateName, $sourceTemplateFile, $packageName, $onModule = TRUE)
    {
        if ($onModule) {
            $destinationPath = MODULE_PATH . DIRECTORY_SEPARATOR . self::getModuleName($packageName) . DIRECTORY_SEPARATOR . "template";
        } else {
            $destinationPath = self::packageToPath($packageName) . DIRECTORY_SEPARATOR . "template";
        }
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }
        $destinationTemplateFile = $destinationPath . DIRECTORY_SEPARATOR . $destinationTemplateName;
        if (file_exists($destinationTemplateFile))
            return;
        return copy($sourceTemplateFile, $destinationTemplateFile);
    }

    /**
     * Get data option
     *
     * @param string $datatype
     * @param string $db_driver
     * @return string
     */
    static public function getDataOptions($datatype, $db_driver)
    {
        switch (strtoupper($db_driver)) {
            case 'PDO_MYSQL':

                switch ($datatype) {
                    /*
                     * case "date":
                      $options= "Date";
                      break;
                     */

                    default:
                        if (preg_match("/enum\((.*?)\)/si", $datatype, $match)) {
                            preg_match_all("/'(.*?)'[,]?/", $match[1], $options);
                            $options = $options[1];
                        }
                        break;
                }

                break;
        }
        if (is_array($options)) {
            $options = implode("|", $options);
        }
        return $options;
    }

    /**
     * Get data element from database data type
     * 
     * @param string $datatype data type
     * @param string $db_driver database driver
     * @return string
     */
    static public function getDataElement($datatype, $db_driver)
    {
        switch (strtoupper($db_driver)) {
            case 'PDO_MYSQL':

                switch (strtolower($datatype)) {
                    case "date":
                        $element = "InputDate";
                        break;

                    case "datetime":
                        $element = "InputDatetime";
                        break;

                    case "int":
                    case "float":
                    case "bigint":
                        $element = "InputText";
                        break;

                    case "tinyint":
                        $element = "Checkbox";
                        break;

                    case "text":
                    case "shorttext":
                    case "longtext":
                        //$element = "RichText";
                        $element = "Textarea";
                        break;

                    default:
                        if (preg_match("/enum\(.*/si", $datatype, $match)) {
                            $element = "Radio";
                        } else {
                            $element = "InputText";
                        }
                        break;
                }
                break;
        }
        return $element;
    }

    /**
     * Convert data type from database table to OpenBiz
     *
     * @param string $datatype
     * @param string $db_driver database driver
     * @return string Return OpenBiz data type
     */
    static public function convertDataType($datatype, $db_driver)
    {
        switch (strtoupper($db_driver)) {
            case 'PDO_MYSQL':

                switch ($datatype) {
                    case "date":
                        $type = "Date";
                        break;

                    case "timestamp":
                    case "datetime":
                        $type = "Datetime";
                        break;

                    case "int":
                    case "float":
                    case "bigint":
                    case "tinyint":
                    case "double":    
                    case "real":        
                    case "decimal":    
                        $type = "Number";
                        break;

                    case "text":
                    case "shorttext":
                    case "longtext":
                    default:
                        $type = "Text";
                        break;
                }

                break;
        }
        return $type;
    }

    /**
     * Get component name from table name
     *  if table name = table_name
     *  component name = TableNama
     *
     * @param string $table_name table name
     * @param int $prefix
     * @return string Return component name
     */
    static public function getCompName($table_name, $prefix = 0)
    {
        $names = explode("_", $table_name);
        $compName = "";
        for ($i = $prefix; $i < count($names); $i++) {
            $compName .= ucwords(strtolower($names[$i]));
        }
        return $compName;
    }

    static public function getCompDisplayName($table_name, $prefix = 0)
    {
        $names = explode("_", $table_name);
        $compName = "";
        for ($i = $prefix; $i < count($names); $i++) {
            $compName .= ucwords(strtolower($names[$i])) . " ";
        }
        $compName = substr($compName, 0, strlen($compName) - 1);
        return $compName;
    }

    static public function getCompModuleName($table_name, $prefix = 0)
    {
        $names = explode("_", $table_name);
        $compName = strtolower($names[0]);
        return $compName;
    }

    /**
     * Get event name from tabel name
     * event-name = TABLE-NAME
     *
     * @param string $tableName
     * @return string
     */
    static public function getEventName($tableName)
    {
        $tableName = strtoupper($tableName);
        return $tableName;
    }

    /**
     * Get module name from full meta component/object name
     *
     * @param string $component full component/object name like modname.xxx.yyy.ObjectName
     * @return string Return module name
     */
    static public function getModuleName($component)
    {
        $names = explode(".", $component);
        return $names[0];
    }

    static public function getSubModuleName($component)
    {
        $names = explode(".", $component);
        return $names[count($names) - 1];
    }

    public function generateNamingList($table_name, $package_name)
    {
// help user to set the metadata namings
        $temp = explode("_", $table_name);

        // modules/module-name/path/path
        $package_directory = MODULE_PATH . DIRECTORY_SEPARATOR . str_replace(".", DIRECTORY_SEPARATOR, $package_name);

        for ($i = 0; $i < count($temp); $i++) {
            $namings[$i] = array(
                $package_directory,
                GenitHelper::getCompName($table_name, $i),
                GenitHelper::getCompDisplayName($table_name, $i),
                $package_name);
        }
        return $namings;
    }

    public function printDataNaming($namings)
    {
        echo "---------------------------------------" . PHP_EOL;
        echo "Please select metadata naming:" . PHP_EOL;
        for ($i = 0; $i < count($namings); $i++) {
            echo ($i + 1) . ". module path: " . str_replace(MODULE_PATH, "", $namings[$i][0]) .
            ", object name: " . $namings[$i][1] .
            ", module name: " . $namings[$i][3] .
            PHP_EOL;
            $ques[] = $i + 1;
        }
        // echo "S. specify a custom module path, object name and module name" . PHP_EOL;
        echo "Please select: [" . implode("/", $ques) . "] (1) : ";
        return $ques;
    }

    /**
     * readNamingOption()
     * 
     * $opt[0] : package/module path (module/path/path<br />
     * $opt[1] : base Object name<br />
     * $opt[2] : module name / base Object description<br />
     * $opt[3] : package/module name (module-name.path.path)<br />
     * 
     * 
     * @param type $namings
     * @return array
     */
    static public function readNamingOption($namings)
    {

        for ($i = 0; $i < count($namings); $i++) {
            $ques[] = $i + 1;
        }

        $n = 0;
        while (1) {
            $selection = trim(fgets(STDIN));
            $answer = intval($selection) - 1;

            // read custom 
            if (strtolower($selection) == 's') {
                echo "Please set a module path: "; // package/module path
                $package_name = trim(fgets(STDIN));
                $customOptions[0] = MODULE_PATH . DIRECTORY_SEPARATOR . trim($package_name);

                echo "Please set the component name: "; // base Object name
                $customOptions[1] = trim(fgets(STDIN));

                echo "Please set the component display name: ";
                $customOptions[2] = trim(fgets(STDIN));

                echo "Please set the module name: ";
                $customOptions[3] = trim(fgets(STDIN));
                $package_name = $customOptions[3];

                if ($customOptions[0] && $customOptions[1]) {
                    break;
                }
            } else {
                $answer = $answer > -1 ? $answer : 0;
                if (!isset($namings[$answer]) && $n++ < 3)
                    echo "Please select again: [" . implode("/", $ques) . "/s] : ";
                else
                    break;
            }
        }


        if ($n > 3)
            exit;
        if (is_array($customOptions)) {
            $options = $customOptions;
        } else {
            $options = $namings[$answer];
        }
        return $options;
    }

    /**
     * readSelectedAccessControl()
     * <br />
     * 1. Access and Manage (default)" <br />
     * 2. Access, Create, Update and Delete" <br />
     * 3. No access control" <br />
     * 
     * @return number
     */
    static public function readSelectedAccessControl()
    {
        echo PHP_EOL . "Access control options: " . PHP_EOL;
        echo "1. Access and Manage (default)" . PHP_EOL;
        echo "2. Access, Create, Update and Delete" . PHP_EOL;
        echo "3. No access control" . PHP_EOL;
        echo "Please select access control type [1/2/3] (1) : ";
        $acl = trim(fgets(STDIN));
        $acl = $acl ? $acl : "1";
        return $acl;
    }

    static public function packageToPath($packageName)
    {
        return MODULE_PATH . DIRECTORY_SEPARATOR . str_replace(".", DIRECTORY_SEPARATOR, $packageName);
    }
    
    /**
     * Create target directory if not exists
     * @param string $targetPath
     */
    static public function createDirectory($targetPath, $isShowMassage=FALSE)
    {
        if (!file_exists($targetPath)) {
            if ($isShowMassage===TRUE) {
                GenitCli::showMessage("Create directory $targetPath");
            }
            mkdir($targetPath, 0777, true);
        }
    }
    
    
    static public function generatorNameToClassSufix($generatorName)
    {
        $names = explode("_", $generatorName);
        $classSufix = "";
        foreach ($names as $key => $value) {
            $name = ucfirst(strtolower($value));
            $classSufix .= $name;
        }        
        return $classSufix;
        
    }
}
