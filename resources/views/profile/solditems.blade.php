<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Items sold') }}
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
                                        Name
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Sold for
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        To
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        On
                                    </th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">See more</span>
                                    </th>
                                    </tr>
                                </thead>
                                
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($items as $item)
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                            <div class="flex-shrink-0 h-20 w-20">
                                                <img class="h-20 w-20" src="{{$item->image}}" alt="">
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                <a href="{{route('item.view', $item)}}" class="text-indigo-600 hover:text-indigo-900">{{ucfirst($item->item_name)}}</a>
                                                </div>
                                            </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{$item->highestBidFormatted()}}
                                        </td>                                    
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <!-- TODO -->
                                            {{$item->getHighestBid()->user->name}}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{$item->times_viewed}}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{route('item.view', $item)}}" class="text-indigo-600 hover:text-indigo-900">View more</a><br />
                                        </td>
                                    </tr>
                                        @empty
                                        <tr>
                                        <td>No items posted.</td>
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