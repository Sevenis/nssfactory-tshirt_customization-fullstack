@extends('layouts.app')

@section('content')
    <div class="container-center">
        @if (session('status'))
            <p class="status-msg">{{ session('status') }}</p>
        @endif

        @if (count($projects) > 0)
            <div class="head">
                <h2 class="title">I tuoi progetti</h2>
                <a class="create-project-link" href="{{ route('user.create') }}">Crea un nuovo progetto!</a>
            </div>

            <div class="projects-list">
                @foreach ($projects as $project)
                    <div class="project-info">
                        <div class="project-img">
                            <img src="{{ asset('storage/images/' . $project->user->lastname . $project->id . '/thumbnail.png') }}" alt="">
                        </div>
                        <div class="project-info-dx">
                            <div class="project-title">
                                <p>{{ strlen($project->title) <= 35 ? $project->title : substr($project->title, 0, 30) . '...' }}
                                </p>
                            </div>
                            <div class="project-details">
                                <p class="pj-info"><strong>T-Shirt: </strong> {{ $project->tshirt == 'black.png' ? "Nera" : ($project->tshirt == 'red.png' ? "Rossa" : "Bianca")  }}</p>
                                <p class="pj-info"><strong>Logo: </strong> {{ $project->logo == 'happy.png' ? "Happy Smile" : ($project->logo == 'sad.png' ? "Sad Smile" : "Puzzled Smile")  }}</p>
                                <p class="pj-info"><strong>Created at: </strong> {{ $project->created_at }}</p>
                                @if ($project->user->id != Auth::id())
                                    <p class="owner"><strong>Created by:</strong> {{ $project->user->name . ' ' . $project->user->lastname }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="project-menu">
                            <form action="{{ route('user.destroy', $project->id) }}"
                            method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-delete" type="submit"><i class="fas fa-trash-alt"></i></button>
                            </form>
                            <form action="{{ route('user.edit', $project->id)  }}">
                                <button class="btn btn-edit" type="submit"><i class="fas fa-pencil-alt"></i></button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="head">
                <h2 class="title">Non hai ancora registrato un progetto</h2>
                <a class="create-project-link" href="{{ route('user.create') }}">Crea un nuovo progetto!</a>
            </div>
        @endif


    </div>

@endsection
