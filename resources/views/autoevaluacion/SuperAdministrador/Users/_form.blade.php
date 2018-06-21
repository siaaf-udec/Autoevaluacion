<div class="item form-group">
    {!! Form::label('name','Nombre', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('name', old('name'),[ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 
        'required' => 'required', 
        'data-parsley-pattern' => '^[a-zA-Z\s]*$',
        'data-parsley-pattern-message' => 'Por favor escriba solo letras',
        'data-parsley-length' => "[1, 50]", 
        'data-parsley-trigger'=>"change"] ) !!}
    </div>
</div>
<div class="item form-group">
    {!! Form::label('lastname','Apellido', [ 'class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}

    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('lastname', old('lastname'),[ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 'required' => 'required',
        'data-parsley-pattern' => '^[a-zA-Z\s]*$', 
        'data-parsley-pattern-message' => 'Por favor escriba solo letras',
        'data-parsley-length' => "[1, 50]",
         'data-parsley-trigger'=>"change" ]) !!}
    </div>
</div>
<div class="item form-group">
    {!! Form::label('cedula','Cedula', [ 'class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}

    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('cedula', old('cedula'),[ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 'required' => 'required',
        'data-parsley-type'=>"number",
        'data-parsley-length' => "[1, 10]",
        'data-parsley-trigger'=>"change" ])
        !!}
    </div>
</div>
<div class="item form-group">
    {!! Form::label('email','Email', [ 'class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::email('email', old('email'),[ 
            'class' => 'form-control col-md-6 col-sm-6 col-xs-12',
            'data-parsley-pattern' => '/@(ucundinamarca.edu.co)/g', 
            'data-parsley-pattern-message' => 'El correo debe ser institucional', 
            'required' => 'required' ]
        ) !!}
    </div>
</div>
<div class="item form-group">
    {!! Form::label('password','Contraseña', [ 'class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::password('password',[ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', isset($edit) ? '' : 'required' =>
        'required' ] ) !!}
    </div>
</div>
<div class="item form-group">
    {!! Form::label('estado','Estado', [ 'class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {{-- <select class="select2_user form-control" name="id_estado">
            @foreach($estados as $estado)
        <option selected="{{ isset($user)?  }}" value="{{  $estado->PK_ESD_Id }}">{{ $estado->ESD_Nombre }}</option>
            @endforeach
                                                       
        </select> --}}
        {!! Form::select('PK_ESD_Id', $estados, old('PK_ESD_Id', isset($user)? $user->id_estado:''), [
            'class' => 'select2_user form-control', 
            'required']) !!}
    </div>
</div>