<div class="col s12 spacer"></div>
<div class="row">
    {{-- Contract Form --}}
    <div  class="col m4 s12 custom-border form-bg">

        <form class="col s12" id="form_employee_contract" method="post" action="{{route('human-resource.user-contract.store')}}">

            {{-- Start : Hidden fields that hold required data --}}
            <input id="username" name="username" type="text" hidden value="{{$username}}">
            <input id="created_by" name="created_by" type="text" hidden value="{{$author->username}}">
            <input id="record_id" name="record_id" type="text" hidden value="">
            {{-- End   : Hidden fields that hold required data --}}

            <div class="form-container ">

                <div class="col s12 spacer"></div>
                <h6 class="center spacer-top timo-primary-text bold-text">Add Contract Details</h6>

                <div class="row spacer-top">
                    <div class="input-field col s12">
                        <input id="contract_reference" name="contract_reference" type="text" class="validate" value="{{old('contract_reference')}}">
                        <label for="contract_reference">Contract Reference</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <label for="contract_start_date" >Contract Start Date</label>
                        <input  id="contract_start_date" name="contract_start_date" type="date" class="browser-default col s12" value="{{old('contract_start_date')}}" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <label for="contract_expiry_date" >Contract End Date</label>
                        <input  id="contract_expiry_date" name="contract_expiry_date" type="date" class="browser-default col s12" value="{{old('contract_expiry_date')}}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12">

                        <div class="message-success center" id="form-messages"></div>
                        <div class="message-error" id="print-error-msg" style="display:none">
                            <ul></ul>
                        </div>

                    </div>
                </div>

                <div class="row ">
                    <div class="col s12">
                        <button class="right green btn waves-effect waves-light camel-case waves-green col s12 " type="submit" name="action">SAVE</button>
                    </div>
                    <div class="col s12 spacer"></div>
                </div>

                {{csrf_field()}}

            </div>


        </form>



        <form  class="col s12 hidden" id="form_employee_contract_edit" method="post" action="{{route('human-resource.user-contract.update')}}">

            {{-- Start : Hidden fields that hold required data --}}
            <input id="username_edit" name="username" type="text" hidden value="{{$username}}">
            <input id="created_by_edit" name="created_by" type="text" hidden value="{{$author->username}}">
            <input id="record_id_edit" name="record_id" type="text" hidden value="">
            {{-- End   : Hidden fields that hold required data --}}

            <div class="form-container ">

                <div class="col s12 spacer"></div>
                <h6 class="center spacer-top timo-primary-text  bold-text">Edit Contract Details</h6>

                <div class="row spacer-top">
                    <div class="input-field col s12">
                        <input id="contract_reference_edit" name="contract_reference" type="text" class="validate" value="{{old('contract_reference')}}">
                        <label for="contract_reference">Contract Reference</label>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12">
                        <label for="contract_start_date" >Contract Start Date</label>
                        <input  id="contract_start_date_edit" name="contract_start_date" type="date" class="browser-default col s12" value="{{old('contract_start_date')}}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12">
                        <label for="contract_expiry_date">Contract End Date</label>
                        <input  id="contract_expiry_date_edit" name="contract_expiry_date" type="date" class="browser-default col s12" value="{{old('contract_expiry_date')}}" required>

                    </div>
                </div>


                <div class="row">
                    <div class="col s12">

                        <div class="message-success center" id="form-messagesedit"></div>
                        <div class="message-error" id="print-error-msgedit" style="display:none">
                            <ul></ul>
                        </div>

                    </div>
                </div>

                <div class="row ">
                    <div class="col s12 spacer-small"></div>
                    <div class="col s12">
                        <button class="right green btn waves-effect waves-light camel-case waves-green " type="submit" name="action">UPDATE</button>
                        <button class="cancel-edit-button left red btn waves-effect waves-light waves-red camel-case " onclick="$('#modal_user_academic_bg').modal('close'); return false;"  >CANCEL</button>
                    </div>
                    <div class="col s12 spacer"></div>
                </div>

                {{csrf_field()}}

            </div>


        </form>

    </div>

    {{-- Contract History Table --}}
    <div class="col m8 s12">

        <h6 class="center bold-text timo-primary-text">CONTRACT HISTORY</h6>
        <div class="col s12 center bold-text timo-primary-text">{{strtolower($username)}}</div>

        <div class="hr-dotted col s12 spacer"></div>

        <div class="col s12 spacer-top">
            <table  class="bordered table-tiny-text">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Contract Ref</th>
                    <th>Contract Start Date</th>
                    <th>Contract End Date</th>
                    <th>Added By</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
                </thead>
                <tbody>

                @if(isset($contracts) && count($contracts) > 0)
                    @foreach($contracts as $contract)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$contract->contractReference}}</td>
                            <td>{{$contract->startDate}}</td>
                            <td>{{$contract->expiryDate}}</td>
                            <td>{{$contract->createdBy}}</td>
                            <td><a data-ref="{{$contract->contractReference}}" data-start-date="{{$contract->startDate}}" data-expiry-date="{{$contract->expiryDate}}"  data-record-id="{{$contract->id}}" class="green-text  modal-trigger edit-button-contract" href="#modal{{$contract->id}}"><i class="material-icons center">edit</i></a></td>
                            <td><a class="red-text" href="{{route('human-resource.user-contract.delete',$contract->id)}}" ><i class="material-icons center">delete_forever</i></a></td>
                        </tr>

                        {{--@include('hr.modal-hr-contract-history-delete-modal')--}}

                    @endforeach
                @else
                    <tr>
                        <td colspan="7" class="center">No Contract History Founds</td>
                    </tr>
                @endif

                </tbody>
            </table>
        </div>
    </div>


    <div class="row row-custom-modal-footer">
        <div class="col s12 spacer-small"></div>
        <div class="col s12"><button class="modal-action right btn-flat waves-effect waves-light waves-red camel-case " onclick="$('#modal_hr_contract_history').modal('close'); return false;"  >CLOSE</button>
        </div>
        <div class="col s12 spacer"></div>
    </div>

</div>