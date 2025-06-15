<fieldset class="col-md-4">
    <div class="form-group">
        <label>ACCNO</label>
        <input type="text" name="acc_number" class="form-control" placeholder="ACCNO">
    </div>
    <div class="form-group">
        <label>Document Author</label>
        <input type="text" name="document_author" class="form-control" placeholder="Document Author">
    </div>
    <div class="form-group">
        <label>Title</label>
        <input type="text" class="form-control" name="title" placeholder="Title / Name" required>
    </div>
    <div class="form-group">
        <label>FREQ</label>
        <select name="friq" class="form-control">
            <option value="" disabled selected>FREQ</option>
            <option value="Daily" @if(old('friq') == 'Daily') selected @endif>Daily</option>
            <option value="Weekly" @if(old('friq') == 'Weekly') selected @endif>Weekly</option>
            <option value="Fortnightly" @if(old('friq') == 'Fortnightly') selected @endif>Fortnightly</option>
            <option value="Monthly" @if(old('friq') == 'Monthly') selected @endif>Monthly</option>
            <option value="Bi-Monthly" @if(old('friq') == 'Bi-Monthly') selected @endif>Bi-Monthly</option>
            <option value="Quarterly" @if(old('friq') == 'Quarterly') selected @endif>Quarterly</option>
            <option value="Annual" @if(old('friq') == 'Annual') selected @endif>Annual</option>
            <option value="Bi-Annual" @if(old('friq') == 'Bi-Annual') selected @endif>Bi-Annual</option>
            <option value="Series" @if(old('friq') == 'Series') selected @endif>Series</option>
            <option value="others" @if(old('friq') == 'others') selected @endif>Others</option>
        </select>
    </div>
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
        <label>Season</label>
        <select name="season" class="form-control">
            <option value="" disabled selected>Season</option>
            @foreach($seasons as $k => $v)
            <option value="{{ $k }}" @if(old('season') == $k) selected @endif>{{ $v }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label>Year of Publication</label>
        <input type="text" name="publication_year" class="form-control" placeholder="Publication Year">
    </div>
    <div class="form-group">
        <label>Copy Number</label>
        <input class="form-control" name="copy_number" type="number" placeholder="0" value="1">
    </div>
</fieldset>

<fieldset class="col-md-4">
    <div class="form-group">
        <label>ISBN</label>
        <input type="text" name="isbn" class="form-control" placeholder="ISBN">
    </div>
    <div class="form-group">
        <label>ISSN</label>
        <input type="text" name="issn" class="form-control" placeholder="ISBN">
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
    <div class="form-group">
        <label>Date of Publication</label>
        <input class="form-control datepicker" name="accession" type="text" placeholder="DD-MM-YYYY">
    </div>
    <div class="form-group">
        <label>Remarks</label>
        <textarea class="form-control" name="remarks" placeholder="Remarks" style="height:110px;"></textarea>
    </div>
</fieldset>
<fieldset class="col-md-4">

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
        <div class="imgPreview" style="height:360px;border: 1px solid #ddd;"></div>
    </div>
    <div class="form-group uploadPrent">
        <label for="Upload File">e-Book (PDF/Doc)</label>
        <div class="input-group">
            <!-- <input type="file" id="files-input-upload" name="userfile" class="form-control" style="display: none"> -->
            <input type="text" name="file" placeholder="File not selected" class="form-control" value=""
                   readonly="true">
            <span class="input-group-btn"><button type="button" class="btn btn-primary jQFileUpload" role="file"><span
                        class="fa fa-upload"></span></button></span>
        </div>
        <div class="imgPreview"></div>
    </div>

    <div class="form-group form-check">
        <input type="checkbox" class="form-check-input" id="e_resource_only" name="e_resource_only" value="1">
        <label class="form-check-label" for="e_resource_only">E-Resource only?</label>
    </div>
</fieldset>
