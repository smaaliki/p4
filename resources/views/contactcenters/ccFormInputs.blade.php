<div class="form-group row">
    <div class='details'>* Required fields</div>
</div>

<div class="form-group row">
    <label class='col-sm-10 col-form-label' for='ccName'>Name *</label>
    <div class='col-sm-10'>
        <input type='text'
               class='form-control'
               name='ccName'
               id='ccName'
               value='{{ old('ccName', $cc->name) }}'>
    </div>
    <div class='col-sm-10'>
        @include('modules.error-field', ['field' => 'ccName'])
    </div>
</div>

<div class="form-group row">
    <label class='col-sm-10 col-form-label' for='address'>Address</label>
    <div class='col-sm-10'>
        <input type='text'
               class='form-control'
               name='address'
               id='address'
               value='{{ old('address', $cc->street_address) }}'>
    </div>
</div>

<div class="form-group row">
    <label class='col-sm-10 col-form-label' for='emirate'>District</label>
    <div class='col-sm-10'>
        <select id='emirate' name='emirate' class='form-control'>
            @foreach($emirates as $numeric => $string)
                <option value='{{ $numeric }}' {{ (old('emirate', $cc->emirate) == $numeric) ? 'SELECTED' : '' }}>{{ $string }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="form-group row">
    <label class='col-sm-10 col-form-label' for='phoneNumber'>Phone Number *</label>
    <div class='col-sm-10'>
        <input type='text'
               class='form-control'
               maxlength='22'
               name='phoneNumber'
               id='phoneNumber'
               value='{{ old('phoneNumber', $cc->phone_number) }}'>
    </div>
    <div class='col-sm-10'>
        @include('modules.error-field', ['field' => 'phoneNumber'])
    </div>
</div>

<div class="form-group row">
    <label class='col-sm-10 col-form-label'>Touchpoints</label>
    @foreach($touchpointsForCheckboxes as $touchpointId => $touchpointName)
        <div class="col-sm-3 form-check form-check-inline">
            <input class="form-check-input"
                   type='checkbox'
                   name='touchpoints[]'
                   id= {{'inlineRadio'.$touchpointId}}
                   value='{{ $touchpointId }}' {{ (in_array($touchpointId, $touchpoints)) ? 'checked' : '' }}>
            <label class="form-check-label" for={{'inlineRadio'.$touchpointId}}>{{ $touchpointName }}</label>
        </div>
    @endforeach
</div>

<div class="form-group row">
    <label class='col-sm-10 col-form-label'>Services</label>
    @foreach($servicesForCheckboxes as $serviceId => $serviceName)
        <div class="col-sm-3 form-check form-check-inline">
            <input class="form-check-input"
                   type='checkbox'
                   name='services[]'
                   id= {{'inlineRadio'.$serviceId}}
                           value='{{ $serviceId }}' {{ (in_array($serviceId, $services)) ? 'checked' : '' }}>
            <label class="form-check-label" for={{'inlineRadio'.$serviceId}}>{{ $serviceName }}</label>
        </div>
    @endforeach
</div>

<div class="form-group row">
    <label class='col-sm-10 col-form-label'></label>
        <div class="col-sm-4 form-check form-check-inline">
            <input class="form-check-input"
                   type='checkbox'
                   name='crm'
                   id= 'crm'
                   value='{{ old('crm', $cc->crm) }}' {{ $cc->crm ? 'checked' : '' }}>
            <label class="form-check-label" for='crm'> We use a CRM system at our contact center</label>
        </div>
</div>