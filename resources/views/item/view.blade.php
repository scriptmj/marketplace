<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Item details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Content -->
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    @if($item->sold)
                        <div class="px-4 py-5 sm:px-6 bg-green-100">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                <strong>Sold</strong> for €{{number_format($item->getHighestBid()->price, 2)}} to {{$item->getHighestBid()->user->name}} on {{$item->marked_as_sold}}.
                            </h3>
                        </div>
                    @endif
                        <div class="px-4 py-5 sm:px-6">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                            {{ucfirst($item->item_name)}}
                            </h3>
                        </div>
                        <div class="border-t border-gray-200">
                            <dl>

                            <img src="{{$item->image}}" width="600px">

                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">
                                    Sold by
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    <a href="{{route('profile.view', $item->user)}}" class="text-indigo-600 hover:text-indigo-900">
                                        {{$item->user->name}}
                                    </a>
                                </dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">
                                    Description
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{$item->long_description}}
                                </dd>
                            </div>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">
                                    Current highest bid
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    €{{number_format($item->getHighestBidNumeric(), 2)}} 
                                    @if($item->getHighestBid() != null)
                                        by 
                                        <a href="{{route('profile.view', $item->getHighestBid()->user)}}">
                                            {{$item->getHighestBid()->user->name}}
                                        </a>
                                    @endif
                                </dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">
                                    Minimum bid
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    €{{number_format($item->minimum_bid, 2)}}
                                </dd>
                            </div>

                            
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">
                                Actions
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                
                                @if(Auth::user() && !Auth::user()->isOwner($item))
                                <a class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                href="">
                                    Message seller
                                </a>
                                <a class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                href="{{route('item.makebid', $item)}}">
                                    Make offer
                                </a>

                                @elseif(Auth::user() && Auth::user()->isOwner($item))
                                <a class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                href="{{route('item.edit', $item)}}">
                                    Edit
                                </a>
                                <a class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                href="{{route('item.markassold', $item)}}">
                                    Mark as sold
                                </a>

                                @elseif(!Auth::user())
                                <a class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                href="{{route('login')}}">
                                    Login to make an offer
                                </a>
                                @endif

                                </dd>
                            </div>
                            @if(Auth::user() && Auth::user()->isOwner($item))
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">
                                Current bids
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">

                                @if(count($item->offers) > 0)
                                <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Price
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        User
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Time
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Message
                                    </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($item->offersOrdered() as $offer)

                                    <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        €{{number_format($offer->price, 2)}}
                                    </td>                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <a href="{{route('profile.view', $offer->user)}}">
                                        {{$offer->user->name}}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{$offer->created_at}}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <a href="">
                                        Send message
                                        </a>
                                    </td>
                                    </tr>

                                    @endforeach
                                </tbody>
                                </table>
                                

                                @else
                                <p>No bids found</p>
                                @endif
                                </dd>
                            </div>
                            @endif
                            </dl>
                        </div>
                        </div>
                    <!-- End content -->
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
