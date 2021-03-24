<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Your bids') }}
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
                                        Item
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Your bid
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Highest bid
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Time
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Cancel bid
                                    </th>
                                    </tr>
                                </thead>
                                
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($offers as $offer)
                                    @if($offer->isHighestOffer())
                                    <tr class="bg-green-50">
                                    @else
                                    <tr class="bg-grey-50">
                                    @endif
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ucfirst($offer->item->item_name)}}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{$offer->price}}
                                        </td>                                    
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            @if($offer->isHighestOffer())
                                            Yes
                                            @else
                                            No
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{$offer->created_at}}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <a href="{{route('user.cancelbid', $offer)}}">
                                            Cancel bid
                                            </a>
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
