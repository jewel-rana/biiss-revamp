<fieldset class="col-md-4">
    <div class="form-group">
        <label>Title</label>
        <input type="text" class="form-control" name="title" value="{{ $library->title }}" placeholder="Title / Name" required>
    </div>

    <div class="form-group">
        <label>FREQ</label>
        <select name="friq" class="form-control">
            <option value="Daily" {{ $library->friq == 'Daily' ? 'selected' : '' }}>Daily</option>
            <option value="Weekly" {{ $library->friq == 'Weekly' ? 'selected' : '' }}>Weekly</option>
            <option value="Fortnightly" {{ $library->friq == 'Fortnightly' ? 'selected' : '' }}>Fortnightly</option>
            <option value="Monthly" {{ $library->friq == 'Monthly' ? 'selected' : '' }}>Monthly</option>
            <option value="Bi-Monthly" {{ $library->friq == 'Bi-Monthly' ? 'selected' : '' }}>Bi-Monthly</option>
            <option value="Quarterly" {{ $library->friq == 'Quarterly' ? 'selected' : '' }}>Quarterly</option>
            <option value="Annual" {{ $library->friq == 'Annual' ? 'selected' : '' }}>Annual</option>
            <option value="Bi-Annual" {{ $library->friq == 'Bi-Annual' ? 'selected' : '' }}>Bi-Annual</option>
            <option value="Series" {{ $library->friq == 'Series' ? 'selected' : '' }}>Series</option>
            <option value="others" {{ $library->friq == 'others' ? 'selected' : '' }}>Others</option>
        </select>
    </div>

    <div class="form-group">
        <label>Volume</label>
        <input class="form-control" name="volume" type="text" value="{{ $library->volume_number }}" placeholder="Volume">
    </div>

    <div class="form-group">
        <label>Number</label>
        <input type="text" name="item_number" class="form-control" value="{{ $library->item_number }}" placeholder="Number">
    </div>

    <div class="form-group">
        <label>Month</label>
        <input type="text" class="form-control" name="month_of_publish" value="{{ $library->month_of_publish }}" placeholder="Month of Publish">
    </div>

    <div class="form-group">
        <label>Season</label>
        <select name="season" class="form-control">
            <option value="">Season</option>
            @foreach($seasons as $key => $value)
                <option value="{{ $key }}" {{ $library->season == $key ? 'selected' : '' }}>{{ $value }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label>Year of Publication</label>
        <input type="text" name="publication_year" placeholder="Publication Year" value="{{ $library->publication_year }}" class="form-control">
    </div>
</fieldset>


<fieldset class="col-md-4">
    <div class="form-group">
        <label>ISSN</label>
        <input type="text" name="issn" value="{{ $library->issn }}" placeholder="ISSN" class="form-control">
    </div>
    <div class="form-group">
        <label>Publisher</label>
        <input class="form-control" name="publisher" value="{{ $library->publisher }}" type="text"
               placeholder="Publisher">
    </div>
    <div class="form-group">
        <label>Place</label>
        <input type="text" name="place" class="form-control" value="{{ $library->place }}" placeholder="Place">
    </div>
    <div class="form-group">
        <label>Source</label>
        <input class="form-control" name="source" value="{{ $library->source }}" placeholder="Source">
    </div>
    <div class="form-group">
        <label>From</label>
        <input type="text" name="from_where" placeholder="From" value="{{ $library->from_where }}" class="form-control">
    </div>
    <div class="form-group">
        <label>Remarks</label>
        <textarea class="form-control" style="height: 110px;" name="remarks"
                  placeholder="Remarks">{{ $library->remarks }}</textarea>
    </div>
    <!-- <div class="form-group">
          <label>Date of Publication</label>
          <input class="form-control datepicker" name="accession" type="text" placeholder="DD-MM-YYYY">
    </div> -->
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
        <span>Please upload (400X400 / 600X600) Squire photo</span>
    </div>
    <div class="form-group uploadPrent">
        <label for="Upload File">e-Journal (PDF/Doc)</label>
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
