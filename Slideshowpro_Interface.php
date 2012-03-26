<?php
/**
 * Provides a few methods to interact with a slideshowpro database.
 * @link{http://php.net/manual/en/book.pdo.php} Uses the PDO library
 * 
 * @Author Russell Stringer <r.stringer@gmail.com>
 * @license http://dbad-license.org/license DBAD license
 * @uses add the database connection values to $_connectString, $_user and $_pass
 * @todo create either a constructor or setter methods to initialize db connection info
 */
class Slideshowpro_Interface
{

    /**
     * The connection string for the slideshowpro database
     * @var string
     */
    private $_connectString;

    /**
     * Username for the database connection
     * @var string
     */
    private $_user;

    /**
     * Password for the database conenction
     * @var string
     */
    private $_pass;

    /**
     * The PDO database connection
     * @var PDO
     */
    private $_db;

    /**
     * Gets the list of all albums marked 'active' in Director.
     *
     * @return array All the active albums, with information on the album's preview image
     */
    public function getActiveAlbums()
    {
        $db = $this->_getConn();
        $query = "FROM ssp_albums AS a LEFT JOIN ssp_images AS i
ON i.aid = a.id
WHERE a.active = 1
AND (IF(a.preview_id != 0, a.preview_id = i.id, i.seq = 1))";

        $count = $this->_getResultCount($query);

        if ($count > 0){
            $res = $db->query("SELECT a.id AS albumid, a.name, a.description, a.preview_id, i.id AS imageid, i.src " . $query);
            return $this->_returnFull($res, $count);
        }
        return array();
    }

    /**
     * Gets the list of image ids from a specific album
     *
     * @param string $albumID the id of the album
     * @return array image ids for the album
     */
    public function getImageList($albumID)
    {
        $db = $this->_getConn();

        $aid = explode('-', $albumID);
        $aid = $aid[1];

        $res = $db->query("SELECT CONCAT('content-', id) AS iid FROM ssp_images WHERE aid = {$aid} ORDER BY id ASC");
        
        return $this->_returnColumn($res);
    }

    /**
     * Helper method to get the number of rows to expect from a select query
     *
     * @param string $query The SQL query to execute, minus the SELECT portion
     * @return int The number of rows to expect when executing $query normally
     */
    private function _getResultCount($query)
    {
        $db = $this->_getConn();
        $query = "SELECT COUNT(*) " . $query;
        $res = $db->query($query);
        return $res->fetchColumn();
    }

    /**
     * Returns a single column of a result set
     * 
     * @param PDOStatement $res
     * @return array
     */
    private function _returnColumn($res)
    {
        $res->setFetchMode(PDO::FETCH_NUM);
        
        $column = array();
        for ($i = $res->rowCount(); $i > 0; $i--){
            $column[] = $res->fetchColumn();
        }
        return $column; 
    }

    /**
     * Returns all rows from a result set
     *
     * @param PDOStatement $res
     * @return array
     */
    private function _returnFull($res)
    {
        $res->setFetchMode(PDO::FETCH_ASSOC);
        return $res->fetchAll();
    }

    /**
     * Sets up the database connection based on the connection strings
     *
     * @return PDO
     */
    private function _getConn()
    {
        if (empty($this->_db)){
            $this->_db = new PDO($this->_connectString, $this->_user, $this->_pass);
        }
        return $this->_db;
    }
}