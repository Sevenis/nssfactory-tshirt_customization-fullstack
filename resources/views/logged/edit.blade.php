@extends('layouts.app')
@section('content')

<div class="container-center create-update">
    <div class="card-container">
        <h2>Modifica il tuo nuovo look!</h2>

        <form id="creazione" action="{{ route('user.update', $project->id) }}" name="creazione" method="POST" enctype="multipart/form-data">
            @csrf
            @method("PATCH")
        <div class="input-row">
            {{-- <label for="title">Modifica il nome del tuo nuovo progetto!</label> --}}
            <input type="text" id="titolo" name="title" minlength="6" value= "{{ $project->title }}" required>

            <input type="submit" name="upload" value="Conferma!" class="btn text-light bg-dark">
        </div>
        {{-- Sezione con i modelli di T-Shirt & Logo --}}
        <div class="shirt-factory">
            <div class="models-container">
                <div class="tshirt-panel">
                    <p>Scegli T-Shirt & Logo</p>
                    @foreach($shirts as $shirt)
                        <div class="box">
                            <img class="shirtImg" src="{{ asset('img/tshirts' . '/' . $shirt['type']) }}" alt="{{ $shirt['type'] }}">
                        </div>
                    @endforeach
                </div>

                <div class="logo-panel">
                    {{-- <p>Scegli il tuo logo</p> --}}
                    @foreach($logos as $logo)
                        <div class="box">
                            <img class="logoImg" src="{{ asset('img/logos' . '/' . $logo['type']) }}" alt="{{ $logo['type'] }}">
                        </div>
                    @endforeach
                </div>
            </div>

            <hr class="linea">
            {{-- Vetrina PREVIEW PROGEETTO --}}
            <div class="preview-container">
                <div class="tshirt-chosen">
                    <img src="{{ asset('img/tshirts' . '/' . $project->tshirt) }}" alt="">
                </div>
                <div class="logo-chosen">
                    <img src="{{ asset('img/logos' . '/' . $project->logo) }}" alt="">
                </div>
            </div>

            {{-- Campi HIDDEN --}}
            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
            <input type="hidden" id ="pj-tshirt" name="tshirt" value="{{ $shirt['type'] }}" required>
            <input type="hidden" id ="pj-logo" name="logo" value="{{ $logo['type'] }}" required>
        </form>
    </div>
</div>
@endsection
