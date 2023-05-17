<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Questions') }}
            </h2>
            <a href="{{route('admin.questions.create')}}" type="button" class="rounded-md bg-indigo-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Ajouter Question</a>
        </div>
    </x-slot>
    <!-- @if(Auth::user()->role != 'admin')
    @php return redirect()->route('questions')->with('success','You shall not pass'); @endphp
    @endif -->
    <div class="pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($message = Session::get('success'))
            <div id="successMessage" class="rounded-md bg-green-50 p-4 mb-6 shadow">
                <div class="ml-3">
                <h3 class="text-sm font-medium text-green-800">{{$message}}</h3>
                </div>
            </div>
            @endif
            <div class="md:columns-2 md:gap-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="px-4 sm:px-6 lg:px-8">
                        <h1 class="text-base font-semibold leading-6 text-gray-900">Questions Eleveur</h1>
                        <p class="mt-2 text-sm text-gray-600">
                            La liste des questions de l'éleveur.
                        </p>
                        <div class="mt-8 flow-root">
                        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                            <table class="min-w-full divide-y divide-gray-300">
                                <thead>
                                <tr>
                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Ordre</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Question</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Type</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Required</th>
                                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                    <span class="sr-only">Edit</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                @foreach ($questions as $question)
                                <tr>
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">{{ $question->order }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $question->text }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $question->type }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $question->required ? "Oui" : "Non" }}</td>
                                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                        <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="mt-6">
                    {{ $questions->links() }}
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mt-8 md:mt-0">
                    <div class="px-4 sm:px-6 lg:px-8">
                        <h1 class="text-base font-semibold leading-6 text-gray-900">Questions Collecteur</h1>
                        <p class="mt-2 text-sm text-gray-600">
                            La liste des questions du collecteur.
                        </p>
                        <div class="mt-8 flow-root">
                        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                            <table class="min-w-full divide-y divide-gray-300">
                                <thead>
                                <tr>
                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Ordre</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Question</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Type</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Required</th>
                                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                    <span class="sr-only">Edit</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                @foreach ($colquests as $colquest)
                                <tr>
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">{{ $colquest->order }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $colquest->text }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $colquest->type }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $colquest->required ? "Oui" : "Non" }}</td>
                                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                        <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="mt-6">
                    {{ $colquests->links() }}
                    </div>
                </div>
            </div>
            <div class="md:columns-2 md:gap-8 mt-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="px-4 sm:px-6 lg:px-8">
                        <h1 class="text-base font-semibold leading-6 text-gray-900">Questions Industrie</h1>
                        <p class="mt-2 text-sm text-gray-600">
                            La liste des questions de l'industrie.
                        </p>
                        <div class="mt-8 flow-root">
                        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                            <table class="min-w-full divide-y divide-gray-300">
                                <thead>
                                <tr>
                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Ordre</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Question</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Type</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Required</th>
                                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                    <span class="sr-only">Edit</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                @foreach ($indquests as $indquest)
                                <tr>
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">{{ $indquest->order }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $indquest->text }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $indquest->type }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $indquest->required ? "Oui" : "Non" }}</td>
                                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                        <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="mt-6">
                    {{ $indquests->links() }}
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mt-8 md:mt-0">
                    <div class="px-4 sm:px-6 lg:px-8">
                        <h1 class="text-base font-semibold leading-6 text-gray-900">Questions Distributeur</h1>
                        <p class="mt-2 text-sm text-gray-600">
                            La liste des questions du distributeur.
                        </p>
                        <div class="mt-8 flow-root">
                        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                            <table class="min-w-full divide-y divide-gray-300">
                                <thead>
                                <tr>
                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Ordre</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Question</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Type</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Required</th>
                                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                    <span class="sr-only">Edit</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                @foreach ($disquests as $disquest)
                                <tr>
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">{{ $disquest->order }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $disquest->text }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $disquest->type }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $disquest->required ? "Oui" : "Non" }}</td>
                                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                        <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                            </div>
                        </div>
                        </div>
                    </div>
                    <!-- <div class="mt-6">
                    {{ $disquests->links() }}
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    setTimeout(() => {
        const successMessage = document.getElementById('successMessage');
        successMessage.style.display = 'none';
    }, 2000);
</script>