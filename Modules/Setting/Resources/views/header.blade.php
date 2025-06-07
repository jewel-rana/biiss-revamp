<div class="card">
    <div class="card-body">
        <form class="form form-horizontal" action="{{ route('setting.store') }}" method="POST">
            @csrf
            <input type="hidden" name="tab" value="header">
            <div class="row">
                <div class="col-8">
                    <div class="form-group row uploadPrent">
                        <div class="col-sm-3 col-form-label">
                            <label for="logo">Logo</label>
                        </div>
                        <div class="col-sm-9">
                            <div class="input-group input-group-merge">
                                <input type="text" id="logo" class="form-control" value="{{ old('logo', getOption('logo')) }}" name="logo" placeholder="Logo" />
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-primary jQFileUpload" role="logo">
                                        <span class="fa fa-upload"></span>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-3 col-form-label">
                        </div>
                        <div class="col-sm-9">
                            <button class="btn btn-primary" type="submit">{{ __('Save') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
