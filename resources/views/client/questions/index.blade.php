<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Questions Eleveur') }}
            </h2>
            <!-- <a href="{{route('admin.questions.create')}}" type="button" class="rounded-md bg-indigo-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Ajouter Question</a> -->
        </div>
    </x-slot>
    @php
    $i=0;
    @endphp
    <div class="pt-2 pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($message = Session::get('success'))
            <div id="successMessage" class="rounded-md bg-green-50 p-4 mb-6 shadow">
                <div class="ml-3">
                <h3 class="text-sm font-medium text-green-800">{{$message}}</h3>
                </div>
            </div>
            @endif
            @foreach ($questions as $question)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mt-6">
                <div class="px-4 sm:px-6 lg:px-8">
                    <div>
                        <label for="text" class="block text-md font-medium leading-6 text-gray-900">
                        {{$i= $i+1}}. {{$question->text}}
                        </label>
                        <div class="mt-2">
                            @if($question->type == 'text')
                                <input type="text" name="{{$question->id}}" id="{{$question->id}}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Votre réponse" />
                            @elseif($question->type == 'number')
                                <input type="number" name="{{$question->id}}" id="{{$question->id}}" class="block w-1/4 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Votre réponse" />
                            @elseif($question->type == 'checkbox')
                                @foreach($question->choices as $choice)
                                <div class="relative flex items-start mt-2">
                                    <div class="flex h-6 items-center">
                                        <input id="required" value='1' aria-describedby="comments-description" name="required" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600" />
                                    </div>
                                    <div class="ml-3 text-sm leading-6">
                                        <label for="required" class="font-medium text-gray-900">{{$choice->value}}</label>
                                    </div>
                                </div>
                                @endforeach
                            @elseif($question->type == 'radio')
                                @foreach($question->choices as $choice)
                                <div class="space-y-4">
                                    <div class="flex items-center">
                                    <input
                                        id="{{$question->id}}"
                                        name="{{$question->id}}"
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
                            <div class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10">
                                <div class="text-center">
                                <x-heroicon-o-paper-clip class="mx-auto h-12 w-12 text-gray-600"/>
                            
                                <div class="mt-4 flex text-sm leading-6 text-gray-600">
                                    <label
                                    for="file-upload"
                                    class="relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-indigo-500"
                                    >
                                    <span>Télécharger un fuchier</span>
                                    <input id="file-upload" name="file-upload" type="file" class="sr-only" />
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
        </div>
    </div>
</x-app-layout>
<script>
    setTimeout(() => {
        const successMessage = document.getElementById('successMessage');
        successMessage.style.display = 'none';
    }, 2000);
</script>