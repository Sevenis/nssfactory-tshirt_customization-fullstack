@extends('layouts.app')
@section('content')

<div class="container-center create-update">
    <div class="card-container">
        <h2>Crea il tuo nuovo look!</h2>

        <form id="creazione" action="{{ route('user.store') }}" name="creazione" method="POST" enctype="multipart/form-data">
            @csrf
            @method("POST")
            <div class="input-row">
                {{-- <label for="title">Progetto: </label> --}}
                <input type="text" id="title" name="title" minlength="6" placeholder="Dai un nome al tuo fantastico progetto..." required>

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
                {{-- Vetrina PREVIEW PROGETTO --}}
                <div class="preview-container">
                    <div class="tshirt-chosen">
                        <img class="shirt-prev" src="{{ asset('img/tshirts' . '/' . $shirt['type']) }}" alt="{{ $shirt['type'] }}">
                        </div>
                    <div class="logo-chosen">
                        <img class="logo-prev" src="{{ asset('img/logos' . '/' . $logo['type']) }}" alt="{{ $logo['type'] }}">
                    </div>
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
