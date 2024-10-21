<div class="modal fade" id="modal-addtopic">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-plus"></i> Add Topic
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form class="form-horizontal" action="{{ route('storeTopics') }}" method="post" enctype="multipart/form-data" id="adtopic">  
                @csrf

                <div class="modal-body">
                    <div class="form-group">
                        <div class="form-row">
                            <input type="hidden" name="schlyear" value="{{ request('schlyear') }}">
                            <input type="hidden" name="semester" value="{{ request('semester') }}">
                            <input type="hidden" name="subjectID" value="{{ request('id') }}">
                            @auth('faculty')
                                @if(Auth::guard('faculty')->user()->role == '943') 
                                    <input type="hidden" name="instructorID" value="{{ Auth::guard('faculty')->user()->id }}">
                                    <input type="hidden" name="sub_name" value="{{  $sub->sub_name }} {{ $sub->subSec }}">
                                @endif
                            @endauth
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-12">
                                <label>Title/Topic:</label>
                                <input type="text" name="topicname" class="form-control form-control-sm">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-12">
                                <label>Description:</label>
                                <textarea class="form-control" name="desctopicname" rows="3" id="topicTextarea" autofocus></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-12">
                                <label>Upload File Attachment:</label>
                                <input type="file" name="filedocs[]" class="form-control" multiple id="fileUpload">
                            </div>
                        </div>
                    </div>
                    <p class="help-block">Max. 25MB</p>

                    <ul class="mailbox-attachments d-flex align-items-stretch clearfix" id="filePreviewContainer"></ul>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="addButton">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>