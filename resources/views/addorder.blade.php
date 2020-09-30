@extends('layouts.app')

@section('content')
<?php
$user = auth()->user()
?>
<add-order ></add-order>

@endsection