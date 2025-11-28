
<div  class="col s12">

    <form class="col s12" id="edit_designation_form{{$item->id}}" method="post" action="{{route('designations.update')}}">

        {{-- Start : Hidden fields that hold required data --}}
        <input id="designation_id{{$item->id}}" name="designation_id" type="text" class="validate" hidden required value="{{$item->id}}">
        {{-- End   : Hidden fields that hold required data --}}

        <div class="form-container">

            <div class="center timo-form-headers">Designation Details</div>

            <div class="row">
                <div class="input-field col m6 offset-m3 l6 offset-l3 s12">
                    <input id="name" name="title" type="text" class="validate" required value="{{$item->title}}">
                    <label for="title"Designation Title</label>
                </div>
            </div>

            <div class="row">
                <div class="col s12">

                    <div class="message-success center" id="form-messages{{$item->id}}"></div>
                    <div class="message-error" id="print-error-msg{{$item->id}}" style="display:none">
                        <ul></ul>
                    </div>

                </div>
            </div>

            <div class="row row-custom-modal-footer">
                <div class="col s12 spacer-small"></div>
                <div class="col s12">
                    <button class="modal-action right btn-flat waves-effect waves-light waves-red camel-case " onclick="$('#modal{{$item->id}}').modal('close'); return false;"  >CLOSE</button>
                    <button class="modal-action right btn-flat waves-effect waves-light camel-case waves-green" type="submit" name="action">UPDATE</button>
                </div>
                <div class="col s12 spacer"></div>
            </div>

            {{csrf_field()}}

        </div>

    </form>

</div>