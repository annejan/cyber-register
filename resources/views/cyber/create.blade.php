@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">
                    CyberExpertise toevoegen
                </div>

                {{ implode(' ', $errors->all()) }}

                <div class="card-body">
                    <form method="POST" action="{{ route('cyberExpertise.store') }}" class="register">
                        @csrf

                        <div class="form-group row">
                            <label for="expertise_code" class="col-md-4 col-form-label text-md-right">Code + points / 2yr</label>

                            <div class="col-md-4">
                                <input id="expertise_code" type="text" class="form-control{{ $errors->has('expertise_code') ? ' is-invalid' : '' }}" name="expertise_code" value="{{ old('expertise_code') }}" required maxlength="3">

                                @if ($errors->has('expertise_code'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('expertise_code') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-4">
                                <input id="required_points" type="number" class="form-control{{ $errors->has('required_points') ? ' is-invalid' : '' }}" name="required_points" value="{{ old('required_points') }}" required min="0">

                                @if ($errors->has('required_points'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('required_points') }}</strong>
                                    </span>
                                @endif
                            </div>

                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">Description</label>

                            <div class="col-md-8">
                                <textarea id="description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" required>{{ old('description') }}</textarea>

                                @if ($errors->has('description'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Opslaan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
