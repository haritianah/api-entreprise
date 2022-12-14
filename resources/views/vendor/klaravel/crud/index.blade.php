<!-- klaravel::crud.index -->
@extends(config('ksoft.module.crud.layout', 'klaravel::layouts.crud'))

@section('content')
    <div class="{{$crudWrapperClass}}">
        @foreach (config('ksoft.module.crud.includes', []) as $viewToInclude)
           @includeIf($viewToInclude)
        @endforeach
        @card(['title' => 'Listing ' . Str::title(Str::plural($model_name))])
        @includeIf('klaravel::ui.tables.actions-menu')
        @if ($records->total()>0)
            @includeIf('klaravel::ui.tables.pagination',['class'=> 'py-2 mt-2'])
            <div class="table-responsive-lg">
                <!-- {{$viewsBasePath.$model_name.'.table'}} -->
                @includeIf($viewsBasePath.$model_name.'.table')
            </div>
        @else
            @includeif('klaravel::_parts.no-records')
        @endif
        @endcard
    </div>
@endsection
