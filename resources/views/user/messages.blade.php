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
                                            Last message
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Time
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            View
                                        </th>
                                    </tr>
                                </thead>
                                
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($userInteractions as $user)
                                    @if($user->lastMessage->fromUser->id != Auth::user()->id && !$user->lastMessage->read)
                                    <tr class="bg-green-50">
                                    @else
                                    <tr class="bg-white">
                                    @endif
                                        @if($user->lastMessage->fromUser->id != Auth::user()->id)
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            
                                                <a href="{{route('profile.view', $user)}}">
                                                {{$user->name}}
                                                </a>
                                            </td>  
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                <strong>They said:</strong> {{$user->lastMessage->message}}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{$user->lastMessage->created_at}}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                <a href="{{route('message.view', $user)}}"
                                                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    View message history.
                                                </a>
                                            </td>
                                        @else
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                <a href="{{route('profile.view', $user)}}">
                                                {{$user->name}}
                                                </a>
                                            </td>  
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <strong>You said:</strong> {{$user->lastMessage->message}}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{$user->lastMessage->created_at}}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                <a href="{{route('message.view', $user)}}" 
                                                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    View message history.
                                                </a>
                                            </td>
                                        @endif
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
