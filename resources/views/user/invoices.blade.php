<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Notifications') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Content -->
                    @forelse($invoices as $invoice)
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">

  <div class="border-t border-gray-200">
    <dl>
      <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
        <dt class="text-sm font-medium text-gray-500">
          Time
        </dt>
        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
            {{$invoice->created_at}}
        </dd>
      </div>
      <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
        <dt class="text-sm font-medium text-gray-500">
          Regarding item
        </dt>
        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
          <a href="{{route('item.view', $invoice->item)}}">
            {{ucfirst($invoice->getItem->item_name)}}
          </a>
        </dd>
      </div>
      <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
        <dt class="text-sm font-medium text-gray-500">
          Price
        </dt>
        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
          {{$invoice->price}}
        </dd>
      </div>
    </dl>
  </div>
  </div>
  <br />
  @empty
  <div class="border-t border-gray-200">
    <dl>
      No notifications at this time.
    </dl>
  </div>
  @endforelse

                    <!-- End content -->
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
