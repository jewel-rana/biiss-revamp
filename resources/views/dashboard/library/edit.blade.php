@extends("{$theme['default']}::layouts.master")
@section('owncss')
<link rel="stylesheet" href="{{asset('/css/select2.min.css') }}" />
<link rel="stylesheet" href="{{asset('/date/jquery.datetimepicker.css') }}" />
<style type="text/css">
.h-inline {
  display:inline;
  }
.float-l {
float: left;
  }
.float-r {
float: right;
  }

.btn-square {
padding: 4px 6px !important;
  }
.hr-dark {
border-top: 1px solid #A2A2A2;
border-bottom: 1px solid #C7C7C7;
}
.row-num {
  font-size: 17.5px;
  font-weight: bold;
  line-height: 30px;
}
.label-small, .label-small .controls label {
font-size: 12px;
  }
  .imgPreview img{
    width: 100%;
    max-height: 160px;
    position: relative;
  }
  .imgPreview a {
    margin-top: 45px;
    padding: 25px;
    font-size: 24px;
  }
</style>
@endsection
@section('content')
    <!-- begin row -->
    <div class="row">
      <!-- begin col-12 -->
      <div class="col-md-12">
        <!-- begin result-container -->
        <div class="result-container">
            <form method="POST" action="{{ route('dashboard.library.store') }}" id="libraryAddNewForm">
            {{ csrf_field() }}
            {{ Form::hidden('id', $library->id ) }}
              <div class="row">
                <div class="col-md-12">
                  <h4><i class="icon-truck icon-large"></i> General Information </h4>
                  <hr><hr class="hr-dark">
                  <div class="row">
                    @include('/dashboard/library/form/edit_' . strtolower( $type ) )
                  </div>
                    <h4><i class="icon-truck icon-large"></i> Author</h4>
                    <hr><hr class="hr-dark">
                    <div class="row">
                      <div class="col-md-12" id="buildyourform">
                          @if( $library->authors->count() > 0 )
                          @foreach( $library->authors as $key => $author )
                        <div class="row fieldwrapper" id="field1">
                            <div class="col-md-3 form-group">
                              <input type="text" class="fieldname form-control" name="authorName[]" value="{{ $author->author_name }}" placeholder="name">
                            </div>
                            <div class="col-md-3 form-group">
                              <textarea type="text" class="fieldname form-control" name="authorArticle[]" placeholder="Articles">{{ $author->author_article }}</textarea>
                            </div>
                            <div class="col-md-3 form-group">
                              <textarea class="fieldname form-control" name="authorSubject[]" placeholder="subject">{{ $author->auth_subject }}</textarea>
                            </div>
                            <div class="col-md-2 form-group">
                              <input type="text" class="fieldname form-control" name="authorPaginate[]" value="{{ $author->pagi }}" placeholder="paginate">
                            </div>
                            <div class="col-md-1">
                              @if( $key == 0 )
                                <button id="add" type="button" class="btn btn-success">+</button>
                              @else
                                <button id="add" data-id="{{ $author->id }}" type="button" class="btn btn-danger remove" onclick="removeExistingField(this)">X</button>
                              @endif
                            </div>
                        </div>
                          @endforeach
                          @else

                          <div class="row fieldwrapper" id="buildyourform">
                            <div class="col-md-3 form-group">
                              <input type="text" class="fieldname form-control" name="authorName[]" placeholder="name">
                            </div>
                            <div class="col-md-3 form-group">
                              <textarea type="text" class="fieldname form-control" name="authorArticle[]" placeholder="Articles"></textarea>
                            </div>
                            <div class="col-md-3 form-group">
                              <textarea class="fieldname form-control" name="authorSubject[]" placeholder="Subject"></textarea>
                            </div>
                            <div class="col-md-2 form-group">
                              <input type="text" class="fieldname form-control" name="authorPaginate[]" placeholder="paginate">
                            </div>
                            <div class="col-md-1">
                              <button id="add" type="button" class="btn btn-success">+</button>
                            </div>
                          </div>
                    @endif
                      </div>
                    </div>
                  </div><!--/.row-->
                  <br />
                  <br />

                  <div class="row">
                    <hr><hr class="hr-dark">
                    <div class="col-md-12">
                      <button class="btn btn-lg btn-success" type="submit">Update {{ $type }}</button>
                    </div>
                  </div>
                </div>
            </form>
          </div>
      </div>
  </div>


      <!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Send message</h4>
      </div>
      <div class="modal-body">

      </div>
      <!--div class="modal-footer">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div-->
    </div>
  </div>
