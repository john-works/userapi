
<div  class="col s12">

    <form class="col s12" id="edit_category_form{{$category->categoryCode}}" method="post" action="{{route('employee-categories.update')}}">

        {{-- Start : Hidden fields that hold required data --}}
        <input id="category_code" name="category_code" type="text" class="validate" hidden required value="{{$category->categoryCode}}">
        <input id="created_by" name="created_by" type="text" class="validate" hidden required value="{{$category->createdBy}}">
        <input id="updated_by" name="updated_by" type="text" class="validate" hidden required value="{{$author->username}}">
        {{-- End   : Hidden fields that hold required data --}}

        <div class="form-container">

            <div class="center timo-form-headers">Employee Category Details</div>


            {{-- Organization --}}
            <div class="row">
                <div class="col m6 offset-m3 l6 offset-l3 s12">
                    <label class="display-block" for="org_code">Organization</label>
                    <select name="org_code" id="org_code_{{$category->categoryCode}}" required class="browser-default timo-select">
                        <option value="" disabled selected>Choose Organization</option>
                        @if(isset($organizations) && count($organizations) > 0)
                            @foreach($organizations as $org)
                                <option @if($category->orgCode == $org->orgCode) selected @endif value="{{$org->orgCode}}">{{$org->name}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col s12 spacer"></div>
            </div>

            {{-- Category Name and Category Code --}}
            <div class="row">
                <div class="input-field col m6 offset-m3 l6 offset-l3 s12">
                    <input id="category" name="category" type="text" class="validate" required value="{{$category->category}}">
                    <label for="category">Employee Category</label>
                </div>
            </div>

            <div class="row">
                <div class="col s12">

                    <div class="message-success center" id="form-messages{{$category->categoryCode}}"></div>
                    <div class="message-error" id="print-error-msg{{$category->categoryCode}}" style="display:none">
                        <ul></ul>
                    </div>

                </div>
            </div>

            <div class="row row-custom-modal-footer">
                <div class="col s12 spacer-small"></div>
                <div class="col s12">
                    <button class="modal-action right btn-flat waves-effect waves-light waves-red camel-case " onclick="$('#modal{{$category->categoryCode}}').modal('close'); return false;"  >CLOSE</button>
                    <button class="modal-action right btn-flat waves-effect waves-light camel-case waves-green" type="submit" name="action">UPDATE</button>
                </div>
                <div class="col s12 spacer"></div>
            </div>

            {{csrf_field()}}

        </div>

    </form>

</div>