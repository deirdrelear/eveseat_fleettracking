@extends('web::layouts.grids.12')

@section('title', 'Fleet Tracking')
@section('page_header', 'Fleet List')

@section('full')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Active Fleets</h3>
            @can('create', drlear\FleetTracking\Models\Fleet::class)
                <div class="card-tools">
                    <a href="{{ route('fleettracking.fleet.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Create New Fleet
                    </a>
                </div>
            @endcan
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>FC</th>
                        <th>Start Time</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($fleets as $fleet)
                        <tr>
                            <td>{{ $fleet->name }}</td>
                            <td>{{ $fleet->commander->name }}</td>
                            <td>{{ $fleet->start_time->format('Y-m-d H:i') }}</td>
                            <td>{{ ucfirst($fleet->status) }}</td>
                            <td>
                                <a href="{{ route('fleettracking.fleet.show', $fleet->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                @can('update', $fleet)
                                    <a href="{{ route('fleettracking.fleet.edit', $fleet->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $fleets->links() }}
        </div>
    </div>
@endsection
