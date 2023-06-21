<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Mes Lots
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

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4">
                <a href="{{ route('lots.create') }}" class="w-full bg-white p-10 flex justify-center items-center shadow-lg rounded-lg hover:shadow-sm">
                    <div class="bg-green-900 text-white p-4 rounded-full">    
                        <x-heroicon-o-plus class="w-12" />
                    </div>
                </a>
                @foreach ($lots as $lot)
                    <div class="w-full p-4 bg-white shadow-sm rounded-lg">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-semibold text-lg">N° {{ $lot->num }}</h3>
                                <p class="text-xs font-normal text-gray-600"> Créé le {{ substr($lot->created_at, 0, 10) }}</p>
                            </div>
                            @if($lot->in_progress == false && $lot->admin_valid == false)
                            <a href="" class="" ><x-heroicon-m-chat-bubble-left-ellipsis class="w-8 text-orange-700" /></a>
                            @else
                            <x-heroicon-s-clipboard-document class="w-8 text-green-800"/>
                            @endif
                        </div>
                        <p class="text-base font-semibold text-gray-800 mt-2 mb-1">Validations</p>
                        <div class="flex space-x-2 items-center ml-6">
                            <p class="text-base text-gray-800">Qualim :</p>
                            @if($lot->in_progress)
                                <p class="text-sm font-semibold text-indigo-800">En progrès ...</p>
                            @elseif($lot->admin_valid)
                                <p class="text-sm font-semibold text-green-700">Validé</p>
                            @else
                                <p class="text-sm font-semibold text-red-700">Rejeté</p>
                            @endif
                        </div>
                        @if($lot->in_progress == false && $lot->admin_valid)
                            @foreach($lot->destinations as $destination)
                            <div class="flex space-x-2 items-center ml-6">
                                <p class="text-base text-gray-800">{{ $destination->firstname }} {{ $destination->lastname }} :</p>
                                @if($destination->in_progress)
                                    <p class="text-sm font-semibold text-indigo-800">En progrès ...</p>
                                @elseif($destination->valid)
                                    <p class="text-sm font-semibold text-green-700">Validé</p>
                                @else
                                    <p class="text-sm font-semibold text-red-700">Rejeté</p>
                                @endif
                            </div>
                            @endforeach
                        @endif
                        @if (Auth::user()->role == 'collecteur' || Auth::user()->role == 'industrie')
                            
                            @if($lot->childLots && $lot->childLots->count() > 0)
                                <p class="text-base font-semibold text-gray-800 mt-2 mb-2">Lots Validés</p>
                                @foreach($lot->childLots as $childLot)
                                    @php 
                                    $childOwner = App\Models\User::find($childLot->owner); 
                                    @endphp
                                    <div class="ml-6 mb-2 flex items-center">
                                        <x-heroicon-s-check-badge class="w-5 text-green-700" />
                                        <p class="ml-1 text-sm text-gray-800">{{$childOwner->firstname}} {{$childOwner->lastname}} ({{$childLot->num}})</p>
                                    </div>
                                @endforeach
                            @endif
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>