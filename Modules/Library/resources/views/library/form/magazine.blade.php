<fieldset class="col-md-4">
    <div class="form-group">
        <label>Title</label>
        <input type="text" class="form-control" name="title" placeholder="Title / Name" required>
    </div>
    <div class="form-group">
        <label>FREQ</label>
        <select class="form-control" name="friq" placeholder="Select FREQ" required>
            <option>Daily</option>
            <option>Weekly</option>
            <option>Fortnightly</option>
            <option>Monthly</option>
            <option>Bi-Monthly</option>
            <option>Quarterly</option>
            <option>Annual</option>
            <option>Bi-Annual</option>
            <option>Series</option>
            <option>Others</option>
        </select>
    </div>
    <div class="form-group">
        <label>Date of Publication</label>
        <input class="form-control datepicker" name="accession" type="text" placeholder="DD-MM-YYYY">
    </div>
    <!-- <div class="form-group">
          <label>ACCNO</label>
          <input type="text" name="acc_number" class="form-control" placeholder="ACCNO">
    </div> -->
    <div class="form-group">
        <label>Volume</label>
        <input class="form-control" name="volume" type="text" placeholder="Volume">
    </div>
    <div class="form-group">
        <label>Number</label>
        <input type="text" name="item_number" class="form-control" placeholder="Number">
    </div>
    <div class="form-group">
        <label>Month</label>
        <input class="form-control" name="month_of_publish" type="text" placeholder="Month of Publish">
    </div>
    <div class="form-group">
        <label>Copy Number</label>
        <input class="form-control" name="copy_number" type="number" placeholder="0" value="1">
    </div>
</fieldset>

<fieldset class="col-md-4">

    <div class="form-group">
        <label>Year of Publication</label>
        <input type="text" name="publication_year" class="form-control" placeholder="Publication Year">
    </div>
    <div class="form-group">
        <label>ISSN</label>
        <input type="text" name="issn" class="form-control" placeholder="ISSN">
    </div>
    <div class="form-group">
        <label>Publisher</label>
        <input class="form-control" name="publisher" type="text" placeholder="Publisher">
    </div>
    <div class="form-group">
        <label>Place</label>
        <input type="text" name="place" class="form-control" placeholder="Place">
    </div>
    <div class="form-group">
        <label>Source</label>
        <input type="text" name="source" class="form-control" placeholder="Source" required>
    </div>
    <div class="form-group">
        <label>From</label>
        <input class="form-control" name="from_where" type="text" placeholder="From Where">
    </div>
</fieldset>
<fieldset class="col-md-4">
    <div class="form-group">
        <label>Remarks</label>
        <textarea class="form-control" name="remarks" placeholder="Remarks"></textarea>
    </div>

    <div class="form-group uploadPrent">
        <label for="Upload File">Cover Photo</label>
        <div class="input-group">
            <!-- <input type="file" id="files-input-upload" name="userfile" class="form-control" style="display: none"> -->
            <input type="text" name="cover_photo" placeholder="File not selected" class="form-control" value=""
                   readonly="true">
            <span class="input-group-btn">
                                  <button type="button" class="btn btn-primary jQFileUpload" role="cover_photo">
                                    <span class="fa fa-upload"></span>
                                  </button>
                                </span>
        </div>
        <div class="imgPreview" style="height:160px;border: 1px solid #ddd;"></div>
        <span>Please upload (400X400 / 600X600) Squire photo</span>
    </div>
    <div class="form-group uploadPrent">
        <label for="Upload File">e-Book (PDF/Doc)</label>
        <div class="input-group">
            <!-- <input type="file" id="files-input-upload" name="userfile" class="form-control" style="display: none"> -->
            <input type="text" name="file" placeholder="File not selected" class="form-control" value=""
                   readonly="true">
            <span class="input-group-btn">
                                  <button type="button" class="btn btn-primary jQFileUpload" role="file">
                                    <span class="fa fa-upload"></span>
                                  </button>
                                </span>
        </div>
        <div class="imgPreview"></div>
    </div>
</fieldset>
