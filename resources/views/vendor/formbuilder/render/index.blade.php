{{-- @extends('formbuilder::layout') --}}
@extends('vendor.formbuilder.layoutFrontend')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card rounded-0">
                <div class="card-header">
                    <h5 class="card-title">{{ $pageTitle }}</h5>
                </div>

                <form action="{{ route('formbuilder::form.submit', $form->identifier) }}" method="POST" id="submitForm" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="card-body">
                        <div id="fb-render"></div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary confirm-form" data-form="submitForm" data-message="Submit your entry for '{{ $form->name }}'?">
                            <i class="fa fa-submit"></i> Submit Form
                        </button>
                    </div>
                <input type="hidden" name="form_data" id="form_data" value='{!! ($form->form_builder_json) !!}' />
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push(config('formbuilder.layout_js_stack', 'scripts'))
    <script type="text/javascript">
       @if($errors->any())
       
        window._form_builder_content = {!! json_encode(Session::get('form_data')) !!}
        @else
        window._form_builder_content = {!! json_encode($form->form_builder_json) !!}
       
        // window._form_builder_content="[{\"type\":\"text\",\"required\":true,\"label\":\"Parent first name\",\"placeholder\":\"Parent first name\",\"className\":\"form-control\",\"name\":\"text-1568906692227\",\"subtype\":\"text\"},{\"type\":\"text\",\"required\":true,\"label\":\"Parent last name\",\"placeholder\":\"Parent last name\",\"className\":\"form-control\",\"name\":\"text-1568972486658\",\"subtype\":\"text\"},{\"type\":\"text\",\"required\":true,\"label\":\"Parent first name\",\"placeholder\":\"Parent first name\",\"className\":\"form-control\",\"name\":\"text-1568906692227\",\"subtype\":\"text\"},{\"type\":\"text\",\"subtype\":\"email\",\"required\":true,\"label\":\"Email\",\"placeholder\":\"Email\",\"className\":\"form-control\",\"name\":\"text-1568972596339\"},{\"type\":\"text\",\"subtype\":\"password\",\"required\":true,\"label\":\"Password\",\"placeholder\":\"Password\",\"className\":\"form-control\",\"name\":\"text-1568972618650\"},{\"type\":\"select\",\"required\":true,\"label\":\"Parent gender\",\"className\":\"form-control\",\"name\":\"select-1568972663607\",\"values\":[{\"label\":\"Male\",\"value\":\"Male\",\"selected\":true},{\"label\":\"Female\",\"value\":\"Female\"}]},{\"type\":\"select\",\"required\":true,\"label\":\"Country\",\"className\":\"form-control\",\"name\":\"select-1568972792206\",\"values\":[{\"label\":\"India\",\"value\":\"India\"},{\"label\":\"Usa\",\"value\":\"Usa\",\"selected\":true},{\"label\":\"Russia\",\"value\":\"Russia\"}]},{\"type\":\"text\",\"label\":\"Child first name\",\"placeholder\":\"Child first name\",\"className\":\"form-control\",\"name\":\"text-1568972889980\",\"subtype\":\"text\"},{\"type\":\"number\",\"label\":\"Child grade\",\"placeholder\":\"Child grade\",\"className\":\"form-control\",\"name\":\"number-1568973088741\"},{\"type\":\"number\",\"label\":\"Child Age\",\"placeholder\":\"Child Age\",\"className\":\"form-control\",\"name\":\"number-1568973138712\"},{\"type\":\"checkbox-group\",\"label\":\"Do you have another child?\",\"toggle\":true,\"inline\":true,\"name\":\"checkbox-group-1568973475252\",\"values\":[{\"label\":\"\",\"value\":\"\",\"selected\":true}]},{\"type\":\"text\",\"label\":\"Sibling First Name\",\"placeholder\":\"Sibling First Name\",\"className\":\"form-control\",\"name\":\"text-1568973630291\",\"subtype\":\"text\"},{\"type\":\"select\",\"label\":\"Sibling Gender\",\"className\":\"form-control\",\"name\":\"select-1568973667002\",\"values\":[{\"label\":\"Male\",\"value\":\"Male\",\"selected\":true},{\"label\":\"Female\",\"value\":\"Female\"}]}]";
        @endif

        // {\"type\":\"text\",\"required\":true,\"label\":\"Parent first name\",\"placeholder\":\"Parent first name\",\"className\":\"form-control\",\"name\":\"text-1568906692227\",\"subtype\":\"text\"}


    </script>
    <script src="{{ asset('vendor/formbuilder/js/render-form.js') }}{{ jazmy\FormBuilder\Helper::bustCache() }}" defer></script>
@endpush
