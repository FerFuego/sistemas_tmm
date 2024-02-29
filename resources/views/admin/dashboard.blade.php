@extends('layouts.app')

@section('title-section','DASHBOARD ADMIN')

@section('content')
	<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
	@if (Auth::guest())
		<script type="text/javascript">
			$( document ).ready(function() {
			    window.location.href = "{{ url('/login') }}";
			});
		</script>
	@else
		@if(Auth::user()->hasRole('admin'))
			<script type="text/javascript">
				$( document ).ready(function() {
				    window.location.href = "{{ url('/usuarios/todos') }}";
				});
			</script>
		@else
			<script type="text/javascript">
				$( document ).ready(function() {
				    window.location.href = "{{ url('/users/dashboard') }}";
				});
			</script>
		@endif
	@endif
@endsection 

@section('javascript')
@stop
