@extends('template.template')

@section('main-content')
    {{-- Content 1 --}}
    <div class="row">
        <div class="col-12 mt-4">
            <div class="card">
                <div class="card-header">
                    Form {{ request()->routeIs('person.edit') ? 'Ubah' : 'Tambah' }} Data
                </div>
                <div class="card-body">
                    <form action="{{ isset($familyTree) ? route('person.update', $familyTree->id) : route('person.add') }}"
                        method="POST">
                        @csrf
                        @if (isset($familyTree))
                            {{ method_field('patch') }}
                        @endif
                        {{-- Input Name --}}
                        <div class="form-group">
                            <label for="formGroupName">Name</label>
                            <input type="text" class="form-control mt-2 {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                id="formGroupName" placeholder="Insert Name" name="name"
                                value="{{ old('name', isset($familyTree) ? $familyTree->name : '') }}">
                            <div class="invalid-feedback">
                                @error('name')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>

                        {{-- Input Birthdate --}}
                        <div class="form-group mt-2">
                            <label for="formGroupBirthDate">Birthdate</label>
                            <input type="date" class="form-control mt-2" id="formGroupBirthDate"
                                placeholder="Another input" name="birth_date"
                                value="{{ old('name', isset($familyTree) ? $familyTree->birth_date : '') }}">
                        </div>

                        {{-- input Gender --}}
                        <div class="form-group mt-2">
                            <label for="formGroupGender">Gender</label>
                            <div class="form-check">
                                <input class="form-check-input mt-2" type="radio" name="gender"
                                    id="formGroupGender gender1" value="male"
                                    {{ old('gender') == 'male' || (isset($familyTree) && $familyTree->gender == 'male') ? 'checked' : '' }}>
                                <label class="form-check-label mt-2" for="gender1">Male</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input mt-2" type="radio" name="gender"
                                    id="formGroupGender gender2" value="female"
                                    {{ old('gender') == 'female' || (isset($familyTree) && $familyTree->gender == 'female') ? 'checked' : '' }}>
                                <label class="form-check-label mt-2" for="gender2">Female</label>
                            </div>
                        </div>

                        {{-- Input Parent Name --}}
                        <div class="form-group mt-2">
                            <label for="formGroupExampleInput2">Parent Name</label>
                            <select class="form-select mt-2 {{ $errors->has('parent_id') ? 'is-invalid' : '' }}"
                                aria-label="Default select example" name="parent_id">
                                <option value="">-- Select Parent Name --</option>
                                <option value="-"
                                    {{ old('parent_id') == '-' || (isset($familyTree) && $familyTree->parent_id == null) ? 'selected' : '' }}>
                                    None </option>
                                @foreach ($listNames as $listName)
                                    <option value="{{ $listName->id }}"
                                        {{ old('parent_id', isset($familyTree) ? $familyTree->parent_id : '') == $listName->id ? 'selected' : '' }}>

                                        {{ Str::ucfirst($listName->name) }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                @error('parent_id')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-2">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div>
    <script>
        @if (!isset($familyTree))
            document.getElementById('formGroupBirthDate').valueAsDate = new Date();
        @endif
    </script>
@endsection
