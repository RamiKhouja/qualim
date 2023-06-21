<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Nouveau Lot
            </h2>
            <!-- <a href="{{route('admin.questions.create')}}" type="button" class="rounded-md bg-indigo-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Ajouter Question</a> -->
        </div>
    </x-slot>
    <div class="pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($message = Session::get('success'))
                <div id="successMessage" class="rounded-md bg-green-50 p-4 mb-6 shadow">
                    <div class="ml-3">
                    <h3 class="text-sm font-medium text-green-800">{{$message}}</h3>
                    </div>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mt-6">
            <form action="{{ route('lots.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="px-4 sm:px-6 lg:px-8">
                    <label for="text" class="block text-md font-medium leading-6 text-gray-900">Numéro Lot</label>
                    <div class="mt-2">
                        <input type="number" readonly name="num" value="{{ rand() }}" class="block w-1/4 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                </div>
                @if($destinations != null)
                <div class="px-4 sm:px-6 lg:px-8 mt-8">
                    <label for="role" class="block text-sm font-medium leading-6 text-gray-900">
                        @if(Auth::user()->role == "eleveur")
                            {{ __('Collecteurs') }}
                        @elseif(Auth::user()->role == "collecteur")
                            {{ __('Industries') }}
                        @elseif(Auth::user()->role == "industrie")
                            {{ __('Distributeurs') }}
                        @endif
                    </label>
                    <select multiple id="destinations" name="destinations[]" class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        @foreach($destinations as $user)
                        <option value="{{ $user->id }}" class="mt-2">{{ $user->firstname }} {{ $user->lastname }}</option>
                        @endforeach
                    </select>
                </div>
                @endif
                @if($receivedLots != null)
                <div class="px-4 sm:px-6 lg:px-8 mt-8">
                    <label for="role" class="block text-sm font-medium leading-6 text-gray-900">
                        Lots
                    </label>
                    @foreach($receivedLots as $lot)
                        @php 
                            $owner = App\Models\User::find($lot->owner);
                        @endphp
                        <div>
                        <label class="mt-2 items-center">
                            <input type="checkbox" name="childlots[]" value="{{ $lot->id }}" class="form-checkbox h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <span class="ml-2 text-gray-900">{{ $owner->firstname }} {{ $owner->lastname }} ({{ $lot->num }})</span>
                        </label>
                        </div>
                    @endforeach
                </div>
                @endif
                <div class="px-4 sm:px-6 lg:px-8 mt-8">
                    <button type="submit" class="rounded-md bg-indigo-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Créer</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>