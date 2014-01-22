<?php

class Bookmarks extends Controller {

    public function __construct() {
        parent::__construct();
    }


    /**
     * The main page of the application. It shows all the active bookmarks in the database
     */
    public function index() {
        $data['title'] = "Bookmark Manager - All";
        $data['bookmarks'] = $this->model->activeBookmarks();

        $this->view->render('bookmarks/index', $data);
    }


    /**
     * Shows all the innactive bookmarks in the database
     */
    public function trash() {
        $data['title'] = "Bookmark Manager - Trash";
        $data['bookmarks'] = $this->model->innactiveBookmarks();

        $this->view->render('bookmarks/trash', $data);
    }


    /**
     * Displays all the information of a particular bookmark
     * @param integer $bookmarkId the id of a bookmark
     */
    public function detail($bookmarkId = false) {
        if($this->_isValidId($bookmarkId)){
            $data['title'] = "Bookmark Manager - Detail";
            $data['info'] = $this->model->bookmarkDetail($bookmarkId);
            
            if(count($data['info']) > 0){
                $this->view->render('bookmarks/detail', $data);
            }else{
                $this->view->render('error/404');
            }
        }else{
            $this->view->render('error/404');
        }
    }


    /**
     * Displays a form to update an specific bookmark
     * @param integer $bookmarkId the id of a bookmark
     */
    public function update($bookmarkId) {
        if($this->_isValidId($bookmarkId)){
            $data['js_file'] = array("updateBookmark.min.js");
            $data['info'] = $this->model->bookmarkDetail($bookmarkId);

            if(count($data['info']) > 0){
                $this->view->render('bookmarks/update', $data);
            }else{
                $this->view->render('error/404');
            }
        }else{
            $this->view->render('error/404');
        }


    }


    /**
     * Creates a new bookmark in the database
     */
    public function create() {
        if($this->model->createBookmark($_POST['newBookmarkTitle'],
                                        $_POST['newBookmarkUrl'])){
            Flash::add('success', 'The Bookmark was created!');
        }else{
            Flash::add('danger', 'The Bookmark was not created! Please try again.');
        }
        Flash::add('success', 'The Bookmark was created!');
        Core::redirect('bookmarks');
    }


    /**
     * Saves the changes of an specific bookmark in the database
     * @param integer $bookmarkId the id of a bookmark
     */
    public function save($bookmarkId) {
        if($this->model->updateBookmark($bookmarkId,
                                        $_POST['updateBookmarkTitle'],
                                        $_POST['updateBookmarkUrl'])){
            Flash::add('success', 'The Bookmark was updated!');
        }else{
            Flash::add('danger', 'The Bookmark was not updated! Please try again.');
        }
        Core::redirect('bookmarks/detail/'.$bookmarkId);
    }


    /**
     * Changes an specific bookmark to innactive in the database
     * @param integer $bookmarkId the id of a bookmark
     */
    public function deactivate($bookmarkId) {
        if($this->_isValidId($bookmarkId)){
            if($this->model->deactivateBookmark($bookmarkId)){
                Flash::add('success', 'The Bookmark was moved to the trash!');
            }else{
                Flash::add('danger', 'The Bookmark was not moved to the trash! Please try again.');
            }
            Core::refreshLast();
        }else{
            $this->view->render('error/404');
        }
    }


    /**
     * Changes an specific bookmark to active in the database
     * @param integer $bookmarkId the id of a bookmark
     */
    public function activate($bookmarkId) {
        if($this->_isValidId($bookmarkId)){
            if($this->model->activateBookmark($bookmarkId)){
                Flash::add('success', 'The Bookmark was activated!');
            }else{
                Flash::add('danger', 'The Bookmark was not activated! Please try again.');
            }
            Core::refreshLast();
        }else{
            $this->view->render('error/404');
        }
    }


    /**
     * Deletes a specific bookmark in the database
     * @param integer $bookmarkId the id of a bookmark
     */
    public function delete($bookmarkId) {
        if($this->_isValidId($bookmarkId)){
            if($this->model->deleteBookmark($bookmarkId)){
                Flash::add('success', 'The Bookmark was deleted!');
            }else{
                Flash::add('danger', 'The Bookmark was not deleted! Please try again.');
            }
            Core::redirect('bookmarks/');
        }else{
            $this->view->render('error/404');
        }
    }


    /**
     * Checks if the id is set
     * @param integer $id the id of a bookmark
     * @return boolean if the id is valid or not
     */
    private function _isValidId($id){
        if(isset($id)){
            return true;
        }
        return false;
    }

}