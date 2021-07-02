@extends('formbuilder::layout')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        <div class="btn-toolbar float-md-right" role="toolbar">
                            <div class="btn-group" role="group">
                                <a href="{{ route('formbuilder::forms.index') }}" class="btn btn-sm btn-primary float-md-right">
                                    <i class="fa fa-arrow-left"></i> Back To My Forms
                                </a>
                                {{-- <button class="btn btn-primary btn-sm clipboard" data-clipboard-text="{{ route('formbuilder::form.render', $form->identifier) }}" data-message="Link Copied" data-original="Copy Form Link" title="Copy form URL to clipboard">
                                    <i class="fa fa-clipboard"></i> Copy Form Link
                                </button>  --}}
                            </div>
                        </div>
                    </h5>
                </div>

                <form action="{{ route('formbuilder::forms.update', $form) }}" method="POST" id="createFormForm" data-form-method="PUT">
                    @csrf 
                    @method('PUT')
                    
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name" class="col-form-label">Form Name</label>

                                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') ?? $form->name }}" required autofocus placeholder="Enter Form Name">

                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="visibility" class="col-form-label">Form Visibility</label>

                                    <select name="visibility" id="visibility" class="form-control" required="required">
                                        <option value="">Select Form Visibility</option>
                                        @foreach(jazmy\FormBuilder\Models\Form::$visibility_options as $option)
                                            <option value="{{ $option['id'] }}" @if($form->visibility == $option['id']) selected @endif>
                                                {{ $option['name'] }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('visibility'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('visibility') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4" @if($form->isPublic()) style="display: none;" id="allows_edit_DIV" @endif>
                                <div class="form-group">
                                    <label for="allows_edit" class="col-form-label">
                                        Allow Submission Edit
                                    </label>

                                    <select name="allows_edit" id="allows_edit" class="form-control" required="required">
                                        <option value="0" @if($form->allows_edit == 0) selected @endif>
                                            NO (submissions are final)
                                        </option>
                                        <option value="1" @if($form->allows_edit == 1) selected @endif>
                                            YES (allow users to edit their submissions)
                                        </option>
                                    </select>

                                    @if ($errors->has('allows_edit'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('allows_edit') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="alert alert-info" role="alert">
                                    <i class="fa fa-info-circle"></i> 
                                    Click on or Drag and drop components onto the main panel to build your form content.
                                </div>

                                <div id="fb-editor" class="fb-editor"></div>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="card-footer" id="fb-editor-footer" style="display: none;">
                    <button type="button" class="btn btn-primary fb-clear-btn">
                        <i class="fa fa-remove"></i> Clear Form 
                    </button> 
                    <button type="button" class="btn btn-primary fb-save-btn">
                        <i class="fa fa-save"></i> Submit &amp; Save Form
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push(config('formbuilder.layout_js_stack', 'scripts'))
 @if($id==2)
 <script type="text/javascript">
    setTimeout(function(){
    //    var str=$('.form-wrap')[0].id;
    //    var for_id=str.split("-");
    //    var form_idd=for_id[1];

    //    var wh_str1='del_frmb'+'-'+form_idd+'-'+'fld'+'-'+'1';
    //    var wh_str2='del_frmb'+'-'+form_idd+'-'+'fld'+'-'+'2';
    //    var wh_str3='del_frmb'+'-'+form_idd+'-'+'fld'+'-'+'3';
    //    var wh_str4='del_frmb'+'-'+form_idd+'-'+'fld'+'-'+'4';
    //    document.getElementById(wh_str1).disabled=true;
    //    document.getElementById(wh_str2).disabled=true;
    //    document.getElementById(wh_str3).disabled=true;
    //    document.getElementById(wh_str4).disabled=true;
    //    document.getElementsByClassName("icon-file")[0].disabled = true;
       

    //del_frmb-1569506390535-fld-1
    // document.getElementById("del_frmb-1569504976726-fld-1").disabled=true;
    },1000);
// del_id=document.getElementById("del_frmb-1569504976726-fld-1");
// del_id.addEventListener('click',function(e){
// console.log(e);
// });
        document.getElementById("visibility").disabled=true;
        window.FormBuilder = window.FormBuilder || {}
        window.FormBuilder.form_roles = @json($form_roles);
        
        window._form_builder_content = {!! json_encode($form->form_builder_json) !!}
    </script>
    <script src="{{ asset('vendor/formbuilder/js/create-form.js') }}{{ jazmy\FormBuilder\Helper::bustCache() }}" defer></script>

 @elseif ($id==4)
 <script type="text/javascript">
        document.getElementById("visibility").disabled=true;
        window.FormBuilder = window.FormBuilder || {}
        window.FormBuilder.form_roles = @json($form_roles);
        
        window._form_builder_content = {!! json_encode($form->form_builder_json) !!}
    </script>
    <script src="{{ asset('vendor/formbuilder/js/grade-form.js') }}{{ jazmy\FormBuilder\Helper::bustCache() }}" defer></script>

 @endif
   
@endpush
