@extends('template.template')

@section('main-content')
    {{-- Content 1 --}}
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between ">
                        <h5>List of Family</h5>
                        <a href="{{ route('person.create') }}" class="btn btn-success">Tambah Data
                            Orang</a>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="row">
                            <div class="col-12">
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                </div>
                            </div>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="row">
                            <div class="col-12">
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                </div>
                            </div>
                        </div>
                    @endif
                    <table class="table table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Birthdate</th>
                                <th scope="col">Gender</th>
                                <th scope="col">Parent Name</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($familyTrees as $familyTree)
                                <tr class="text-center">
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ Str::ucfirst($familyTree->name) }}</td>
                                    <td>{{ $familyTree->birth_date }}</td>
                                    <td>{{ $familyTree->gender }}</td>
                                    <td>{{ $familyTree->parent->name ?? '-' }}</td>
                                    <td>
                                        <div class="row">
                                            <div class="col-6">
                                                <a
                                                    href="{{ route('person.edit', $familyTree->id) }}"class="btn btn-warning">Edit</a>
                                            </div>
                                            <div class="col-6">
                                                <form action="{{ route('person.delete', $familyTree->id) }}" method="POST"
                                                    onsubmit="return confirm('Apakah Anda Yakin ?');">
                                                    @csrf
                                                    @method('delete')
                                                    <button type='submit' class="btn btn-danger">Hapus</button>
                                                </form>

                                            </div>
                                        </div>
                                    </td>

                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection
