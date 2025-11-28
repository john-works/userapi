<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">

            <div class="card-body">
                {!! Form::open(['route'=>['administration.users.store'], 'class'=>'form-horizontal custom_response', 'method'=>'post', 'id'=>'form_'.time() ]) !!}
                {{Form::hidden('ext',null, ['value'=>'0'])}}
                {{ csrf_field() }}

                {{Form::hidden('table','PortalUser')}}

                @if(isset($user))
                    {{Form::hidden('fld_id',$user->id)}}
                @endif

                <div class="col-md-5">
                    <div class="form-group row">

                        <label for="username" style="font-weight: bold" class="col-md-3 col-form-label text-md-right">{{ __('User:') }}</label>
                        <div class="col-md-7">
                            <select  id="username" name="r_fld[username]" class="form-control selectize" required>
                                <option value="">Select User</option>
                                @if(isset($users))
                                    @foreach($users as $currentUser)
                                        <option value="{{ $currentUser->username }}" {{((@$user->username == $currentUser->username ) ? 'selected="selected"':'')}}>{{ $currentUser->first_name .' ' .$currentUser->last_name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                    </div>

                    {{-- Begin Read Only Fields From User Management --}}

                    @if(isset($umUser) && (!isset($userError) || $userError == ""))

                        <div class="form-group row">
                            <label for="title" class="col-md-3 col-form-label text-md-right bold-text">{{ __('First Name:') }}</label>
                            <div class="col-md-7">
                                <input readonly type="text" class="form-control" value="{{$umUser->first_name }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="title" class="col-md-3 col-form-label text-md-right bold-text">{{ __('Last name:') }}</label>
                            <div class="col-md-7">
                                <input readonly type="text" class="form-control" value="{{$umUser->last_name }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="title" class="col-md-3 col-form-label text-md-right bold-text">{{ __('Email:') }}</label>
                            <div class="col-md-7">
                                <input readonly type="text" class="form-control" value="{{$umUser->email }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="title" class="col-md-3 col-form-label text-md-right bold-text">{{ __('Title:') }}</label>
                            <div class="col-md-7">
                                <input readonly type="text" class="form-control" value="{{isset($umUser->user_designation)?$umUser->user_designation->title:'' }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="department_id"
                                   class="col-md-3 col-form-label text-md-right bold-text">{{ __('Department:') }}</label>

                            <div class="col-md-7">
                                <input readonly type="text" class="form-control"
                                       value="{{isset($umUser->department)? $umUser->department->name:"" }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="unit_id" class="col-md-3 col-form-label text-md-right bold-text">{{ __('Unit:') }}</label>

                            <div class="col-md-7">
                                <input readonly type="text" class="form-control"
                                       value="{{isset($umUser->unit)? $umUser->unit->name:"" }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="region_id"
                                   class="col-md-3 col-form-label text-md-right bold-text">{{ __('Region:') }}</label>

                            <div class="col-md-7">
                                <input readonly type="text" class="form-control"
                                       value="{{isset($umUser->regional_office)? $umUser->regional_office->name:"" }}">
                            </div>
                        </div>
                    @elseif(isset($userError) && $userError != "")
                        <div class="form-group row">
                            <p class="col-md-10 col-md-offset-1" style="color: red"><span style="font-weight: bold">Unable to Load Full User Details Due to:</span><br>{{$userError}}
                            </p>
                        </div>
                    @endif

                    {{-- End Read Only Fields From User Management --}}

                </div>

                <div class="col-md-7">
                    <h4>User Access Rights</h4>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Module</th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <?php $rights = isset($user) ? $user->rights : []; ?>
                        @foreach(get_system_modules() as $module=>$sub_module)
                            <tr style="background: #cccccc">
                                <th>
                                    {{ $module }}
                                </th>
                                <td colspan="2">
                                    <div class="radio module_radio_checked" >
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>
                                                    <input data-sub-mod-container-id="{{clear_spaces($module)}}" name="rights_{{clear_spaces($module)}}"
                                                           class="ace cbx_access_module_selector" type="radio"
                                                           value="{{ ACCESS_RIGHT_NONE }}" {{ (!authenticate_module_access($module,$rights))?'checked':'' }} >
                                                    <span class="lbl"> No Access</span>
                                                </label>
                                            </div>
                                            <div class="col-md-6">
                                                <label>
                                                    <input data-sub-mod-container-id="{{clear_spaces($module)}}" name="rights_{{clear_spaces($module)}}"
                                                           class="ace cbx_access_module_selector" type="radio"
                                                           value="{{ ACCESS_RIGHT_GRANT_ACCESS }}" {{ (authenticate_module_access($module,$rights))?'checked':'' }} >
                                                    <span class="lbl"> Grant Access</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            @if(count($sub_module) > 0)
                                @foreach($sub_module as $sub)
                                    <tr class="{{clear_spaces($module)}}" style="display:{{ (authenticate_module_access($module,$rights))?'block':'none' }};">
                                        <td>
                                           <div style="width: 120px"> {{ $sub }}</div>
                                        </td>
                                        <td>
                                            <div class="radio">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label>
                                                            <input name="rights_{{clear_spaces($module)}}_{{clear_spaces($sub)}}" class="ace sub_no_{{clear_spaces($module)}}" type="radio" value="{{ ACCESS_RIGHT_NONE }}"
                                                                {{ (!authenticate_module_subsection_access($module,$sub, $rights))?'checked':'' }} >
                                                            <span class="lbl"> No Access </span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="radio">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label>
                                                            <input name="rights_{{clear_spaces($module)}}_{{clear_spaces($sub)}}" class="ace" type="radio" value="{{ ACCESS_RIGHT_GRANT_ACCESS}}"
                                                                {{ (authenticate_module_subsection_access($module,$sub, $rights))?'checked':'' }} >
                                                            <span class="lbl"> Grant Access</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        @endforeach
                    </table>
                </div>
                <div class="form-group row mb-0 col-md-12 center">
                    <div class="col-md-12 offset-md-4">
                        <button type="submit" class="btn btn-primary btnSubmit">
                            {{isset($user)?'Update':'Save'}}
                        </button>
                    </div>
                </div>

                </form>
            </div>
        </div>
    </div>
</div>