</div>
@endsection

@section('ownjs')
<script type="text/javascript" src="{{  asset('backend/color-admin-v4.2/admin/assets/plugins/bootstrap-sweetalert/sweetalert.min.js') }}"></script>
  <script src="{{asset('/js/select2.min.js')}}"></script>
  <script src="{{asset('/date/jquery.datetimepicker.js') }}"></script>
  <script type="text/javascript">
    $(document).ready(function () {
      $('.datepicker').datepicker({
        dateFormat: "dd-mm-yy"
      });
      $('#selectType').on("change", function(e) {
        e.defaultPrevented;
        var type = $(this).val();
        window.location.href = "{{ route('dashboard.library.create') }}/?type=" + type;
      });


      $(".js-example-placeholder-multiple").select2({
          placeholder: "Select a state",
          tags: true,
          ajax: {
          url: "{{ route('ajax.tags', '') }}",
          dataType: "json",
          data: function (params) {
            var query = {
              search: params.term,
              type: 'public'
            }

            // Query parameters will be ?search=[term]&type=public
            return query;
          },
          processResults: function (data, params) {
              params.page = params.page || 1;

              return {
                  results: data.results,
                  pagination: {
                      more: (params.page * 10) < data.count_filtered
                  }
              };
          },
          delay: 250 // wait 250 milliseconds before triggering the request
        }
      });

        $('#libraryAddNewForm').submit(function(){

          var data = $(this).serialize();
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });

          $.ajax({
                type: "POST",
                url: "{{route('dashboard.ajax.update')}}",
                data: data,
                dataType: 'json',
                success: function (data) {
                  if( data.success == true ){
                    swal({
                        title: "Success!",
                        text: "Information updated successfully.",
                        type: "success",
                    }).then((willDelete) =>{

                    });
                  }

                },
                error: function (jqXHR, status, err) {
                  swal({
                        title: "Failed!",
                        text: "Information cannot be updated.",
                        type: "error",
                    }).then((willDelete) =>{
                      $(form).reset();
                    });
                }
            });

          return false;
        });
            $("#add").click(function () {
                var lastField = $("#buildyourform div:last");
                var oldValue = 0;
                var intId = parseFloat(oldValue) + 1;
                var fieldWrapper = $("<div class='row fieldwrapper' id='field" + intId + "'/>");
                fieldWrapper.data("idx", intId);

                var field_name = $("<div class='col-md-3 form-group'>" +
                    "<input type='text' class='fieldname form-control' name='authorName[]' placeholder='name'/>" +
                    "</div>");

                var field_article= $("<div class='col-md-3 form-group'>" +
                    " <textarea type='text' class='fieldname form-control' name='authorArticle[]' placeholder='articles'  /></textarea>" +
                    "</div>");

                var field_subject= $("<div class='col-md-3 form-group'>" +
                    "<textarea type='text' class='fieldname form-control' name='authorSubject[]' placeholder='Subject'  /></textarea>" +
                    "</div>");

                var field_paginate = $("<div class='col-md-2 form-group'>" +
                    "<input type='text' class='fieldname form-control' name='authorPaginate[]' placeholder='paginate'/>" +
                    "</div>");

                var removeButton = $("<div class='col-md-1'>" +
                    "<button type='button' class='btn btn-danger remove'>" +
                    "<i class='fa fa-trash-o'></i>" +
                    "X</button>" +
                    "</div> </div>");

                removeButton.click(function (e) {
                    removeField(this);
                });
                fieldWrapper.append(field_name);
                fieldWrapper.append(field_article);
                fieldWrapper.append(field_subject);
                fieldWrapper.append(field_paginate);
                fieldWrapper.append(removeButton);
                $("#buildyourform").append(fieldWrapper);
            });

        });

      function removeExistingField( _this )
      {
        var id = $(_this).attr('data-id');
        console.log( id );
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        $.ajax({
          type: "POST",
          url: "{{route('dashboard.ajax.author.delete')}}",
          data: {id: id},
          responseType: "json",
          success: function (data) {
            if( data.success == true ){
              removeField( _this );
            } else {
              alert(data.msg );
            }
          },
          error: function (jqXHR, status, err) {
            alert(err);
          }
        });
      }


        function removeField(_this) {
            var id = _this.getAttribute('data-id');
            if (id) {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '',
                    type: 'post',
                    data: {field_id: id},
                    success: function (data) {
                        if (data == 'true') {
                            var msg = '<div class="alert alert-success alert-dismissible">' +
                                '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' +
                                '<strong>Successfully deleted field</strong>.' +
                                '</div>';
                            $('#msg').html(msg);
                        }
                        //console.log(data);

                    }
                });
            }
            var parent = $(_this).parents('.fieldwrapper');
            $(parent).remove();
        }
  </script>
