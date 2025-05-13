                              <fieldset class="col-md-4">
                                  <div class="form-group">
                                      <label>Title</label>
                                      <input type="text" class="form-control" name="title" placeholder="Title / Name"
                                          required>
                                      {{ Form::hidden('type', $type) }}
                                  </div>
                                  <div class="form-group">
                                      <div class="row">
                                          <div class="col-md-6">
                                              <label>Author Mark</label>
                                              <input type="text" class="form-control" name="authormark"
                                                  placeholder="Title / Name" required>
                                          </div>
                                          <div class="col-md-6">
                                              <label>Author Status</label>
                                              <select id="selectbasic" name="author_type" placeholder="Select"
                                                  class="selectpicker form-control">
                                                  <option>Author</option>
                                                  <option>Corporate Author</option>
                                                  <option>Editor</option>
                                                  <option>Others</option>
                                              </select>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <div class="row mt-3">
                                          <div class="col-md-6">
                                              <label>Call No.</label>
                                              <input type="text" name="call_number" class="form-control"
                                                  placeholder="Call no." required>
                                          </div>
                                          <div class="col-md-6">
                                              <label>ACCNO</label>
                                              <input type="text" name="acc_number" class="form-control"
                                                  placeholder="ACCNO" required>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <div class="row mb-3">
                                          <div class="col-md-6">
                                              <label>Accession</label>
                                              <input class="form-control " name="accession" type="date"
                                                  placeholder="DD-MM-YYYY">
                                          </div>
                                          <div class="col-md-6">
                                              <label>Year of Publication</label>
                                              <input type="text" name="publication_year" placeholder="Publication year"
                                                  class="form-control">
                                          </div>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <div class="row">
                                          <div class="col-md-6">
                                              <label>Copy Number</label>
                                              <input class="form-control" name="copy_number" type="number"
                                                  placeholder="0" value="1" min="0">
                                          </div>
                                          <div class="col-md-6">
                                              <label>ISBN</label>
                                              <input type="text" name="isbn" class="form-control" placeholder="ISBN"
                                                  required>
                                          </div>
                                      </div>
                                      <div class="form-group mt-3">
                                          <label>Price</label>
                                          <div class="input-group">
                                              <div class="input-group-prepend">
                                                  <select name="currency" class="form-control"
                                                      placeholder="Select Currency" required>
                                                      <option value="tk">Taka</option>
                                                      <option value="usd">USD</option>
                                                      <option value="euro">Euro</option>
                                                      <option value="pound">Pound</option>
                                                      <option value="rs">Rupee</option>
                                                  </select>
                                              </div>
                                              <input type="text" name="price" class="form-control" placeholder="Price"
                                                  value="">
                                          </div>
                                      </div>
                              </fieldset>

                              <fieldset class="col-md-4">
                                  <div class="form-group">
                                      <label>Place</label>
                                      <input type="text" name="place" class="form-control" placeholder="Place">
                                  </div>
                                  <div class="form-group">
                                      <label>Publisher</label>
                                      <input class="form-control" name="publisher" type="text" placeholder="Publisher">
                                  </div>
                                  <div class="form-group">
                                      <div class="row mb-3">
                                          <div class="col-md-7">
                                              <label>Volume</label>
                                              <input class="form-control" name="volume" type="text"
                                                  placeholder="Volume">
                                          </div>
                                          <div class="col-md-5">
                                              <label>Series</label>
                                              <input type="text" name="series" placeholder="Series"
                                                  class="form-control">
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <label>Pagination (PAGI)</label>
                                          <input class="form-control" type="text" name="pagination"
                                              placeholder="Pagination">
                                      </div>
                                      <div class="form-group">
                                          <label>Bill & Voucher</label>
                                          <input class="form-control" name="bill_and_voucher" type="text"
                                              placeholder="Bill and Voucher">
                                      </div>
                                      <!-- <div class="form-group">
                        <label>Tags / Subject / Category</label>
                        <select name="subjects[]" class="js-example-placeholder-multiple js-states form-control" multiple="multiple"></select>
                      </div> -->
                              </fieldset>
                              <fieldset class="col-md-4">
                                  <div class="row">
                                      <div class="col-md-7">
                                          <div class="form-group">
                                              <label>Bibliography</label>
                                              <textarea class="form-control" id="textarea" name="bibliography"
                                                  placeholder="Bibliography"></textarea>
                                          </div>
                                          <div class="form-group">
                                              <label>Book Index</label>
                                              <textarea class="form-control" name="book_index" type="text"
                                                  placeholder="Book Index"></textarea>
                                          </div>
                                          <div class="form-group">
                                              <label>Remarks</label>
                                              <textarea class="form-control" name="remarks"
                                                  placeholder="Remarks"></textarea>
                                          </div>
                                      </div>
                                      <div class="col-md-5">
                                          <div class="form-group uploadPrent">
                                              <label for="Upload File">Cover Photo</label>
                                              <div class="input-group">
                                                  <!-- <input type="file" id="files-input-upload" name="userfile" class="form-control" style="display: none"> -->
                                                  <input type="text" name="cover_photo" placeholder="File not selected"
                                                      class="form-control" value="" readonly="true">
                                                  <span class="input-group-btn">
                                                      <button type="button" class="btn btn-primary jQFileUpload"
                                                          role="cover_photo">
                                                          <span class="fa fa-upload"></span>
                                                      </button>
                                                  </span>
                                              </div>
                                              <div class="imgPreview" style="height:160px;border: 1px solid #ddd;">
                                              </div>
                                              <span>Please upload (400X400 / 600X600) Squire photo</span>
                                          </div>
                                          <div class="form-group uploadPrent">
                                              <label for="Upload File">e-Book (PDF/Doc)</label>
                                              <div class="input-group">
                                                  <!-- <input type="file" id="files-input-upload" name="userfile" class="form-control" style="display: none"> -->
                                                  <input type="text" name="file" placeholder="File not selected"
                                                      class="form-control" value="" readonly="true">
                                                  <span class="input-group-btn">
                                                      <button type="button" class="btn btn-primary jQFileUpload"
                                                          role="file">
                                                          <span class="fa fa-upload"></span>
                                                      </button>
                                                  </span>
                                              </div>
                                              <div class="imgPreview"></div>
                                          </div>
                                      </div>
                                  </div>
                              </fieldset>
