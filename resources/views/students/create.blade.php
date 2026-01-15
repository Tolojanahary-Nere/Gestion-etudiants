@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-12 col-md-6 offset-md-3">
            <h3>Création d'un étudiant</h3>
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show " role="alert">
                <strong>Success!</strong> {{ session('success') }}.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            
            <div class="card bg-dark text-white mt-4">
                <div class="card-body border border-light rounded">
                    <form action="{{route('students.store')}}" method="POST">
                    @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nom</label>
                            <input type="text" class="form-control bg-dark text-white" 
                                id="name" name="name" value="{{old('name')}}" @error('name') is-invalid @enderror required>
                            @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control bg-dark text-white" id="email"
                            name="email" value="{{old('email')}}" @error('email') is-invalid @enderror required>
                            @error('email')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Téléphone</label>
                            <input type="number" class="form-control bg-dark text-white" id="phone"
                            name="phone" value="{{old('phone')}}" @error('phone') is-invalid @enderror required>
                            @error('phone')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Adresse</label>
                            <input type="text" class="form-control bg-dark text-white"
                            id="address" name="address" value="{{old('address')}}" @error('address') is-invalid @enderror required>
                            @error('address')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-grid"> <!-- Added d-grid for full width button on mobile if needed, or just nicer -->
                            <button type="submit" class="btn btn-success">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>  
    </div>
</div>
@endsection