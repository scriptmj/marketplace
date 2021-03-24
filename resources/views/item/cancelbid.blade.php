<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cancel bid') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Content -->
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                        <div class="px-4 py-5 sm:px-6">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                            {{ucfirst($item->item_name)}}
                            </h3>
                        </div>
                        <div class="border-t border-gray-200">
                            <dl>
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
                                    Your bid
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    You bid <strong>€{{number_format($offer->price, 2)}}</strong> on {{$offer->created_at}}
                                </dd>
                            </div>

                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">
                                Actions
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                
                                <form action="{{route('user.destroybid', $offer)}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                onclick="return confirm('Are you sure you want to cancel your bid?')">
                                    Cancel offer
                                </button>
                                </form>
                                </dd>
                            </div>
                            
                            </dl>
                        </div>
                        </div>
                    <!-- End content -->
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
