@extends('layouts.app')

@section('content')
<h2>Vote for Candidates</h2>

<form action="{{ route('voting.submit') }}" method="POST">
    @csrf

    @foreach($candidates as $sector => $sectorCandidates)
        <fieldset>
            <legend>{{ $sector }}</legend>
            @foreach($sectorCandidates as $candidate)
                <div>
                    <input type="radio" name="votes[{{ $sector }}]" value="{{ $candidate->id }}" id="candidate-{{ $candidate->id }}">
                    <label for="candidate-{{ $candidate->id }}">{{ $candidate->first_name }} {{ $candidate->last_name }}</label>
                </div>
            @endforeach
        </fieldset>
    @endforeach

    <input type="hidden" name="fingerprint_data" id="fingerprint_data">

    <button type="button" id="scanBtn">Scan Fingerprint & Submit</button>
</form>

<script src="{{ asset('js/fingerprint.js') }}"></script>
@endsection
