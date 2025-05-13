<fieldset class="col-md-4">
    <div class="form-group">
        <label>Title</label>
        <input type="text" name="title" value="{{ $library->title }}" class="form-control" placeholder="Title / Name"
               required>
        <input type="hidden" name="id" value="{{ $library->id }}">
        <input type="hidden" name="type" value="{{ $type }}">
    </div>

    <div class="form-group">
        <div class="row">
            <div class="col-md-6">
                <label>Author Mark</label>
                <input type="text" name="authormark" value="{{ $library->authormark }}" class="form-control"
                       placeholder="Authormark" required>
            </div>
            <div class="col-md-6">
                <label>Author Status</label>
                <select name="author_type" class="selectpicker form-control" id="selectbasic" required>
                    <option value="">Select Author Status</option>
                    <option value="author" {{ $library->author_status == 'author' ? 'selected' : '' }}>Author</option>
                    <option
                        value="Corporate Author" {{ $library->author_status == 'Corporate Author' ? 'selected' : '' }}>
                        Corporate Author
                    </option>
                    <option value="Editor" {{ $library->author_status == 'Editor' ? 'selected' : '' }}>Editor</option>
                    <option value="Others" {{ $library->author_status == 'Others' ? 'selected' : '' }}>Others</option>
                </select>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="row mt-3">
            <div class="col-md-6">
                <label>Call No.</label>
                <input type="text" name="call_number" value="{{ $library->call_number }}" class="form-control"
                       placeholder="CallNO" required>
            </div>
            <div class="col-md-6">
                <label>ACCNO</label>
                <input type="text" name="acc_number" value="{{ $library->acc_number }}" class="form-control"
                       placeholder="ACCNO" required>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="row mb-3">
            <div class="col-md-6">
                <label>Accession</label>
                <input type="date" name="accession" value="{{ $library->accession }}" class="form-control datepicker"
                       placeholder="DD-MM-YYYY">
            </div>
            <div class="col-md-6">
                <label>Year of Publication</label>
                <input type="text" name="publication_year" value="{{ $library->publication_year }}"
                       class="form-control">
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="row">
            <div class="col-md-6">
                <label>Copy Number</label>
                <input class="form-control" name="copy_number" type="number" placeholder="0"
                       value="{{ $library->copy_number }}" disabled>
            </div>
            <div class="col-md-6">
                <label>ISSN</label>
                <input type="text" name="isbn" class="form-control" value="{{ $library->isbn }}" required>
            </div>
        </div>
    </div>

    <div class="form-group mt-3">
        <label>Price</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <select name="currency" class="form-control" required>
                    <option value="">Select Currency</option>
                    <option value="tk" {{ $library->currency == 'tk' ? 'selected' : '' }}>Taka</option>
                    <option value="usd" {{ $library->currency == 'usd' ? 'selected' : '' }}>USD</option>
                    <option value="euro" {{ $library->currency == 'euro' ? 'selected' : '' }}>Euro</option>
                    <option value="pound" {{ $library->currency == 'pound' ? 'selected' : '' }}>Pound</option>
                    <option value="rs" {{ $library->currency == 'rs' ? 'selected' : '' }}>Rupee</option>
                </select>
            </div>
            <input type="text" name="price" class="form-control" placeholder="Price" value="{{ $library->price }}">
        </div>
    </div>
</fieldset>


<fieldset class="col-md-4">
    <div class="form-group">
        <label>Place</label>
        <input type="text" name="place" value="{{ $library->place }}" class="form-control">
    </div>
    <div class="form-group">
        <label>Publisher</label>
        <input class="form-control" name="publisher" type="text" value="{{ $library->publisher }}"
               placeholder="Publisher">
    </div>
    <div class="form-group">
        <div class="row mb-3">
            <div class="col-md-7">
                <label>Volume</label>
                <input class="form-control" name="volume" type="text" value="{{ $library->volume_number }}"
                       placeholder="Volume">
            </div>
            <div class="col-md-5">
                <label>Series</label>
                <input type="text" name="series" placeholder="Series" value="{{ $library->series }}"
                       class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label>Pagination (PAGI)</label>
            <input class="form-control" type="text" name="pagination" value="{{ $library->pagination }}"
                   placeholder="Pagination">
        </div>
        <div class="form-group">
            <label>Bill & Voucher</label>
            <input class="form-control" name="bill_and_voucher" type="text" value="{{ $library->bill_and_voucher }}"
                   placeholder="Bill & Voucher">
        </div>
        <!-- <div class="form-group">
                            <label>Tags / Subject / Category</label>
                            {{-- {{ Form::select('subject', array(''), null, ['class' => 'js-example-placeholder-multiple js-states form-control', 'multiple' => 'multiple']) }} --}}
        <select name="subjects[]" class="js-example-placeholder-multiple form-control js-states form-control" multiple="multiple">

                              @if( $library->tags )
            @foreach( $library->tags as $key => $tag )
                <option selected="selected">{{ $tag->categories }}</option>

            @endforeach
        @endif
        </select>
      </div> -->
</fieldset>
<fieldset class="col-md-4">
    <div class="row">
        <div class="col-md-7">
            <div class="form-group">
                <label>Bibliography</label>
                <textarea class="form-control" id="textarea" name="bibliography"
                          placeholder="Bibliography">{{ $library->bibliography }}</textarea>
            </div>
            <div class="form-group">
                <label>Book Index</label>
                <textarea class="form-control" name="book_index" type="text"
                          placeholder="Book Index">{{ $library->book_indexs }}</textarea>
            </div>
            <div class="form-group">
                <label>Remarks</label>
                <textarea class="form-control" name="remarks" placeholder="Remarks">{{ $library->remarks }}</textarea>
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group uploadPrent">
                <label for="Upload File">Cover Photo</label>
                <div class="input-group">
                    <!-- <input type="file" id="files-input-upload" name="userfile" class="form-control" style="display: none"> -->
                    <input type="text" name="cover_photo" placeholder="File not selected" class="form-control"
                           value="{{ $library->cover_photo }}" readonly="true">
                    <span class="input-group-btn">
                                <button type="button" class="btn btn-primary jQFileUpload" role="cover_photo">
                                  <span class="fa fa-upload"></span>
                                </button>
                              </span>
                </div>
                <div class="imgPreview" style="height:160px;border: 1px solid #ddd;">
                    <span>Please upload (400X400 / 600X600) Squire photo</span>
                    @php
                        $coverPhoto = ( $library->cover_photo ) ? asset( $library->cover_photo ) : asset('default/cover/' . strtolower( $library->type ) . '.jpg');
                    @endphp
                    <img src="{{ $coverPhoto }}" alt="Cover Photo">
                </div>
            </div>
            <div class="form-group uploadPrent">
                <label for="Upload File">e-Book (PDF/Doc)</label>
                <div class="input-group">
                    <!-- <input type="file" id="files-input-upload" name="userfile" class="form-control" style="display: none"> -->
                    <input type="text" name="file" placeholder="File not selected" class="form-control"
                           value="{{ $library->file }}" readonly="true">
                    <span class="input-group-btn">
                                <button type="button" class="btn btn-primary jQFileUpload" role="file">
                                  <span class="fa fa-upload"></span>
                                </button>
                              </span>
                </div>
                <div class="imgPreview">
                    @if( $library->file )
                        <a href="{{ asset( $library->file ) }}"><i class="fa fa-file"></i> View e-book</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</fieldset>
