<?php

class Bookmarks_Model extends Model {

    private $_salt = "dsaign9rEASF34qwe13lsadfdfomoinfds";


    public function __construct() {
        parent::__construct();
    }


    /**
     * It gets the active bookmarks 
     *
     * @return array of active bookmarks
     */
    public function activeBookmarks() {
        $sql = "SELECT * FROM bookmarks WHERE active = 1 ORDER BY created DESC";
        return $this->db->select($sql);
    }


    /**
     * It gets the innactive bookmarks 
     *
     * @return array of innactive bookmarks
     */
    public function innactiveBookmarks() {
        $sql = "SELECT * FROM bookmarks WHERE active = 0 ORDER BY created DESC";
        return $this->db->select($sql);
    }


    /**
     * It gets the information for a specific bookmark
     *
     * @param integer $bookmarkId the id of the bookmarks
     * @return array with the bookmarks information
     */
    public function bookmarkDetail($bookmarkId){
        $sql = "SELECT * FROM bookmarks WHERE id = :bookmarkId";
        return $this->db->select($sql, array('bookmarkId' => $bookmarkId))[0];
    }


    /**
     * it inserts a new bookmart to the database
     *
     * @param string $title 
     * @param string $url 
     * @return boolean if the insert was a success
     */
    public function createBookmark($title, $url) {
        return $this->db->insert('bookmarks', array('id' => uniqid(),
                                             'title' => $title,
                                             'url' => $url,
                                             'active' => 1,
                                             'created' => date('Y-m-d H:i:s')));
    }


    /**
     * it updates a bookmark in the database
     *
     * @param array $data an array with the information to be updated
     * @return boolean if the update was a success
     */
    public function updateBookmark($bookmarkId, $title, $url) {
        return $this->db->update('bookmarks', array('title' => $title, 'url' => $url), "id = '{$bookmarkId}'");
    }


    /**
     * it updates a bookmark to be active
     *
     * @param integer $bookmarkId the id of the bookmark
     * @return boolean if the update was a success
     */
    public function activateBookmark($bookmarkId) {
        return $this->db->update('bookmarks', array('active' => true), "id = '{$bookmarkId}'");
    }


    /**
     * it updates a bookmark to be innactive
     *
     * @param integer $bookmarkId the id of the bookmark
     * @return boolean if the update was a success
     */
    public function deactivateBookmark($bookmarkId) {
        return $this->db->update('bookmarks', array('active' => false), "id = '{$bookmarkId}'");
    }


    /**
     * it deletes a bookmark from the database
     *
     * @param integer $bookmarkId the id of the bookmark
     */
    public function deleteBookmark($bookmarkId) {
        return $this->db->delete('bookmarks', "id = '{$bookmarkId}'");
    }
}