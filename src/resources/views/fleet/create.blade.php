@extends('web::layouts.grids.12')

@section('title', 'Create Fleet')
@section('page_header', 'Create New Fleet')

@section('full')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Create Fleet</h3>
        </div>
        <form action="{{ route('fleettracking.fleet.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Fleet Name</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="fc_id">Fleet Commander</label>
                    <select name="fc_id" id="fc_id" class="form-control" required>
                        @foreach($fcSquads as $squad)
                            <optgroup label="{{ $squad->name }}">
                                @foreach($squad->users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="start_time">Start Time</label>
                    <input type="datetime-local" name="start_time" id="start_time" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="location">Location</label>
                    <input type="text" name="location" id="location" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="doctrine">Doctrine</label>
                    <input type="text" name="doctrine" id="doctrine" class="form-control">
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Create Fleet</button>
            </div>
        </form>
    </div>
@endsection