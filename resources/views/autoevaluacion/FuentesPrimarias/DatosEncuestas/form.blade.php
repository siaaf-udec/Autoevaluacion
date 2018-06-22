<div class="item form-group">
    {!! Form::label('DAE_Titulo','Titulo', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('DAE_Titulo', old('DAE_Titulo'),[ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 
        'required' => 'required', 
        'data-parsley-pattern' => '^[a-zA-Z ][a-zA-Z0-9-_\. ]{1,50}$',
        'data-parsley-pattern-message' => 'Error, digite un titulo valido',
        'data-parsley-length' => "[1, 50]", 
        'data-parsley-trigger'=>"change"] ) !!}
    </div>
</div>
<div class="item form-group">
    {!! Form::label('DAE_Descripcion','Descripcion', ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {!! Form::text('DAE_Descripcion', old('DAE_Descripcion'),[ 'class' => 'form-control col-md-6 col-sm-6 col-xs-12', 
        'required' => 'required', 
        'data-parsley-pattern' => '^[a-zA-Z ][a-zA-Z0-9-_\. ]{1,500}$',
        'data-parsley-pattern-message' => 'Por favor escriba solo letras',
        'data-parsley-length' => "[1, 500]", 
        'data-parsley-trigger'=>"change"] ) !!}
    </div>
</div>
<div class="item form-group">
    {!! Form::label('grupo','Grupo de Interes', [ 'class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
        {{-- <select class="select2_user form-control" name="id_datos">
            @foreach($items as $item)
        <option selected="{{ isset($user)?  }}" value="{{  $item->PK_GIT_Id }}">{{ $item->GIT_Nombre }}</option>
            @endforeach                                          
        </select> --}}
        {!! Form::select('FK_DAE_GruposInteres', $items, old('FK_DAE_GruposInteres', isset($user)? $user->id_datos:''), [
            'class' => 'select2_user form-control', 
            'required']) !!}
    </div>
</div>
