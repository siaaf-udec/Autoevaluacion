<div class="item form-group">
    {!! Form::label('CRT_Nombre','Nombre', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('CRT_Nombre', old('CRT_Nombre'),[ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 
        'required' => 'required', 
        'data-parsley-pattern' => '^[a-zA-Z ][a-zA-Z0-9-_\. ]{1,50}$',
        'data-parsley-pattern-message' => 'Error, digite un nombre valido',
        'data-parsley-length' => "[1, 50]", 
        'data-parsley-trigger'=>"change"] ) !!}
    </div>
</div>
<div class="item form-group">
    {!! Form::label('CRT_Descripcion','Descripcion', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('CRT_Descripcion', old('CRT_Descripcion'),[ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 
        'required' => 'required', 
        'data-parsley-pattern' => '^[a-zA-Z ][a-zA-Z0-9-_\. ]{1,500}$',
        'data-parsley-pattern-message' => 'Por favor escriba solo letras',
        'data-parsley-length' => "[1, 500]", 
        'data-parsley-trigger'=>"change"] ) !!}
    </div>
</div>
<div class="item form-group">
    {!! Form::label('CRT_Identificador','Identificador', [ 'class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('CRT_Identificador', old('CRT_Identificador'),
        [ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 
        'required' => 'required',
        'data-parsley-type'=>"number", 
        'data-parsley-length' => "[1, 10]", 
        'data-parsley-trigger'=>"change" ]) 
        !!}
    </div>
</div>

<div class="item form-group">
    {!! Form::label('lineamiento','Lineamiento', [ 'class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {{-- <select class="select2_user form-control" name="id_lineamiento">
            @foreach($lineamientos as $lineamiento)
        <option selected="{{ isset($user)?  }}" value="{{  $lineamiento->PK_LNM_Id }}">{{ $lineamiento->LNM_Nombre }}</option>
            @endforeach                                          
        </select> --}}
        {!! Form::select('FK_FCT_Lineamiento', $lineamientos, old('FK_FCT_Lineamiento', isset($user)? $user->id_lineamiento:''), [
            'class' => 'select2_user form-control', 
            'required']) !!}
    </div>
</div>

<div class="item form-group">
    {!! Form::label('factor','Factor', [ 'class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {{-- <select class="select2_user form-control" name="id_factor">
            @foreach($factores as $factor)
        <option selected="{{ isset($user)?  }}" value="{{  $factores->PK_FCT_Id }}">{{ $factores->FCT_Nombre }}</option>
            @endforeach                                          
        </select> --}}
        {!! Form::select('FK_CRT_Factor', null, old('FK_CRT_Factor', isset($user)? $user->id_factor:''), [
            'class' => 'select2_user form-control', 
            'required']) !!}
    </div>
</div>

