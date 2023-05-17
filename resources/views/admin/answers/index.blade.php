<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Réponses') }}
            </h2>
            <!-- <a href="{{route('admin.questions.create')}}" type="button" class="rounded-md bg-indigo-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Ajouter Question</a> -->
        </div>
    </x-slot>
    @php
    $i=0;
    $count=0;
    @endphp
    <div class="pb-12" id="content">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($message = Session::get('success'))
            <div id="successMessage" class="rounded-md bg-green-50 p-4 mb-6 shadow">
                <div class="ml-3">
                <h3 class="text-sm font-medium text-green-800">{{$message}}</h3>
                </div>
            </div>
            @endif
            @foreach ($answers as $userId => $userAnswers)
            @if($userAnswers[0]->user->in_progress == true)
            @php
            $count = $count + 1;
            @endphp
            <div class="bg-white overflow-hidden shadow sm:rounded-lg">
                <div class="p-6 border-b border-b-gray-200 mb-2">
                    <div class="flex items-start gap-x-3">
                        <h3 class="text-lg font-semibold leading-6 text-gray-900">{{ $userAnswers[0]->user->firstname }} {{ $userAnswers[0]->user->lastname }}</h3>
                        <p class="rounded-md bg-indigo-100 text-indigo-600 mt-0.5 px-1.5 py-0.5 text-xs font-medium">
                         {{ $userAnswers[0]->question->role }}
                        </p>
                    </div>
                    <p class="mt-1 text-sm text-gray-500">
                    {{ $userAnswers[0]->user->email }}
                    </p>
                </div>
                <div class="px-6 pb-6">
                <ul role="list" class="divide-y divide-gray-100">
                @foreach ($userAnswers as $answer)
                    <li class="flex items-center justify-between gap-x-6 py-3">
                        <div class="min-w-0">
                            <p class="text-sm leading-6 font-semibold text-gray-900">{{$i= $i+1}}. {{ $answer->question->text }}</p>
                            <p class="mt-2 px-4 text-sm leading-5 text-gray-700">
                            {{ $answer->answer }}
                            </p>
                        </div>
                        <div class="flex flex-none items-center gap-x-4">
                            @if($answer->inspected == false)
                                <form action="{{ route('admin.answers.update', ['answer' => $answer->id]) }}" method="POST" enctype="multipart/form-data">
                                @csrf    
                                @method('PUT')
                                    <input type="hidden" name="inspected" value="1" />
                                    <input type="hidden" name="valid" value="1" />
                                    <button type="submit" class="rounded-md bg-white border border-green-800 px-2.5 py-1.5 text-sm font-semibold text-green-900 shadow-sm hover:bg-green-100 sm:block">Valide</button>
                                </form>
                                <button onclick="openModal('{{ $answer->id }}')"
                                    class="hidden rounded-md bg-white border border-red-800 px-2.5 py-1.5 text-sm font-semibold text-red-900 shadow-sm hover:bg-red-100 sm:block"
                                >Invalide</button>
                            @elseif($answer->valid)
                                <p class="rounded-md bg-green-100 text-green-900 px-2 py-1 text-sm">Validé</p>
                            @else
                                <p class="rounded-md bg-red-100 text-red-900 px-2 py-1 text-sm">A revoir</p>
                            @endif
                        </div>
                    </li>
                @endforeach
                </ul>
                </div>
                <form action="{{ route('admin.answers.users.update', ['user' => $userAnswers[0]->user->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="flex flex-row-reverse p-6">
                        <button type="submit" name="accept" value="true" 
                            class="ml-6 rounded-md bg-indigo-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Accepter</button>
                        <button type="submit" name="reject" value="true" 
                            class="rounded-md bg-white border border-indigo-600 px-2.5 py-1.5 text-sm font-semibold text-indigo-600 shadow-sm hover:bg-gray-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Refuser</button>
                    </div>
                </form>
            </div>
            @endif
            @endforeach
            
            @if($count == 0)
            <div class="text-center">
                <x-heroicon-m-exclamation-triangle class="mx-auto h-12 w-12 text-gray-500"/>
                <h3 class="mt-2 text-base font-semibold text-gray-900">Pas de réponses</h3>
                <p class="mt-1 text-base text-gray-500">Aucune réponse n'a été encore envoyée.</p>
            </div>
            @endif
        </div>
    </div>
    <div class="fixed z-10 inset-0 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="myModal">
    <!-- <div id="myModal" class="hidden fixed z-10 inset-0 overflow-y-auto shadow-2xl"> -->
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="bg-white rounded p-8">
                <!-- Modal content -->
                <h2 class="mb-2 text-base font-semibold text-gray-900">Réponse Incorrecte</h2>
                <form action="{{ route('admin.answers.update', ['answer' => 'answerId']) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="valid" value="0">
                    <input type="hidden" name="inspected" value="1">
                    <input type="text" name="validation_text" class="border rounded w-full mb-4" placeholder="Texte de valdation">
                    <button type="submit" class="rounded-md bg-indigo-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Envoyer</button>
                    <button type="button" class="ml-6 rounded-md bg-white border border-indigo-600 px-2.5 py-1.5 text-sm font-semibold text-indigo-600 shadow-sm hover:bg-gray-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" onclick="closeModal()">Close</button>
                </form>
            </div>
        </div>
    </div>

<script>

    function openModal(answerId) {
        const modal = document.getElementById('myModal');
        const form = modal.querySelector('form');
        form.action = form.action.replace('answerId', answerId);
        const content = document.getElementById('content');
        content.classList.add('hidden');
        modal.classList.remove('hidden');
    }

    function closeModal() {
        const modal = document.getElementById('myModal');
        modal.classList.add('hidden');
        const content = document.getElementById('content');
        content.classList.remove('hidden');
    }

    setTimeout(() => {
        const successMessage = document.getElementById('successMessage');
        successMessage.style.display = 'none';
    }, 2000);

</script>
</x-app-layout>