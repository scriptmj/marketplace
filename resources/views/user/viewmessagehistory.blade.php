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
                    @forelse($messages as $message)
                        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    
  <div class="border-t border-gray-200">
    <dl>
      <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <dt class="text-sm font-medium text-gray-500">
                From
            </dt>
            @if($message->fromUser == Auth::user())
            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                You
            </dd>
            @else
            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                <a href="{{route('profile.view', $message->from)}}">
                    {{$message->fromUser->name}}
                </a>
            </dd>
            @endif
      </div>
      <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
        <dt class="text-sm font-medium text-gray-500">
          Time
        </dt>
        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
            {{$message->created_at}}
        </dd>
      </div>
      <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
        <dt class="text-sm font-medium text-gray-500">
          Regarding item
        </dt>
        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
          @if($message->item)
          <a href="{{route('item.view', $message->item_ref)}}">
            {{ucfirst($message->item->item_name)}}
          </a>
          @endif
        </dd>
      </div>
      <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
        <dt class="text-sm font-medium text-gray-500">
          Message
        </dt>
        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
          {{$message->message}}
        </dd>
      </div>
    </dl>
  </div>
  </div>
  <br />
  @empty
  <div class="border-t border-gray-200">
    <dl>
      No messages at this time.
    </dl>
  </div>
  @endforelse

                    <!-- End content -->
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
