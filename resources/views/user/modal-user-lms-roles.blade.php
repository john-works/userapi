<div id="modal_lms_roles" class="modal custom-fields modal-70">

    <div class="modal-content">

        <div  class="col s12">

                <div class="form-container">
                    <div class="center timo-form-headers">Letter Movement Roles</div>

                    <div class="row">
                        <div class="input-field col s6">
                            <label for="registry_flag">Reception</label>
                        </div>
                        <div class="input-field col s6">
                            <p>
                                <label>
                                    <input id="rbtnReceptionYes" value="1" class="with-gap" name="gp_reception_flag" type="radio" />
                                    <span>Yes</span>
                                </label>
                                <label>
                                    <input value="0" class="with-gap" name="gp_reception_flag" type="radio" checked />
                                    <span>No</span>
                                </label>
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s6">
                            <label for="finance_flag">Finance</label>
                        </div>
                        <div class="input-field col s6">
                            <p>
                                <label>
                                    <input id="rbtnFinanceYes" value="1" class="with-gap" name="gp_finance_flag" type="radio" />
                                    <span>Yes</span>
                                </label>
                                <label>
                                    <input value="0" class="with-gap" name="gp_finance_flag" type="radio" checked />
                                    <span>No</span>
                                </label>
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s6">
                            <label for="registry_flag">Registry</label>
                        </div>
                        <div class="input-field col s6">
                            <p>
                                <label>
                                    <input value="1" class="with-gap" name="gp_registry_flag" type="radio" />
                                    <span>Yes</span>
                                </label>
                                <label>
                                    <input value="0" class="with-gap" name="gp_registry_flag" type="radio" checked />
                                    <span>No</span>
                                </label>
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s6">
                            <label for="registry_flag">ED's Office</label>
                        </div>
                        <div class="input-field col s6">
                            <p>
                                <label>
                                    <input value="1" class="with-gap" name="gp_ed_office_flag" type="radio" />
                                    <span>Yes</span>
                                </label>
                                <label>
                                    <input value="0" class="with-gap" name="gp_ed_office_flag" type="radio" checked />
                                    <span>No</span>
                                </label>
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s6">
                            <label for="registry_flag">Outgoing Letters</label>
                        </div>
                        <div class="input-field col s6">
                            <p>
                                <label>
                                    <input value="1" class="with-gap" name="gp_outgoing_letter_flag" type="radio" />
                                    <span>Yes</span>
                                </label>
                                <label>
                                    <input value="0" class="with-gap" name="gp_outgoing_letter_flag" type="radio" checked />
                                    <span>No</span>
                                </label>
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s6">
                            <label for="gp_master_data_flag">Master Data</label>
                        </div>
                        <div class="input-field col s6">
                            <p>
                                <label>
                                    <input value="1" class="with-gap" name="gp_master_data_flag" type="radio" />
                                    <span>Yes</span>
                                </label>
                                <label>
                                    <input value="0" class="with-gap" name="gp_master_data_flag" type="radio" checked />
                                    <span>No</span>
                                </label>
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s6">
                            <label for="gp_reports_flag">Reports</label>
                        </div>
                        <div class="input-field col s6">
                            <p>
                                <label>
                                    <input value="1" class="with-gap" name="gp_reports_flag" type="radio" />
                                    <span>Yes</span>
                                </label>
                                <label>
                                    <input value="0" class="with-gap" name="gp_reports_flag" type="radio" checked />
                                    <span>No</span>
                                </label>
                            </p>
                        </div>
                    </div>

                    {{csrf_field()}}
                </div>

                <div class="row row-custom-modal-footer">
                    <div class="col s12 spacer-small"></div>
                    <div class="col s12">
                        <button class="modal-action right btn-flat waves-effect waves-light waves-red camel-case " onclick="$('#modal_lms_roles').modal('close'); return false;"  >CLOSE</button>
                        <button data-modal-id="modal_lms_roles" class="modal-action right btn-flat waves-effect waves-light camel-case waves-green btnFillLmsRoles" >SET ROLES</button>
                    </div>
                    <div class="col s12 spacer"></div>
                </div>

        </div>

    </div>
</div>