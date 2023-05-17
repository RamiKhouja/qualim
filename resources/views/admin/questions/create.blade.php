<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nouvelle Question') }}
        </h2>
    </x-slot>

    <div class="pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('admin.questions.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                    <div>
                        <label for="text" class="block text-sm font-medium leading-6 text-gray-900">Question</label>
                        <div class="mt-2">
                            <input type="text" name="text" id="text" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Votre question" />
                        </div>
                    </div>
                    <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                        <div class="sm:col-span-3">
                            <label for="type" class="block text-sm font-medium leading-6 text-gray-900">Type</label>
                            <select id="type" name="type" class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                <option value="text">Texte</option>
                                <option value="longtext">Paragraphe</option>
                                <option value="number">Nombre</option>
                                <option value="file">Fichier</option>
                                <option value="date">Date</option>
                                <option value="radio">Choix Unique</option>
                                <option value="checkbox">Choix Multiple</option>
                            </select>
                        </div>
                        <div class="sm:col-span-3">
                            <label for="role" class="block text-sm font-medium leading-6 text-gray-900">Niveau</label>
                            <select id="role" name="role" class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                <option value="eleveur">Eleveur</option>
                                <option value="collecteur">Collecteur</option>
                                <option value="industrie">Industrie</option>
                                <option value="distributeur">Distributeur</option>
                            </select>
                        </div>
                    </div>
                    <div class="relative flex items-start mt-6">
                        <div class="flex h-6 items-center">
                            <input id="required" value='1' aria-describedby="comments-description" name="required" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600" />
                        </div>
                        <div class="ml-3 text-sm leading-6">
                            <label for="required" class="font-medium text-gray-900">Required</label>
                            <p id="required-description" class="text-gray-500">Une fois coché, l'utilisateur doit répondre à la question afin de passer.</p>
                        </div>
                    </div>
                    <!-- <div class="relative flex items-start mt-6">
                        <div class="flex h-6 items-center">
                            <input id="show" aria-describedby="comments-description" name="show" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600" />
                        </div>
                        <div class="ml-3 text-sm leading-6">
                            <label for="show" class="font-medium text-gray-900">Afficher</label>
                            <p id="show-description" class="text-gray-500">La question sera affichée dans la forme.</p>
                        </div>
                    </div> -->
                    <div class="mt-6 flex flex-row items-center">
                        <label for="order" class="block text-sm font-medium leading-6 text-gray-900">Ordre</label>
                        <input type="number" min="1" max="10" name="order" id="order" class="block w-16 ml-4 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="1" value="1" />
                    </div>
                    <div class="mt-6 flex flex-row-reverse">
                        <button type="submit" class="rounded-md bg-indigo-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
