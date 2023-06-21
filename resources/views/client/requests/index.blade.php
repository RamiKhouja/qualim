<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Demandes') }}
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
            @if($answers)
            @foreach ($answers as $lotId => $lotAnswers)
                @php
                    $count = $count + 1;
                    $lot = App\Models\Lot::find($lotId);
                    $owner = App\Models\User::find($lot->owner);
                    $admin_valid = $lot->admin_valid;
                    $lotUser = App\Models\LotUser::where('lot_id', $lotId)
                        ->where('user_id', Auth::id())
                        ->first();
                @endphp
                @if($admin_valid && $lot->owner != Auth::id() && $lotUser->in_progress)
                    <div class="bg-white overflow-hidden shadow sm:rounded-lg mb-8">
                        <div class="p-6 border-b border-b-gray-200 mb-2 flex justify-between">
                            <div>
                                <div class="flex items-start gap-x-3">
                                    <h3 class="text-lg font-semibold leading-6 text-gray-900">{{ $owner->firstname }} {{ $owner->lastname }}</h3>
                                </div>
                                @if($owner->state)
                                <p class="mt-1 text-sm text-gray-500">
                                {{ $owner->city }}, {{ $owner->state }}
                                </p>
                                @endif
                            </div>
                            <p class="text-lg font-semibold text-gray-900">
                                Lot N° {{ $lot->num }}
                            </p>
                        </div>
                        <div class="px-6 pb-6">
                        <ul role="list" class="divide-y divide-gray-100">
                        @foreach ($lotAnswers as $answer)
                            <li class="py-3">
                                <div class="min-w-0">
                                    <p class="text-sm leading-6 font-semibold text-gray-900">{{$i= $i+1}}. {{ $answer->question->text }}</p>
                                    <p class="mt-2 px-4 text-sm leading-5 text-gray-700">
                                    {{ $answer->answer }}
                                    </p>
                                </div>
                            </li>
                        @endforeach
                        </ul>
                        </div>
                        <form action="{{ route('requests.lots.update', ['lot' => $lot->id]) }}" method="POST">
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
            @endif
        </div>
    </div>
</x-app-layout>