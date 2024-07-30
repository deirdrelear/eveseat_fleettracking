@extends('web::layouts.grids.12')

@section('title', 'Fleet Details')
@section('page_header', $fleet->name)

@section('full')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Fleet Information</h3>
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">Fleet Commander:</dt>
                <dd class="col-sm-9">{{ $fleet->commander->name }}</dd>

                <dt class="col-sm-3">Start Time:</dt>
                <dd class="col-sm-9">{{ $fleet->start_time->format('Y-m-d H:i') }}</dd>

                <dt class="col-sm-3">End Time:</dt>
                <dd class="col-sm-9">{{ $fleet->end_time ? $fleet->end_time->format('Y-m-d H:i') : 'Ongoing' }}</dd>

                <dt class="col-sm-3">Status:</dt>
                <dd class="col-sm-9">{{ ucfirst($fleet->status) }}</dd>

                <dt class="col-sm-3">Location:</dt>
                <dd class="col-sm-9">{{ $fleet->location }}</dd>

                <dt class="col-sm-3">Doctrine:</dt>
                <dd class="col-sm-9">{{ $fleet->doctrine ?? 'N/A' }}</dd>
            </dl>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            <h3 class="card-title">Fleet Participants</h3>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Character</th>
                        <th>Ship Type</th>
                        <th>Join Time</th>
                        <th>Leave Time</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($fleet->participants as $participant)
                        <tr>
                            <td>{{ $participant->character->name }}</td>
                            <td>{{ $participant->ship_type_id }}</td>
                            <td>{{ $participant->join_time->format('Y-m-d H:i') }}</td>
                            <td>{{ $participant->leave_time ? $participant->leave_time->format('Y-m-d H:i') : 'Still Active' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @if($fleet->status === 'active')
        <div class="card mt-4">
            <div class="card-header">
                <h3 class="card-title">Join Fleet</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('fleettracking.fleet.join', $fleet->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="ship_type_id">Ship Type ID</label>
                        <input type="number" class="form-control" id="ship_type_id" name="ship_type_id" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Join Fleet</button>
                </form>
            </div>
        </div>
    @endif
@endsection