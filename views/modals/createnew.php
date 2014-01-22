<div class="modal fade" id="createNewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h4 class="modal-title">Create New Bookmark</h4></div><form class="form-horizontal" role="form" id="newBookmark" action="/bookmarks/create" method="post"><div class="modal-body"><div id="newBootmarkError" class="text-danger"></div><div class="form-group"><label for="title" class="col-sm-2 control-label">Title</label><div class="col-sm-10"><input type="text" class="form-control" id="newBookmarkTitle" name="newBookmarkTitle" maxlength="100" placeholder="The title for the URL" ></div></div><div class="form-group"><label for="url" class="col-sm-2 control-label">URL</label><div class="col-sm-10"><input type="text" class="form-control" id="newBookmarkUrl" name="newBookmarkUrl" maxlength="2048" placeholder="The full URL (http://...)" ></div></div></div><div class="modal-footer"><button type="submit" id="newBootmarkButton" class="btn btn-primary">Create New</button></div></form></div></div></div>