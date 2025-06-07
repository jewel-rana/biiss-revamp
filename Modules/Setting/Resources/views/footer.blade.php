<form class="form form-horizontal" action="{{ route('setting.store') }}" method="POST">
    @csrf
    <input type="hidden" name="tab" value="footer">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-8">

                    <div class="form-group row">
                        <div class="col-sm-3 col-form-label">
                            <label for="footer_contact_us">Contact us message</label>
                        </div>
                        <div class="col-sm-9">
                            <div class="form-group">
                                <textarea  id="footer_contact_us" class="form-control" name="contact_us_message"
                                           placeholder="Contact us message">{{ getOption('contact_us_message') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-3 col-form-label">
                            <label for="footer_follow_us">Follow us message</label>
                        </div>
                        <div class="col-sm-9">
                            <div class="form-group">
                                <textarea  id="footer_follow_us" class="form-control" name="follow_us_message"
                                           placeholder="Follow us message">{{ getOption('follow_us_message') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-3 col-form-label">
                            <label for="copyright">Copyright message</label>
                        </div>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="input-group-text">&copy;</span>
                                </div>
                                <input type="text" id="copyright" class="form-control"
                                       value="{{ old('copyright', getOption('copyright')) }}" name="copyright"
                                       placeholder="Copyright"/>
                            </div>
                        </div>
                    </div>

                    <h4>Social media</h4>
                    <hr/>
                    <div class="form-group row">
                        <div class="col-sm-3 col-form-label">
                            <label for="social_facebook">Facebook</label>
                        </div>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="input-group-text"><i class="fa fa-facebook"></i></span>
                                </div>
                                <input type="text" id="social_facebook" class="form-control"
                                       value="{{ old('social_facebook', getOption('social_facebook')) }}"
                                       name="social_facebook" placeholder="Facebook"/>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-3 col-form-label">
                            <label for="social_twitter">Twitter</label>
                        </div>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="input-group-text"><i class="fa fa-twitter"></i></span>
                                </div>
                                <input type="text" id="social_twitter" class="form-control"
                                       value="{{ old('social_twitter', getOption('social_twitter')) }}"
                                       name="social_twitter" placeholder="Facebook"/>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-3 col-form-label">
                            <label for="social_linkedin">Linkedin</label>
                        </div>
                        <div class="col-sm-9">
                            <div class="input-group input-group-merge">
                                <div class="input-group-addon">
                                    <span class="input-group-text"><i class="fa fa-linkedin"></i></span>
                                </div>
                                <input type="text" id="social_linkedin" class="form-control"
                                       value="{{ old('social_linkedin', getOption('social_linkedin')) }}"
                                       name="social_linkedin" placeholder="Facebook"/>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-3 col-form-label">
                            <label for="social_instagram">Instagram</label>
                        </div>
                        <div class="col-sm-9">
                            <div class="input-group input-group-merge">
                                <div class="input-group-addon">
                                    <span class="input-group-text"><i class="fa fa-instagram"></i></span>
                                </div>
                                <input type="text" id="social_instagram" class="form-control"
                                       value="{{ old('social_instagram', getOption('social_instagram')) }}"
                                       name="social_instagram" placeholder="Facebook"/>
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
        </div>
    </div>
</form>
