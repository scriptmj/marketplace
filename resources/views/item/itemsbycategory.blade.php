@section('content')
<div>
                        @if(isset($contentHeader))
                        {{$contentHeader}}
                        @endif
                        <div class="flex flex-col" id="contentDiv">
                        <div class="my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Name
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Description
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Location
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Minimum bid
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Highest bid
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Times viewed
                                    </th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">See more</span>
                                    </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($items as $item)
                                    @if($item->promoted)
                                    <tr class="bg-green-50">
                                    @else
                                    </tr>
                                    @endif
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
                                    <td class="px-6 py-4 whitespace-normal">
                                        <div class="text-sm text-gray-900">{{$item->short_description}}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-normal text-sm text-gray-900">
                                    {{$item->user->postcode->postcode}}
                                        -
                                        {{$item->user->postcode->woonplaats}}
                                        @if(isset($enteredPostcode))
                                         - 
                                        {{number_format($item->user->postcode->getDistance($enteredPostcode, $item->user->postcode), 1)}}km
                                        @elseif(Auth::user())
                                         - 
                                        {{number_format($item->user->postcode->getDistance(Auth::user()->postcode, $item->user->postcode), 1)}}km
                                        @endif
                                    </td> 
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        €{{number_format($item->minimum_bid, 2)}}
                                    </td>                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{$item->highestBidFormatted()}}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{$item->times_viewed}}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{route('item.view', $item)}}" class="text-indigo-600 hover:text-indigo-900">View more</a>
                                    </td>
                                    </tr>
                                        @empty
                                        <div>None</div>
                                        @endforelse
                                    <!-- More items... -->
                                </tbody>
                                </table>
                            </div>
                            </div>
                        </div>
                        </div>
                        @if($items->isNotEmpty() && $items->links())
                        {{$items->links()}}
                        @endif
                        @endsection