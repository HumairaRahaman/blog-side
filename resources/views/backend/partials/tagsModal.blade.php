<!-- Create Tag -->
<div class="modal fade" id="addTagModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="addTag">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">Add Tag</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="Tagyname">Tag Name</label>
                        <input type="text" class="form-control" id="tag_name" name="tag_name" placeholder="Tag name..">
                        <small id="tag_name_help" class="text-danger">
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Create</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{--Edit Tag Modal--}}
<div class="modal fade" id="editTagModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editTag">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">Edit Tag</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="tag_id" id="tag_id">
                    <div class="form-group">
                        <label for="Categoryname">Tag Name</label>
                        <input type="text" class="form-control" id="edit_tag" name="edit_tag" placeholder="Tag name..">
                        <small id="edit_tag_help" class="text-danger">
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Update</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
