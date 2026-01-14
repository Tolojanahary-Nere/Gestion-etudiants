@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-6 offset-3">
            <h3>Modifier un étudiant</h3>
            <div class="card bg-dark text-white mt-4">
                <div class="card-body border border-light rounded">
                    <form action="{{route('students.update', $student->id)}}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="name" class="form-label">Nom</label>
                            <input type="text" class="form-control bg-dark text-white" 
                                id="name" name="name" value="{{old('name', $student->name)}}" @error('name') is-invalid @enderror required>
                            @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control bg-dark text-white" id="email"
                            name="email" value="{{old('email', $student->email)}}" @error('email') is-invalid @enderror required>
                            @error('email')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Téléphone</label>
                            <input type="number" class="form-control bg-dark text-white" id="phone"
                            name="phone" value="{{old('phone', $student->phone)}}" @error('phone') is-invalid @enderror required>
                            @error('phone')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Adresse</label>
                            <input type="text" class="form-control bg-dark text-white"
                            id="address" name="address" value="{{old('address', $student->address)}}" @error('address') is-invalid @enderror required>
                            @error('address')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-warning">Modifier</button>
                        <a href="{{route('students.index')}}" class="btn btn-secondary">Annuler</a>
                    </form>
                </div>
            </div>
        </div>  
    </div>
</div>
@endsection
