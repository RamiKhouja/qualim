<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Choix') }}
        </h2>
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 columns-2">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('admin.choices.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                    <div class="flex flex-row justify-between items-end">
                        <div class="w-3/4">
                            <label for="text" class="block text-sm font-medium leading-6 text-gray-900">Ajouter Choix</label>
                            <div class="mt-2">
                                <input type="text" name="value" id="value" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Insérez un choix" />
                                <input type="hidden" name="question_id" id="question_id" value="{{ (int)Route::current()->parameter('question_id') }}" />
                            </div>
                        </div>
                        <button type="submit" class="rounded-md bg-indigo-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Ajouter</button>
                    </div>
                </form>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <ul role="list" class="divide-y divide-gray-100">
                @foreach ($choices as $choice)
                <li class="relative flex justify-between gap-x-4 py-4">
                    <div class="flex gap-x-4">
                        <p class="text-sm font-semibold leading-6 text-gray-900">
                            {{$choice->value}}
                        </p>
                    </div>
                    <div class="flex items-center gap-x-4">
                        <p>edit</p>
                    </div>
                    </li>
                    
                @endforeach
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
