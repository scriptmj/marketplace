<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Payment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Content -->

<div class="mt-10 sm:mt-0">
  <div class="md:grid md:grid-cols-4 md:gap-6">
    <div class="md:col-span-1">
      <div class="px-4 sm:px-0">
        <h3 class="text-lg font-medium leading-6 text-gray-900">Confirm payment</h3>
        <p class="mt-1 text-sm text-gray-600">
          
        </p>
      </div>
    </div>
    <div class="mt-5 md:mt-0 md:col-span-3">
      <form action="{{route('payment.store', $invoice)}}" method="POST">
      @csrf
        <div class="shadow overflow-hidden sm:rounded-md">
          <div class="px-4 py-5 bg-white sm:p-6">
            <div class="grid grid-cols-6 gap-6">

            <!-- Item name -->
              <div class="col-span-6 sm:col-span-3">
                <label class="block text-sm font-medium text-gray-700">
                Invoice nr
                </label>
                <div class="mt-1">
                {{$invoice->id}}
                </div>
              </div>

            <!-- Short description -->
              <div class="col-span-6 sm:col-span-6">
              <label class="block text-sm font-medium text-gray-700">
                Regarding item
              </label>
              <div class="mt-1">
                {{ucfirst($invoice->item->item_name)}}
              </div>

                </div>

            <!-- Long description -->
                <div class="col-span-6 sm:col-span-6">
              <label class="block text-sm font-medium text-gray-700">
              Price
              <div class="mt-1">
                €{{number_format($invoice->price, 2)}}
              </div>
                </div>

<!-- Submit -->
          <div class="px-2 py-2 text-left sm:px-6">
            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
              Confirm
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

                    <!-- End content -->
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script src="../../js/image-upload.js"></script>