<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                @if(Auth::user()->phase == 1)
                    {{ __('Questions Eleveur') }}
                @elseif(Auth::user()->phase == 2)
                    {{ __('Questions Collecteur') }}
                @elseif(Auth::user()->phase == 3)
                    {{ __('Questions Industrie') }}
                @elseif(Auth::user()->phase == 4)
                    {{ __('Questions Distributeur') }}
                @endif
            </h2>
            <!-- <a href="{{route('admin.questions.create')}}" type="button" class="rounded-md bg-indigo-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Ajouter Question</a> -->
        </div>
    </x-slot>
    @php
    $i=0;
    @endphp
    <div class="pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($message = Session::get('success'))
            <div id="successMessage" class="rounded-md bg-green-50 p-4 mb-6 shadow">
                <div class="ml-3">
                <h3 class="text-sm font-medium text-green-800">{{$message}}</h3>
                </div>
            </div>
            @endif
            @if(Auth::user()->in_progress)
            <div class="text-center">
            <div class="rounded-md bg-white p-4 mb-6 shadow-sm">
                <x-heroicon-m-information-circle class="mx-auto h-12 w-12 text-blue-600"/>
                <h3 class="mt-2 text-base font-semibold text-gray-900">En Attente</h3>
                <p class="mt-1 text-base text-gray-600">Votre réponse est en cours de traitement</p>
            </div>
            </div>
            @else
                <form action="{{ route('answers.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="user_id" value="{{Auth::id()}}" />
                @foreach ($questions as $question)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mt-6">
                    <div class="px-4 sm:px-6 lg:px-8">
                        <div>
                            <label for="text" class="block text-md font-medium leading-6 text-gray-900">
                            {{$i= $i+1}}. {{$question->text}}
                            </label>
                            <div class="mt-2">
                                @if($question->type == 'text')
                                    <input type="text" name="answers[{{ $question->id }}]" id="question_{{$question->id}}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Votre réponse" />
                                @elseif($question->type == 'number')
                                    <input type="number" name="answers[{{ $question->id }}]" id="question_{{$question->id}}" class="block w-1/4 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Votre réponse" />
                                @elseif($question->type == 'date')
                                    <input type="date" name="answers[{{ $question->id }}]" id="question_{{$question->id}}" class="block w-1/4 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Votre réponse" />
                                @elseif($question->type == 'longtext')
                                <textarea
                                    rows={4} name="answers[{{ $question->id }}]" id="question_{{$question->id}}" placeholder="Votre réponse"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                ></textarea>
                                @elseif($question->type == 'checkbox')
                                    @foreach($question->choices as $choice)
                                    <div class="relative flex items-start mt-2">
                                        <div class="flex h-6 items-center">
                                            <input id="question_{{$question->id}}" value="{{$choice->value}}" aria-describedby="comments-description" name="answers[{{ $question->id }}][]" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600" />
                                        </div>
                                        <div class="ml-3 text-sm leading-6">
                                            <label class="font-medium text-gray-900">{{$choice->value}}</label>
                                        </div>
                                    </div>
                                    @endforeach
                                @elseif($question->type == 'radio')
                                    @foreach($question->choices as $choice)
                                    <div class="space-y-4">
                                        <div class="flex items-center">
                                        <input
                                            id="question_{{$question->id}}"
                                            name="answers[{{ $question->id }}]"
                                            value="{{$choice->value}}"
                                            type="radio"
                                            class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600"
                                        />
                                        <label for="{{$choice->id}}" class="ml-3 block text-sm font-medium leading-6 text-gray-900">
                                            {{$choice->value}}
                                        </label>
                                        </div>
                                    </div>
                                    @endforeach
                                @elseif($question->type == 'file')
                                <div class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10 md:w-1/2 lg:w-1/3">
                                    <div class="text-center">
                                    <x-heroicon-o-paper-clip class="mx-auto h-12 w-12 text-gray-600"/>
                                
                                    <div class="mt-4 flex text-sm leading-6 text-gray-600">
                                        <label
                                        for="question_{{$question->id}}"
                                        class="relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-indigo-500"
                                        >
                                        <span>Télécharger un fuchier</span>
                                        <input id="question_{{$question->id}}" name="answers[{{ $question->id }}]" type="file" class="sr-only" />
                                        </label>
                                        <p class="pl-1">ou le faire glisser</p>
                                    </div>
                                    <p class="text-xs leading-5 text-gray-600">PDF, DOC, PNG, JPG ou JPEG </p>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                    <div class="mt-6">
                        <button type="submit" class="rounded-md bg-indigo-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Envoyer</button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</x-app-layout>
<script>
    setTimeout(() => {
        const successMessage = document.getElementById('successMessage');
        successMessage.style.display = 'none';
    }, 2000);
</script>