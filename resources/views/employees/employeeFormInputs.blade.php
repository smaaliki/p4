<div class="form-group row">
    <div class='details'>* Required fields</div>
</div>

<div class="form-group row">
    <label class='col-sm-3 col-form-label' for='firstName'>First Name *</label>
    <div class='col-sm-10'>
        <input type='text'
               class='form-control'
               name='firstName'
               id='firstName'
               value='{{ old('firstName', $employee->first_name) }}'>
    </div>
    <div class='col-sm-10'>
        @include('modules.error-field', ['field' => 'firstName'])
    </div>
</div>

<div class="form-group row">
    <label class='col-sm-3 col-form-label' for='lastName'>Last Name *</label>
    <div class='col-sm-10'>
        <input type='text'
               class='form-control'
               name='lastName'
               id='lastName'
               value='{{ old('lastName', $employee->last_name) }}'>
    </div>
    <div class='col-sm-10'>
        @include('modules.error-field', ['field' => 'lastName'])
    </div>
</div>

<div class="form-group row">
    <label class='col-sm-3 col-form-label' for='birthYear'>Birth Year</label>
    <div class='col-sm-10'>
        <input type='text'
               class='form-control'
               name='birthYear'
               id='birthYear'
               value='{{ old('birthYear', $employee->birth_year) }}'>
    </div>
    <div class='col-sm-10'>
        @include('modules.error-field', ['field' => 'birthYear'])
    </div>
</div>

<div class="form-group row">
    <label class='col-sm-12 col-form-label'>Gender</label>
    <div class="col-sm-2 form-check form-check-inline">
        <input class="form-check-input"
               type="radio"
               name="gender"
               id="inlineRadio1"
               value='1' {{ old('gender', $employee->gender)? 'checked':'' }}>
        <label class="form-check-label" for="inlineRadio1">Female</label>
    </div>
    <div class="col-sm-2 form-check form-check-inline">
        <input class="form-check-input"
               type="radio"
               name="gender"
               id="inlineRadio2"
               value='0' {{ old('gender', $employee->gender)? '':'checked' }}>
        <label class="form-check-label" for="inlineRadio2">Male</label>
    </div>
</div>

<!-- Todo: W3 validator does not like the date input element as it is not supported by some browsers, including Safari.  We should use a polyfill input type. -->
<div class="form-group row">
    <label class='col-sm-3 col-form-label' for='employmentDate'>Employment Date *</label>
    <div class='col-sm-10'>
        <input type='date'
               class='form-control'
               name='employmentDate'
               id='employmentDate'
               value='{{ old('employmentDate', $employee->employment_date) }}'>
    </div>
    <div class='col-sm-10'>
        @include('modules.error-field', ['field' => 'employmentDate'])
    </div>
</div>

<div class="form-group row">
    <label class='col-sm-3 col-form-label' for='terminationDate'>Termination Date</label>
    <div class='col-sm-10'>
        <input type='date'
               class='form-control'
               name='terminationDate'
               id='terminationDate'
               value='{{ old('terminationDate', $employee->termination_date) }}'>
    </div>
</div>

<!--Todo: Add a 'Make a Selection' to the list to force the user to actually think of which center the employee works at-->
<div class="form-group row">
    <label class='col-sm-10 col-form-label' for='contactcenter'>Contact Center</label>
    <div class='col-sm-10'>
        <select id='contactcenter' name='contactcenter' class='form-control'>
            @foreach($ccs as $key => $cc)
                <option value='{{ $cc->id }}' {{ (old('contactcenter', $employee->contact_center_id) == $cc->id) ? 'SELECTED' : '' }}>{{ $cc->name }}</option>
            @endforeach
        </select>
    </div>
</div>