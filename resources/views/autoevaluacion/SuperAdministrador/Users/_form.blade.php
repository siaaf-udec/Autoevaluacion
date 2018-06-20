
<div class="item form-group">
    {!! Form::label('name','Nombre', 
    ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
    {!! Form::text('name', old('name'),[
        'class' => 'form-control col-md-6 col-sm-6 col-xs-12',
        'required' => 'required',
        'data-parsley-pattern' => '^[a-zA-Z]+$', 
        'data-parsley-length'=>'[5, 50]',
        'data-parsley-trigger'=>"change"
        
    ] ) !!}
    </div>
</div>
<div class="item form-group">
    {!! Form::label('lastname','Apellido', [
        'class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}

    <div class="col-md-6 col-sm-6 col-xs-12">
    {!! Form::text('lastname', old('lastname'),[
        'class' => 'form-control col-md-6 col-sm-6 col-xs-12',
        'required' => 'required',
        'data-parsley-pattern' => '^[a-zA-Z]+$',
        'data-parsley-length'=>'[7, 50]', 
        'data-parsley-trigger'=>"change"
    ]) !!}
    </div>
</div>
<div class="item form-group">
    {!! Form::label('email','Email', [
        'class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
    {!! Form::email('email', old('email'),[
        'class' => 'form-control col-md-6 col-sm-6 col-xs-12',
        'required' => 'required'
    ] ) !!}
    </div>
</div>
<div class="item form-group">
    {!! Form::label('password','Contraseña', [
        'class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
    {!! Form::password('password',[
        'class' => 'form-control col-md-6 col-sm-6 col-xs-12',
        isset($edit) ? '' : 'required' => 'required'
    ] ) !!}
    </div>
</div>