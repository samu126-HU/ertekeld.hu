@extends('errors::minimal')

@section('title', __('Hiba 403'))
@section('code', '403')
@section('message', __($exception->getMessage() ?: 'Tiltott hozzáférés.'))
