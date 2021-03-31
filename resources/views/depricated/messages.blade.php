<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Messages') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Content -->
                    <div class="flex flex-col">
                        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        From
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Item
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Message
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Time
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Read
                                    </th>
                                    </tr>
                                </thead>
                                
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($messages as $message)
                                    <tr class="bg-white">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{$message->fromUser->name}}
                                        </td>  
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($message->item)
                                            <a href="" class="text-indigo-600 hover:text-indigo-900">
                                            {{ucfirst($message->item->item_name)}}
                                            </a>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{$message->message}}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{$message->created_at}}
                                        </td>                                    
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{$message->read}}
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                    No messages
                                    </tr>
                                    @endforelse
                                    <!-- More items... -->
                                </tbody>
                                </table>
                            </div>
                            </div>
                        </div>
                        </div>
                    
                    
                    <!-- End content -->
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
