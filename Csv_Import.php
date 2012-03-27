<?php
/**
 * Provides a quick way of importing a csv file into a MySQL database
 * @link{http://php.net/manual/en/book.pdo.php} Uses the PDO library
 * 
 * @Author Russell Stringer <r.stringer@gmail.com>
 * @license http://dbad-license.org/license DBAD license
 */
class CSV_Import{
    
    /**
     * The database connection
     * @var PDO
     */
    private $_dbConn;

    /**
     * Name of the table to import into
     * @var String
     */
    private $_table;

    /**
     * Holds the filehandle for the csv
     * @var resource
     */
    private $_csvHandle;

    /**
     * Indexed array of the column names to import into. 
     * @var array
     */
    private $_colMapping;

    /**
     * Set up the file handle and default column mapping
     * 
     * @param string $filePath
     * @param boolean $firstLineHeadings true if the first line of the csv should be used as the column mapping
     * @throws Exception if the file is missing or unreadable
     */
    public function __construct($filePath, $firstLineHeadings = true)
    {
        if (!file_exists($filePath) || !is_readable($filePath)){
            throw Exception("File missing or unreadable");
        }
        $this->_csvHandle = fopen($filePath, 'r');

        if ($firstLineHeadings){
            $headings = $this->_getRow();
            $this->setMapping($headings);
        }
    }

    /**
     * Runs the import of the csv file into the specified table
     * 
     * @param string $tableName
     * @throws Exception if the database connection or file handle are missing
     */
    public function importTo($tableName)
    {
        if (empty($this->_dbConn)){
            throw Exception("No database connection");
        }

        if (empty($this->_csvHandle)){
            throw Exception("No file handle");
        }
        $this->_table = $tableName;
        $this->_dbConn->query("TRUNCATE TABLE $tablName");
        $this->_doImport();
    }

    /**
     * Sets up the dataabase connection
     *
     * @param string $conn PDO connection string
     * @param string $user username to connect with
     * @param string $pass database password
     */
    public function setupDatabase($conn, $user, $pass)
    {
        $this->_dbConn = new PDO($conn, $_user, $pass);
    }

    /**
     * Set up the mapping between the fields in the file and the columns
     * in the database. $mapArray should be an indexed array of the column
     * names, in the order that the data will appear in the import file.
     *
     * @param array $mapArray
     */
    public function setMapping($mapArray)
    {
        $this->_colMapping = $this->_parenthesize($mapArray);
    }

    /**
     * Imports each line of the file to the database
     */
    private function _doImport()
    {
        while (($row = $this->_getRow()) !== FALSE){
            $this->_insertRow($this->_parenthesize($row));
        }
    }

    /**
     * Inserts an individual row into the database
     */
    private function _insertRow($values)
    {
        $this->_dbConn->query("INSERT INTO " . $this->_table . ' ' . $this->_colMapping . ' VALUES ' . $row);
    }

    /**
     * Returns a parenthesized list of the elements of $array
     * @param array $array
     * @return string
     */
    private function _parenthesize($array)
    {
        return '(' . implode(',', $row) . ')';
    }
    
    /**
     * Returns the next row of the import file as an array
     *
     * @return array
     */
    private function _getRow()
    {
        return fgetcsv($this->_csvHandle);
    }
}