                              
                    <fieldset class="col-md-4">
                      <div class="form-group">
                        <label>Title</label>
                          {{ Form::text('title', $library->title, ['class' => 'form-control', 'placeholder' => 'Title / Name', 'required' => true]) }}
                          {{ Form::hidden('id', $library->id ) }}
                        {{ Form::hidden('type', $type) }}
                      </div>
                      {{-- {{$library->author_status}} --}}
                      <div class="form-group">
                        <div class="row">
                          <div class="col-md-6">
                            <label>Author Mark</label>
                            {{ Form::text('authormark', $library->authormark, ['class' => 'form-control', 'placeholder' => 'Authormark']) }}
                          </div>
                          <div class="col-md-6">
                            <label>Author Status</label>
                            {{ Form::select('author_type', [
                              '' => 'Select Author Status',
                              'author' => 'Author',
                              'Corporate Author' => 'Corporate Author',
                              'Editor' => 'Editor',
                              'Others' => 'Others'
                              ], $library->author_status, ['class' => 'selectpicker form-control', 'id' => 'selectbasic', ]) }}
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="row mt-3">
                          <div class="col-md-6">
                            <label>Call No.</label>
                            {{ Form::text('call_number', $library->call_number, ['class' => 'form-control', 'placeholder' => 'CallNO', ]) }}
                          </div>
                          <div class="col-md-6">
                            <label>ACCNO</label>
                            {{ Form::text('acc_number', $library->acc_number, ['class' => 'form-control', 'placeholder' => 'ACCNO', ]) }}
                          </div>
                        </div>
                      </div>
                      <div class="form-group"> 
                        <div class="row mb-3">
                          <div class="col-md-6">
                            <label>Accession / Date of Publication</label>
                                <input class="form-control " name="accession" value="{{ ( !empty( $library->accession ) && strtotime( $library->accession ) > 0 ) ? $library->accession : '' }}" type="date" placeholder="DD-MM-YYYY">
                          </div>
                          <div class="col-md-6">
                            <label>Year of Publication</label>
                            <input type="text" name="publication_year" value="{{ $library->publication_year }}" class="form-control">
                          </div>
                      </div>
                      <div class="form-group">  
                        <div class="row">
                          <div class="col-md-6">
                            <label>ISBN</label>
                            <input type="text" name="isbn" class="form-control" value="{{ $library->isbn }}" >
                          </div>
                        </div>
                      </div>
                      <div class="form-group mt-3">
                        <label>Price</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            {{ Form::select('currency', [
                              '' => 'Select Currencty',
                              'tk' => 'Taka',
                              'usd' => 'USD',
                              'euro' => 'Euro',
                              'pound' => 'Pound',
                              'rs' => 'Rupee'
                              ], $library->currency, ['class' => 'form-control',]) }}
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
                        <input class="form-control" name="publisher" type="text" value="{{ $library->publisher }}" placeholder="Publisher">
                      </div>
                      <div class="form-group"> 
                        <div class="row mb-3">
                          <div class="col-md-7">
                            <label>Volume</label>
                            <input class="form-control" name="volume" type="text" value="{{ $library->volume_number }}" placeholder="Volume">
                          </div>
                          <div class="col-md-5">
                            <label>Series</label>
                            <input type="text" name="series" placeholder="Series" value="{{ $library->series }}" class="form-control">
                          </div>
                      </div>
                      <div class="form-group">
                        <label>Pagination (PAGI)</label>
                        <input class="form-control" type="text" name="pagination" value="{{ $library->pagination }}" placeholder="Pagination">
                      </div>
                      <div class="form-group">
                        <label>Bill & Voucher</label>
                        <input class="form-control" name="bill_and_voucher" type="text" value="{{ $library->bill_and_voucher }}" placeholder="Bill & Voucher">
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
                            <textarea class="form-control" id="textarea" name="bibliography" placeholder="Bibliography">{{ $library->bibliography }}</textarea>
                          </div>
                          <div class="form-group">
                            <label>Book Index</label>
                            <textarea class="form-control" name="book_index" type="text" placeholder="Book Index">{{ $library->book_indexs }}</textarea>
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
                              <input type="text" name="cover_photo" placeholder="File not selected" class="form-control" value="{{ $library->cover_photo }}" readonly="true">
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
                              <input type="text" name="file" placeholder="File not selected" class="form-control" value="{{ $library->file }}" readonly="true">
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