<script type="text/javascript" src="{{ asset('js/jquery.upload.js') }}"></script>
<script type="text/javascript">
    jQuery(document).ready(function($) {
      $('.jQFileUpload').click( function (e) {
        e.defaultPrevented;
        var jQUploadParent = $(this).parents('.uploadPrent');
        var modal = document.getElementById('myModal');
        var modalTitle = modal.querySelector('.modal-title');
        var modalBody = modal.querySelector('.modal-body');
        var role = this.getAttribute('role');
        modalTitle.innerHTML = "Upload " + role;
        modalBody.innerHTML = "";

        //create form
        var form = $("<form method='post' action='{{ route('dashboard.ajax.jqupload')}}' enqtype='multipart/form-data' charset='utf-8'></form>");
        var inputGroup = $('<div class="input-group"></div>');
        var inputGroupBtn = $('<span class="input-group-btn"></span>');
        var browsBtn = $('<button id="fake-file-button-browse" type="button" class="btn btn-default"></button>');
        var browsBtnIcon = $('<span class="fa fa-image"> Browse...</span>');
        $(browsBtn).append(browsBtnIcon);
        $(inputGroupBtn).append(browsBtn);
        $(inputGroup).append(inputGroupBtn);
        var fileInput = $('<input type="file" name="uploadfile" id="files-input-upload" style="display:none">');
        $(inputGroup).append(fileInput);
        var textInput = $('<input type="text" id="fake-file-input-name" disabled="disabled" placeholder="File not selected" class="form-control">');
        $(inputGroup).append(textInput);
        var inputGroupSubmit = $('<span class="input-group-btn"></span>');
        var submitBtn = $('<button type="submit" class="btn btn-default" disabled="disabled" id="fake-file-button-upload"></button>');
        var submitBtnIcon = $('<span class="fa fa-upload"></span>');

        $(submitBtn).append(submitBtnIcon);
        $(inputGroupSubmit).append(submitBtn);
        $(inputGroup).append(inputGroupSubmit);
        $(form).append(inputGroup);

        var progressParent = $('<div class="progress"></div>');
        var progressBar = $('<div class="bar"></div >');
        var progressPercent = $('<div class="percent">0%</div >');
        var progressStatus = $('<div id="status"></div>');
        $(progressParent).append(progressBar);
        $(progressParent).append(progressPercent);
        $(form).append(progressParent);
        $(form).append(progressStatus);
        $(modalBody).append(form);
        //click events
        $(browsBtn).click(function(e) {
          $(fileInput).click();
        });
        $(fileInput).on("change", function(e) {
          $(textInput).val($(this).val());
          $(submitBtn).removeAttr('disabled');
        });
        //csrf tockent send to header
        $(form).submit( function(e) {
          e.defaultPrevented;
          var bar = $('.bar');
          var percent = $('.percent');
          var status = $('#status');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
          $(this).ajaxSubmit({
            beforeSend: function() {
              status.empty();
              var percentVal = '0%';
              bar.width(percentVal);
              percent.html(percentVal);
            },
            uploadProgress: function(event, position, total, percentComplete) {
                var percentVal = percentComplete + '%';
                bar.width(percentVal);
                percent.html(percentVal);
            },
            success: function() {
                var percentVal = '100%';
                bar.width(percentVal)
                percent.html(percentVal);
            },
            complete: function(xhr){

              var msg = xhr.responseJSON;

              console.log( msg );

              if( msg.success != true ) {
                status.html("<div class='alert alert-warning'>Cannot upload files.</div>");
              } else {

                var fileInputField = jQUploadParent.find('input[name=' + role + ']');
                fileInputField.val(msg.filename);
                if( msg.type == 'file') {
                  var imgPreview = jQUploadParent.find('.imgPreview');
                  imgPreview.html('<a href="' + msg.filelink + '" class=""><i class="fa fa-file"></i> Upload file</a>');
                }else{
                  var imgPreview = jQUploadParent.find('.imgPreview');
                  imgPreview.html('<img src="' + msg.filelink + '" class="">');
                }
                // progressParent.hide();
                $(modal).modal('hide');
              }
            }
          });

          return false;
        });
        $(modal).modal("show");
      });
    });
</script>
@endsection
