@extends('web::layouts.grids.12')

@section('title', 'Edit Fleet')
@section('page_header', 'Edit Fleet: ' . $fleet->name)

@section('full')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Edit Fleet</h3>
        </div>
        <form action="{{ route('fleettracking.fleet.update', $fleet->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Fleet Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ $fleet->name }}" required>
                </div>
                <div class="form-group">
                    <label for="fc_id">Fleet Commander</label>
                    <select name="fc_id" id="fc_id" class="form-control" required>
                        @foreach($fcSquads as $squad)
                            <optgroup label="{{ $squad->name }}">
                                @foreach($squad->users as $user)
                                    <option value="{{ $user->id }}" {{ $fleet->fc_id == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="start_time">Start Time</label>
                    <input type="datetime-local" name="start_time" id="start_time" class="form-control" 
                           value="{{ $fleet->start_time->format('Y-m-d\TH:i') }}" required>
                </div>
                <div class="form-group">
                    <label for="end_time">End Time</label>
                    <input type="datetime-local" name="end_time" id="end_time" class="form-control" 
                           value="{{ $fleet->end_time ? $fleet->end_time->format('Y-m-d\TH:i') : '' }}">
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="active" {{ $fleet->status == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ $fleet->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="completed" {{ $fleet->status == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="location">Location</label>
                    <input type="text" name="location" id="location" class="form-control" value="{{ $fleet->location }}" required>
                </div>
                <div class="form-group">
                    <label for="doctrine">Doctrine</label>
                    <input type="text" name="doctrine" id="doctrine" class="form-control" value="{{ $fleet->doctrine }}">
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update Fleet</button>
            </div>
        </form>
    </div>
@endsection