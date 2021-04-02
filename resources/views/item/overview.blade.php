@section('page')
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Home') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Content -->

                    <div id="category-choices" 
                    class="align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="text-sm text-gray-900">
                        <button 
                        onclick="toggleShowDiv('cat-buttons')"
                        class="inline-flex items-center px-2 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white">Filter by category</button>
                        <div id="cat-buttons" class="hidden">
                        @foreach($categories as $category)
                            <button id="cat {{$category->id}}" type="button" 
                            class="category btn btn-light inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" 
                            onClick="filterPostsByCategory('{{$category->id}}')">{{$category->name}}</button>
                        @endforeach
                        </div>
                        </div>
                    </div>
                    <div id="distance-search-options" 
                    class="inline-block align-middle min-w-full sm:px-6 lg:px-8">
                        <div class="text-sm text-gray-900">
                        <button 
                        onclick="toggleShowDiv('distance-search')"
                        class="inline-flex items-center px-2 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white">
                            Search by distance
                        </button>
                        <div id="distance-search" class="hidden">
                            <form action="{{route('item.searchbydistance')}}" method="POST">
                            @csrf
                                <input 
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm sm:text-sm border-gray-300 rounded-md"
                                type="number" 
                                name="distanceKm" 
                                id="distanceKm">
                                <button 
                                type="submit" 
                                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Search
                                </button>
                            </form>
                        </div>
                        </div>
                    </div>
                    <div id="keyword-search-options" 
                    class="inline-block align-middle min-w-full sm:px-6 lg:px-8">
                        <div class="text-sm text-gray-900">
                        <button 
                        onclick="toggleShowDiv('keyword-search')"
                        class="inline-flex items-center px-2 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white">
                            Search by keyword
                        </button>
                        <div id="keyword-search" class="hidden">
                            <form action="{{route('item.searchbykeyword')}}" method="POST">
                            @csrf
                                <input 
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm sm:text-sm border-gray-300 rounded-md"
                                type="text" 
                                name="keyword" 
                                id="keyword">
                                <button 
                                type="submit" 
                                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Search
                                </button>
                            </form>
                        </div>
                        </div>
                        <hr />
                    </div>


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
                                        Postcode
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
                                    <tr>
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
                                        @if(Auth::user())
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
                        @if($items->links())
                        {{$items->links()}}
                    @endif
                    @section('content')
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
                                        Postcode
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
                                    <tr>
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
                                        @if(Auth::user())
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
                        @endsection
                    <!-- End content -->
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
@endsection