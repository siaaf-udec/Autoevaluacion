<div class="item form-group">
    {!! Form::label('DAE_Titulo','Titulo', 
    ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
    {!! Form::text('DAE_Titulo', old('DAE_Titulo'),[
        'class' => 'form-control col-md-6 col-sm-6 col-xs-12',
        'required' => 'required',
        'data-parsley-pattern' => '^([a-zA-Z]+(?:\s*|$))\1*', 
        'data-parsley-length'=>'[5, 150]',
        'data-parsley-trigger'=>"change"
        
    ] ) !!}
    </div>
</div>
<div class="item form-group">
    {!! Form::label('DAE_Descripcion','Descripcion', [
        'class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
    {!! Form::text('DAE_Descripcion', old('DAE_Descripcion'),[
        'class' => 'form-control col-md-6 col-sm-6 col-xs-12',
        'required' => 'required',
        'data-parsley-pattern' => '^[a-zA-Z]+$',
        'data-parsley-length'=>'[7, 1500]', 
        'data-parsley-trigger'=>"change"
    ]) !!}
    </div>
</div>
<div class="item form-group">
    {!! Form::label('FK_DAE_GruposInteres','Email', [
        'class'=>'control-label col-md-3 col-sm-3 col-xs-12']) !!}
    <div class="col-md-6 col-sm-6 col-xs-12">
    {{ Form::select('FK_DAE_GruposInteres', $items, old('FK_DAE_GruposInteres'), ['class' => 'form-control']) }}
    </div>
</div>
