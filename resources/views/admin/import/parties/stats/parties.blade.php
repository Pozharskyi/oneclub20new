@foreach( $parties as $party )
    <option value="{{ $party->id }}">{{ $party->party_name }}</option>
@endforeach